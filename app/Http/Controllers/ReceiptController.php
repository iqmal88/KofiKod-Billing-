<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Receipt;
use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReceiptController extends Controller
{
    /**
     * Display all receipts.
     */
    public function index()
    {
        $receipts = Receipt::with([
                'invoice.quotation.client'
            ])
            ->latest()
            ->paginate(10);

        return view(
            'receipts.index',
            compact('receipts')
        );
    }


    /**
     * Show payment form for an invoice.
     */
    public function create(Invoice $invoice)
    {
        $invoice->load([
            'quotation.client',
            'receipt',
        ]);

        // Prevent duplicate receipt
        if ($invoice->receipt) {

            return redirect()
                ->route('receipts.show', $invoice->receipt)
                ->with(
                    'error',
                    'A receipt has already been generated for this invoice.'
                );
        }

        return view(
            'receipts.create',
            compact('invoice')
        );
    }


    /**
     * Record payment and generate receipt.
     */
    public function store(Request $request, Invoice $invoice)
    {
        $request->validate([
            'payment_date' => [
                'required',
                'date',
            ],

            'payment_method' => [
                'required',
                'string',
                'max:100',
            ],

            'reference_no' => [
                'nullable',
                'string',
                'max:255',
            ],

            'amount_received' => [
                'required',
                'numeric',
                'min:0.01',
                function ($attribute, $value, $fail) use ($invoice) {

                    if (round((float) $value, 2) !== round((float) $invoice->total, 2)) {

                        $fail(
                            'The amount received must equal the invoice total of RM '
                            . number_format($invoice->total, 2)
                            . '.'
                        );

                    }

                },
            ],
        ]);


        // Prevent duplicate receipt
        if ($invoice->receipt) {

            return redirect()
                ->route('receipts.show', $invoice->receipt)
                ->with(
                    'error',
                    'A receipt has already been generated for this invoice.'
                );
        }


        DB::transaction(function () use ($request, $invoice) {

            /*
            |--------------------------------------------------------------------------
            | Generate Receipt Number
            |--------------------------------------------------------------------------
            */

            $year = date('Y');

            $latestReceipt = Receipt::where(
                    'receipt_no',
                    'like',
                    'KNK-RCP-' . $year . '%'
                )
                ->orderByDesc('receipt_no')
                ->first();


            if ($latestReceipt) {

                $lastNumber = (int) substr(
                    $latestReceipt->receipt_no,
                    -3
                );

                $nextNumber = $lastNumber + 1;

            } else {

                $nextNumber = 1;

            }


            $receiptNo =
                'KNK-RCP-'
                . $year
                . str_pad(
                    $nextNumber,
                    3,
                    '0',
                    STR_PAD_LEFT
                );


            /*
            |--------------------------------------------------------------------------
            | Create Receipt
            |--------------------------------------------------------------------------
            */

            Receipt::create([

                'invoice_id' => $invoice->id,

                'receipt_no' => $receiptNo,

                'payment_date' => $request->payment_date,

                'payment_method' => $request->payment_method,

                'reference_no' => $request->reference_no,

                'amount_received' => $request->amount_received,

            ]);


            /*
            |--------------------------------------------------------------------------
            | Update Invoice Status
            |--------------------------------------------------------------------------
            */

            $invoice->update([

                'status' => 'Paid',

                'payment_date' => $request->payment_date,

            ]);

        });


        return redirect()
            ->route('receipts.index')
            ->with(
                'success',
                'Payment recorded and receipt generated successfully.'
            );
    }


    /**
     * Display receipt details.
     */
    public function show(Receipt $receipt)
    {
        $receipt->load([
            'invoice.quotation.client',
            'invoice.items.paymentTerm',
            'invoice.items.changeRequest.items',
        ]);

        $company = CompanySetting::first();

        return view(
            'receipts.show',
            compact(
                'receipt',
                'company'
            )
        );
    }


    /**
     * Download receipt PDF.
     */
    public function downloadPdf(Receipt $receipt)
    {
        $receipt->load([
            'invoice.quotation.client',
            'invoice.items.paymentTerm',
            'invoice.items.changeRequest.items',
        ]);

        $company = CompanySetting::first();


        $pdf = Pdf::loadView(
            'pdf.receipt',
            compact(
                'receipt',
                'company'
            )
        );


        return $pdf->download(
            $receipt->receipt_no . '.pdf'
        );
    }
}