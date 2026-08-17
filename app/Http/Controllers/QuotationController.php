<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\PaymentTerm;
use App\Models\Quotation;
use App\Models\QuotationItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class QuotationController extends Controller
{
    /**
     * Display a listing of quotations.
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $quotations = Quotation::with('client')
            ->when($search, function ($query) use ($search) {
                $query->where('quotation_no', 'like', "%{$search}%")
                    ->orWhereHas('client', function ($q) use ($search) {
                        $q->where('company_name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('quotations.index', compact(
            'quotations',
            'search'
        ));
    }

    /**
     * Show the form for creating a quotation.
     */
    public function create()
    {
        $clients = Client::orderBy('company_name')->get();

        return view('quotations.create', compact('clients'));
    }

    /**
     * Store quotation.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id'            => 'required|exists:clients,id',
            'quotation_date'       => 'required|date',
            'validity_days'        => 'required|integer',
            'project_name'         => 'required|string|max:255',
            'project_description'  => 'required|string',
            'project_start'        => 'nullable|date',
            'project_end'          => 'nullable|date',

            'item_name.*'          => 'required|string',
            'quantity.*'           => 'required|numeric|min:1',
            'unit_price.*'         => 'required|numeric|min:0',
            'amount.*'             => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {

            $quotation = Quotation::create([
                'quotation_no' => $this->generateQuotationNumber(),
                'client_id' => $request->client_id,
                'quotation_date' => $request->quotation_date,
                'validity_days' => $request->validity_days,
                'project_name' => $request->project_name,
                'project_description' => $request->project_description,
                'project_start' => $request->project_start,
                'project_end' => $request->project_end,
                'subtotal' => $request->subtotal,
                'discount' => $request->discount ?? 0,
                'tax' => $request->tax ?? 0,
                'total' => $request->total,
                'status' => 'Draft',
            ]);

            // Save Items
            foreach ($request->item_name as $key => $item) {

                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'item_name' => $item,
                    'quantity' => $request->quantity[$key],
                    'unit_price' => $request->unit_price[$key],
                    'amount' => $request->amount[$key],
                    'sort_order' => $key + 1,
                ]);
            }

            // Save Payment Terms
            if ($request->payment_title) {

                foreach ($request->payment_title as $key => $title) {

                    PaymentTerm::create([
                        'quotation_id' => $quotation->id,
                        'title' => $title,
                        'percentage' => $request->payment_percentage[$key],
                        'description' => $request->payment_description[$key],
                        'sort_order' => $key + 1,
                    ]);
                }
            }

        });

        return redirect()
            ->route('quotations.index')
            ->with('success', 'Quotation created successfully.');
    }

    /**
     * Display quotation.
     */
    public function show(Quotation $quotation)
    {
        $quotation->load([
            'client',
            'items',
            'paymentTerms',
            'changeRequests'
        ]);

        return view('quotations.show', compact('quotation'));
    }

    /**
     * Edit quotation.
     */
    public function edit(Quotation $quotation)
    {
        $clients = Client::orderBy('company_name')->get();

        $quotation->load([
            'client',
            'items',
            'paymentTerms'
        ]);

        return view('quotations.edit', compact(
            'quotation',
            'clients'
        ));
    }

    /**
     * Update quotation.
     */
    public function update(Request $request, Quotation $quotation)
    {
        $request->validate([
            'client_id' => 'required',
            'quotation_date' => 'required|date',
            'project_name' => 'required',
            'project_description' => 'required',
        ]);

        DB::transaction(function () use ($request, $quotation) {

            $quotation->update([
                'client_id' => $request->client_id,
                'quotation_date' => $request->quotation_date,
                'validity_days' => $request->validity_days,
                'project_name' => $request->project_name,
                'project_description' => $request->project_description,
                'project_start' => $request->project_start,
                'project_end' => $request->project_end,
                'subtotal' => $request->subtotal,
                'discount' => $request->discount ?? 0,
                'tax' => $request->tax ?? 0,
                'total' => $request->total,
            ]);

            // Remove old items
            $quotation->items()->delete();

            foreach ($request->item_name as $key => $item) {

                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'item_name' => $item,
                    'quantity' => $request->quantity[$key],
                    'unit_price' => $request->unit_price[$key],
                    'amount' => $request->amount[$key],
                    'sort_order' => $key + 1,
                ]);
            }

            // Remove old payment terms
            $quotation->paymentTerms()->delete();

            if ($request->payment_title) {

                foreach ($request->payment_title as $key => $title) {

                    PaymentTerm::create([
                        'quotation_id' => $quotation->id,
                        'title' => $title,
                        'percentage' => $request->payment_percentage[$key],
                        'description' => $request->payment_description[$key],
                        'sort_order' => $key + 1,
                    ]);
                }
            }

        });

        return redirect()
            ->route('quotations.index')
            ->with('success', 'Quotation updated successfully.');
    }

    /**
     * Delete quotation.
     */
    public function destroy(Quotation $quotation)
    {
        $quotation->delete();

        return redirect()
            ->route('quotations.index')
            ->with('success', 'Quotation deleted successfully.');
    }

    /**
     * Generate quotation number.
     */
    private function generateQuotationNumber()
    {
        $year = date('Y');

        $count = Quotation::whereYear('created_at', $year)->count() + 1;

        return 'KNK-QUO-' . $year . str_pad($count, 3, '0', STR_PAD_LEFT);
    }

    public function downloadPdf(Quotation $quotation)
    {
        $quotation->load([
            'client',
            'items',
            'paymentTerms'
        ]);

        $pdf = Pdf::loadView('pdf.quotation', compact('quotation'));

        return $pdf->download($quotation->quotation_no . '.pdf');
    }
    }