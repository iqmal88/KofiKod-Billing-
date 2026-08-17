@extends('layouts.app')

@section('title', 'Receipt Details')

@section('content')
<div class="container-fluid px-0">

    {{-- ============================================================
        PAGE HEADER
    ============================================================ --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="text-muted small text-uppercase tracking-wider fw-semibold font-monospace">{{ $receipt->receipt_no }}</span>
                <span class="badge rounded-pill px-3 py-1.5 small font-medium"
                      style="background-color: #EBF5EC; color: #21512A;">
                    <i class="bi bi-patch-check-fill me-1"></i>
                    Paid
                </span>
            </div>

            <h4 class="fw-bold text-dark mb-0">
                Receipt Overview
            </h4>
        </div>

        {{-- HEADER ACTIONS --}}
        <div class="d-flex align-items-center gap-2 flex-wrap">

            {{-- BACK --}}
            <a href="{{ route('receipts.index') }}"
               class="btn btn-light border text-secondary px-3 py-2 rounded-3 d-inline-flex align-items-center small font-medium shadow-xs">
                <i class="bi bi-arrow-left me-1.5"></i>
                Back to List
            </a>

            {{-- VIEW INVOICE --}}
            <a href="{{ route('invoices.show', $receipt->invoice) }}"
               class="btn btn-light border text-dark px-3 py-2 rounded-3 d-inline-flex align-items-center small font-medium shadow-xs">
                <i class="bi bi-receipt me-1.5 text-muted"></i>
                View Invoice
            </a>

            {{-- DOWNLOAD PDF --}}
            <a href="{{ route('receipts.pdf', $receipt) }}"
               class="btn btn-danger px-3 py-2 rounded-3 d-inline-flex align-items-center small font-medium shadow-xs">
                <i class="bi bi-file-earmark-pdf-fill me-1.5"></i>
                Download PDF
            </a>

        </div>

    </div>

    {{-- ============================================================
        SUCCESS / ERROR FLASH ALERTS
    ============================================================ --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-xs rounded-3 mb-4 p-3 d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2.5 fs-5"></i>
            <div class="small fw-medium">{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-xs rounded-3 mb-4 p-3 d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill me-2.5 fs-5"></i>
            <div class="small fw-medium">{{ session('error') }}</div>
        </div>
    @endif

    <div class="row g-4">

        {{-- ========================================================
            LEFT SIDE - CORE DETAILS
        ======================================================== --}}
        <div class="col-lg-8">

            {{-- RECEIPT INFORMATION --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">

                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <div class="d-flex align-items-center">
                        <div class="p-2 bg-success bg-opacity-10 text-success rounded-3 me-3 d-flex align-items-center justify-content-center"
                             style="width:40px; height:40px;">
                            <i class="bi bi-receipt fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">
                                Receipt Information
                            </h5>
                            <p class="text-muted small mb-0">
                                Official transaction payment record log.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 pt-2">
                    <div class="row g-3">

                        {{-- RECEIPT NUMBER --}}
                        <div class="col-md-6">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Receipt Reference</span>
                            <span class="text-dark fw-bold font-monospace fs-6 mt-1 d-block">{{ $receipt->receipt_no }}</span>
                        </div>

                        {{-- PAYMENT DATE --}}
                        <div class="col-md-6">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Payment Date</span>
                            <span class="text-secondary small fw-medium mt-1 d-block">
                                <i class="bi bi-calendar3 me-1.5 opacity-75"></i>
                                {{ $receipt->payment_date->format('d M Y') }}
                            </span>
                        </div>

                        <hr class="my-2 opacity-50 border-light col-12">

                        {{-- PAYMENT METHOD --}}
                        <div class="col-md-6">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Payment Method</span>
                            <span class="text-dark fw-semibold small mt-1 d-block">
                                <i class="bi bi-credit-card me-1 text-muted"></i>
                                {{ $receipt->payment_method }}
                            </span>
                        </div>

                        {{-- PAYMENT REFERENCE --}}
                        <div class="col-md-6">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Transaction Reference</span>
                            @if($receipt->reference_no)
                                <span class="fw-semibold font-monospace text-dark small mt-1 d-block">
                                    {{ $receipt->reference_no }}
                                </span>
                            @else
                                <span class="text-muted small opacity-75 mt-1 d-block">
                                    — None Provided —
                                </span>
                            @endif
                        </div>

                    </div>
                </div>

            </div>

            {{-- RECEIVED FROM (CLIENT & PROJECT) --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">

                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <div class="d-flex align-items-center">
                        <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-3 me-3 d-flex align-items-center justify-content-center"
                             style="width:40px; height:40px;">
                            <i class="bi bi-building fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">
                                Received From
                            </h5>
                            <p class="text-muted small mb-0">
                                Client account profile and project details.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 pt-2">
                    <div class="row g-3">

                        {{-- CLIENT --}}
                        <div class="col-md-6">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Client Profile</span>
                            <span class="fw-bold text-dark fs-6 mt-1 d-block">
                                {{ $receipt->invoice->quotation->client->company_name }}
                            </span>
                        </div>

                        {{-- PROJECT --}}
                        <div class="col-md-6">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Project Assignment</span>
                            <span class="fw-semibold text-dark small mt-1 d-block">
                                {{ $receipt->invoice->quotation->project_name }}
                            </span>
                        </div>

                        <hr class="my-2 opacity-50 border-light col-12">

                        {{-- EMAIL --}}
                        @if($receipt->invoice->quotation->client->email)
                            <div class="col-md-6">
                                <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Email Address</span>
                                <span class="text-secondary small mt-1 d-block">
                                    <i class="bi bi-envelope me-1 opacity-75"></i>
                                    {{ $receipt->invoice->quotation->client->email }}
                                </span>
                            </div>
                        @endif

                        {{-- PHONE --}}
                        @if($receipt->invoice->quotation->client->phone)
                            <div class="col-md-6">
                                <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Contact Phone</span>
                                <span class="text-secondary small mt-1 d-block">
                                    <i class="bi bi-telephone me-1 opacity-75"></i>
                                    {{ $receipt->invoice->quotation->client->phone }}
                                </span>
                            </div>
                        @endif

                    </div>
                </div>

            </div>

            {{-- RELATED INVOICE & BREAKDOWN --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="d-flex align-items-center">
                            <div class="p-2 bg-secondary bg-opacity-10 text-secondary rounded-3 me-3 d-flex align-items-center justify-content-center"
                                 style="width:40px; height:40px;">
                                <i class="bi bi-file-earmark-text fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">
                                    Related Invoice
                                </h5>
                                <p class="text-muted small mb-0">
                                    Account ledger items cleared by this payment.
                                </p>
                            </div>
                        </div>

                        <a href="{{ route('invoices.show', $receipt->invoice) }}"
                           class="btn btn-light border btn-sm text-secondary rounded-3 px-3 font-medium shadow-xs">
                            View Full Invoice
                            <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body p-4 pt-2">

                    <div class="row g-3 mb-3">
                        {{-- INVOICE NO --}}
                        <div class="col-md-4">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Invoice Number</span>
                            <a href="{{ route('invoices.show', $receipt->invoice) }}" class="fw-bold font-monospace cr-link mt-1 d-inline-block">
                                {{ $receipt->invoice->invoice_no }}
                            </a>
                        </div>

                        {{-- INVOICE DATE --}}
                        <div class="col-md-4">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Invoice Date</span>
                            <span class="text-secondary small fw-medium mt-1 d-block">
                                <i class="bi bi-calendar3 me-1 opacity-75"></i>
                                {{ $receipt->invoice->invoice_date->format('d M Y') }}
                            </span>
                        </div>

                        {{-- INVOICE STATUS --}}
                        <div class="col-md-4">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide mb-1">Current Status</span>
                            <span class="badge rounded-pill px-3 py-1.5 small font-medium" style="background-color: #EBF5EC; color: #21512A;">
                                <i class="bi bi-patch-check-fill me-1"></i>
                                {{ $receipt->invoice->status }}
                            </span>
                        </div>
                    </div>

                    {{-- INVOICE ITEMS LIST --}}
                    @if($receipt->invoice->items->count())

                        <hr class="my-3 opacity-50 border-light">

                        <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide mb-2.5">Payment For (Invoice Items)</span>

                        <div class="d-flex flex-column gap-2">
                            @foreach($receipt->invoice->items as $item)

                                <div class="p-3 rounded-3 bg-light border-0 d-flex justify-content-between align-items-center gap-3">

                                    <div>
                                        <div class="fw-bold text-dark small">
                                            @if(($item->type ?? $item->item_type) === 'payment_phase' && $item->paymentTerm)
                                                {{ $item->paymentTerm->title }}
                                            @elseif(($item->type ?? $item->item_type) === 'change_request' && $item->changeRequest)
                                                {{ $item->changeRequest->title }}
                                            @else
                                                {{ $item->description }}
                                            @endif
                                        </div>

                                        @if(($item->type ?? $item->item_type) === 'payment_phase' && $item->paymentTerm && $item->paymentTerm->description)
                                            <div class="text-muted small mt-0.5">
                                                {{ $item->paymentTerm->description }}
                                            </div>
                                        @elseif(($item->type ?? $item->item_type) === 'change_request')
                                            <div class="text-muted small mt-0.5">
                                                Additional Change Request Scope
                                            </div>
                                        @endif
                                    </div>

                                    <div class="fw-bold font-monospace text-dark text-nowrap">
                                        RM {{ number_format($item->amount, 2) }}
                                    </div>

                                </div>

                            @endforeach
                        </div>

                    @endif

                </div>

            </div>

        </div>

        {{-- ========================================================
            RIGHT SIDE - ACCOUNTING SUMMARY
        ======================================================== --}}
        <div class="col-lg-4">

            {{-- PAYMENT SUMMARY CARD --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                        <i class="bi bi-calculator me-2 text-muted"></i>
                        Payment Summary
                    </h5>
                </div>

                <div class="card-body p-4 pt-2">

                    {{-- INVOICE TOTAL --}}
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-secondary small">Invoice Total</span>
                        <span class="font-monospace fw-medium text-dark">
                            RM {{ number_format($receipt->invoice->total, 2) }}
                        </span>
                    </div>

                    {{-- AMOUNT RECEIVED --}}
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-secondary small">Amount Received</span>
                        <span class="font-monospace fw-bold text-success">
                            RM {{ number_format($receipt->amount_received, 2) }}
                        </span>
                    </div>

                    <hr class="my-3 opacity-50 border-light">

                    {{-- BALANCE DUE --}}
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold text-dark small text-uppercase tracking-wide">Outstanding Balance</span>
                        <span class="fw-bold fs-5 text-dark font-monospace">
                            RM {{ number_format(max($receipt->invoice->total - $receipt->amount_received, 0), 2) }}
                        </span>
                    </div>

                </div>

            </div>

            {{-- TOTAL RECEIVED HIGHLIGHT BOX --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background-color: #EBF5EC;">

                <div class="card-body p-4">

                    <span class="small fw-semibold text-uppercase tracking-wider d-block mb-1" style="color: #21512A;">
                        Total Settled Amount
                    </span>

                    <div class="fw-bold fs-3 font-monospace mb-1" style="color: #21512A;">
                        RM {{ number_format($receipt->amount_received, 2) }}
                    </div>

                    <div class="small d-flex align-items-center fw-medium" style="color: #21512A;">
                        <i class="bi bi-patch-check-fill me-1.5"></i>
                        Payment received in full
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<style>
    .tracking-wider { letter-spacing: 0.5px; }
    .tracking-wide { letter-spacing: 0.3px; font-size: 11px !important; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important; }

    .cr-link {
        color: var(--accent-brown, #8C6D53);
        transition: color 0.15s ease;
    }
    .cr-link:hover {
        color: #5C4635;
    }
</style>
@endsection