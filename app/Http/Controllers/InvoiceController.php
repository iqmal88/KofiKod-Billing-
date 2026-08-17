<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Quotation;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class InvoiceController extends Controller
{
    /**
     * Display a paginated list of all generated invoices.
     */
    public function index(): View
    {
        $invoices = Invoice::with([
                'quotation.client',
                'items',
            ])
            ->latest()
            ->paginate(10);

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Display the form to generate an invoice from a specific quotation.
     */
    public function generate(Quotation $quotation): View
    {
        $quotation->load([
            'client',
            'paymentTerms',
            'changeRequests.items',
        ]);

        // Get IDs of payment terms already invoiced for this quotation
        $usedPaymentTermIds = InvoiceItem::where('item_type', 'payment_phase')
            ->whereNotNull('payment_term_id')
            ->whereHas('invoice', function ($query) use ($quotation) {
                $query->where('quotation_id', $quotation->id);
            })
            ->pluck('payment_term_id')
            ->toArray();

        // Get available payment terms that haven't been invoiced yet
        $availablePaymentTerms = $quotation->paymentTerms
            ->whereNotIn('id', $usedPaymentTermIds);

        // Get IDs of change requests already invoiced for this quotation
        $usedChangeRequestIds = InvoiceItem::where('item_type', 'change_request')
            ->whereNotNull('change_request_id')
            ->whereHas('invoice', function ($query) use ($quotation) {
                $query->where('quotation_id', $quotation->id);
            })
            ->pluck('change_request_id')
            ->toArray();

        // Get available approved change requests
        $availableChangeRequests = $quotation->changeRequests
            ->where('status', 'Approved')
            ->whereNotIn('id', $usedChangeRequestIds);

        return view('invoices.generate', compact(
            'quotation',
            'availablePaymentTerms',
            'availableChangeRequests'
        ));
    }

    /**
     * Store a newly created invoice and its itemized entries in the database.
     */
    public function store(Request $request, Quotation $quotation): RedirectResponse
    {
        // 1. Request Input Validation
        $request->validate([
            'invoice_date' => ['required', 'date'],
            'due_date' => ['required', 'date', 'after_or_equal:invoice_date'],
            'payment_terms' => ['nullable', 'array'],
            'payment_terms.*' => ['integer'],
            'change_requests' => ['nullable', 'array'],
            'change_requests.*' => ['integer'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'tax' => ['nullable', 'numeric', 'min:0'],
        ]);

        $selectedPaymentTermIds = $request->input('payment_terms', []);
        $selectedChangeRequestIds = $request->input('change_requests', []);

        // 2. Business Rule: Must select at least one item
        if (empty($selectedPaymentTermIds) && empty($selectedChangeRequestIds)) {
            return back()
                ->withInput()
                ->withErrors([
                    'invoice_items' => 'Please select at least one payment phase or change request.'
                ]);
        }

        // 3. Fetch models linked to this quotation
        $paymentTerms = $quotation->paymentTerms()
            ->whereIn('id', $selectedPaymentTermIds)
            ->get();

        $changeRequests = $quotation->changeRequests()
            ->whereIn('id', $selectedChangeRequestIds)
            ->where('status', 'Approved')
            ->get();

        // Validate selected IDs ownership
        if ($paymentTerms->count() !== count($selectedPaymentTermIds)) {
            return back()
                ->withInput()
                ->withErrors([
                    'invoice_items' => 'One or more selected payment phases are invalid.'
                ]);
        }

        if ($changeRequests->count() !== count($selectedChangeRequestIds)) {
            return back()
                ->withInput()
                ->withErrors([
                    'invoice_items' => 'One or more selected change requests are invalid or not approved.'
                ]);
        }

        // 4. Prevent duplicate invoicing checks
        $alreadyInvoicedPaymentTerms = InvoiceItem::where('item_type', 'payment_phase')
            ->whereIn('payment_term_id', $selectedPaymentTermIds)
            ->whereHas('invoice', function ($query) use ($quotation) {
                $query->where('quotation_id', $quotation->id);
            })
            ->exists();

        if ($alreadyInvoicedPaymentTerms) {
            return back()
                ->withInput()
                ->withErrors([
                    'invoice_items' => 'One or more selected payment phases have already been invoiced.'
                ]);
        }

        $alreadyInvoicedChangeRequests = InvoiceItem::where('item_type', 'change_request')
            ->whereIn('change_request_id', $selectedChangeRequestIds)
            ->whereHas('invoice', function ($query) use ($quotation) {
                $query->where('quotation_id', $quotation->id);
            })
            ->exists();

        if ($alreadyInvoicedChangeRequests) {
            return back()
                ->withInput()
                ->withErrors([
                    'invoice_items' => 'One or more selected change requests have already been invoiced.'
                ]);
        }

        // 5. Calculate Subtotals & Totals
        $paymentPhaseTotal = 0;
        foreach ($paymentTerms as $term) {
            $paymentPhaseTotal += ($quotation->total * $term->percentage) / 100;
        }

        $changeRequestTotal = $changeRequests->sum('total');
        $subtotal = $paymentPhaseTotal + $changeRequestTotal;
        $discount = (float) $request->input('discount', 0);
        $tax = (float) $request->input('tax', 0);

        $total = max(0, $subtotal - $discount + $tax);

        // 6. Execute Atomic Database Transaction
        $invoice = DB::transaction(function () use (
            $request,
            $quotation,
            $paymentTerms,
            $changeRequests,
            $subtotal,
            $discount,
            $tax,
            $total
        ) {
            $invoiceNo = $this->generateInvoiceNumber();

            $invoice = Invoice::create([
                'quotation_id' => $quotation->id,
                'invoice_no' => $invoiceNo,
                'invoice_date' => $request->invoice_date,
                'due_date' => $request->due_date,
                'payment_stage' => null,
                'payment_percentage' => null,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'status' => 'Pending',
            ]);

            // Create Payment Phase Line Items
            foreach ($paymentTerms as $term) {
                $amount = ($quotation->total * $term->percentage) / 100;

                $invoice->items()->create([
                    'item_type' => 'payment_phase',
                    'payment_term_id' => $term->id,
                    'change_request_id' => null,
                    'title' => $term->title,
                    'description' => $term->description,
                    'percentage' => $term->percentage,
                    'amount' => round($amount, 2),
                ]);
            }

            // Create Change Request Line Items
            foreach ($changeRequests as $changeRequest) {
                $invoice->items()->create([
                    'item_type' => 'change_request',
                    'payment_term_id' => null,
                    'change_request_id' => $changeRequest->id,
                    'title' => $changeRequest->change_request_no . ' - ' . $changeRequest->title,
                    'description' => $changeRequest->description,
                    'percentage' => null,
                    'amount' => $changeRequest->total,
                ]);
            }

            return $invoice;
        });

        return redirect()
            ->route('invoices.show', $invoice)
            ->with('success', 'Invoice generated successfully.');
    }

    /**
     * Display the specified invoice details.
     */
    public function show(Invoice $invoice): View
    {
        $invoice->load([
            'quotation.client',
            'quotation.items',
            'items.paymentTerm',
            'items.changeRequest.items',
            'receipt',
        ]);

        $company = CompanySetting::first();

        return view('invoices.show', compact('invoice', 'company'));
    }

    /**
     * Mark the status of an unpaid invoice as Paid.
     */
    public function markAsPaid(Request $request, Invoice $invoice): RedirectResponse
    {
        $invoice->update([
            'status' => 'Paid',
            'payment_date' => now(),
        ]);

        return redirect()
            ->route('invoices.show', $invoice)
            ->with('success', 'Invoice marked as paid.');
    }

    /**
     * Generate and download the compiled PDF document for an invoice.
     */
    public function downloadPdf(Invoice $invoice)
    {
        $invoice->load([
            'quotation.client',
            'quotation.items',

            // Normal payment phase
            'items.paymentTerm',

            // Change request + its items
            'items.changeRequest.items',
        ]);

        $company = CompanySetting::first();

        $pdf = Pdf::loadView('pdf.invoice', compact(
            'invoice',
            'company'
        ));

        return $pdf->download(
            $invoice->invoice_no . '.pdf'
        );
    }

    /**
     * Remove the specified unpaid invoice from storage.
     */
    public function destroy(Invoice $invoice): RedirectResponse
    {
        // Business Rule: Prevent deletion of paid invoices
        if ($invoice->status === 'Paid') {
            return redirect()
                ->route('invoices.index')
                ->with('error', 'A paid invoice cannot be deleted.');
        }

        $invoice->delete();

        return redirect()
            ->route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }

    /**
     * Helper: Generate a unique formatted invoice reference number.
     */
    private function generateInvoiceNumber(): string
    {
        $year = date('Y');

        $latestInvoice = Invoice::where('invoice_no', 'like', 'KNK-INV-' . $year . '%')
            ->orderByDesc('invoice_no')
            ->first();

        $nextNumber = $latestInvoice ? ((int) substr($latestInvoice->invoice_no, -3)) + 1 : 1;

        return 'KNK-INV-' . $year . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
}