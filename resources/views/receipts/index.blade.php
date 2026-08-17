@extends('layouts.app')

@section('title', 'Receipts')

@section('content')
<div class="container-fluid px-0">

    {{-- ============================================================
        PAGE HEADER
    ============================================================ --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                Receipts
            </h4>
            <p class="text-muted small mb-0">
                View and manage payment receipts generated from paid invoices.
            </p>
        </div>
    </div>

    {{-- ============================================================
        SUCCESS MESSAGE
    ============================================================ --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-xs rounded-3 mb-4 p-3 d-flex align-items-center">
            <i class="bi bi-check-circle-fill me-2.5 fs-5"></i>
            <div class="small fw-medium">{{ session('success') }}</div>
        </div>
    @endif

    {{-- ============================================================
        ERROR MESSAGE
    ============================================================ --}}
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-xs rounded-3 mb-4 p-3 d-flex align-items-center">
            <i class="bi bi-exclamation-triangle-fill me-2.5 fs-5"></i>
            <div class="small fw-medium">{{ session('error') }}</div>
        </div>
    @endif

    {{-- ============================================================
        RECEIPT LIST CARD
    ============================================================ --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="d-flex align-items-center">
                    <div class="p-2 bg-success bg-opacity-10 text-success rounded-3 me-3 d-flex align-items-center justify-content-center"
                         style="width:40px; height:40px;">
                        <i class="bi bi-receipt fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold text-dark mb-0">
                            Receipt Records
                        </h5>
                        <p class="text-muted small mb-0">
                            Official receipts generated after recording invoice payments.
                        </p>
                    </div>
                </div>

                <div class="text-muted small">
                    Total: <span class="fw-bold text-dark font-monospace">{{ $receipts->total() }}</span>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 custom-receipt-table">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase fs-7 font-semibold tracking-wider">
                                Receipt Ref
                            </th>
                            <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">
                                Linked Invoice
                            </th>
                            <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">
                                Client / Project
                            </th>
                            <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">
                                Payment Method
                            </th>
                            <th class="py-3 text-end text-uppercase fs-7 font-semibold tracking-wider">
                                Amount Paid
                            </th>
                            <th class="py-3 text-center pe-4 text-uppercase fs-7 font-semibold tracking-wider" width="110">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($receipts as $receipt)
                            <tr>
                                {{-- RECEIPT NO & DATE --}}
                                <td class="ps-4 py-3">
                                    <a href="{{ route('receipts.show', $receipt) }}"
                                       class="fw-bold font-monospace text-decoration-none receipt-link">
                                        {{ $receipt->receipt_no }}
                                    </a>

                                    <div class="text-muted small mt-0.5">
                                        <i class="bi bi-calendar3 me-1 opacity-75"></i>
                                        {{ $receipt->payment_date->format('d M Y') }}
                                    </div>
                                </td>

                                {{-- INVOICE LINK --}}
                                <td>
                                    <a href="{{ route('invoices.show', $receipt->invoice) }}"
                                       class="fw-semibold font-monospace text-secondary text-decoration-none small">
                                        {{ $receipt->invoice->invoice_no }}
                                    </a>

                                    <div class="mt-1">
                                        <span class="badge rounded-pill px-2.5 py-1 small font-medium"
                                              style="background-color: #EBF5EC; color: #21512A;">
                                            <i class="bi bi-patch-check-fill me-1"></i>
                                            Paid
                                        </span>
                                    </div>
                                </td>

                                {{-- CLIENT / PROJECT --}}
                                <td>
                                    <div class="fw-semibold text-dark">
                                        {{ $receipt->invoice->quotation->client->company_name }}
                                    </div>
                                    <div class="text-muted small">
                                        {{ $receipt->invoice->quotation->project_name }}
                                    </div>
                                </td>

                                {{-- PAYMENT DETAILS --}}
                                <td>
                                    <div class="fw-medium text-dark small">
                                        <i class="bi bi-credit-card me-1 text-muted"></i>
                                        {{ $receipt->payment_method }}
                                    </div>

                                    @if($receipt->reference_no)
                                        <div class="text-muted small mt-0.5 font-monospace">
                                            Ref: {{ $receipt->reference_no }}
                                        </div>
                                    @else
                                        <div class="text-muted small mt-0.5 opacity-75">
                                            No ref. provided
                                        </div>
                                    @endif
                                </td>

                                {{-- AMOUNT RECEIVED --}}
                                <td class="text-end">
                                    <div class="fw-bold text-dark font-monospace fs-6">
                                        RM {{ number_format($receipt->amount_received, 2) }}
                                    </div>
                                </td>

                                {{-- ACTIONS --}}
                                <td class="text-center pe-4">
                                    <div class="d-flex justify-content-center align-items-center gap-1.5">
                                        {{-- VIEW --}}
                                        <a href="{{ route('receipts.show', $receipt) }}"
                                           class="btn btn-action shadow-xs border text-secondary bg-white rounded-3"
                                           title="View Receipt Details">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        {{-- PDF --}}
                                        <a href="{{ route('receipts.pdf', $receipt) }}"
                                           class="btn btn-action-danger shadow-xs border rounded-3"
                                           title="Download Receipt PDF">
                                            <i class="bi bi-file-earmark-pdf-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <div class="py-4">
                                        <div class="d-inline-flex p-3 bg-light rounded-circle text-muted mb-3 opacity-75">
                                            <i class="bi bi-receipt fs-1 px-1"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">No Receipts Yet</h5>
                                        <p class="text-muted small mb-0">Receipts will appear here after payments are recorded for invoices.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- PAGINATION --}}
        @if($receipts->hasPages())
            <div class="px-4 py-3 border-top bg-light custom-pagination-pane">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="text-muted small">
                        Showing
                        <strong>{{ $receipts->firstItem() }}</strong>
                        to
                        <strong>{{ $receipts->lastItem() }}</strong>
                        of
                        <strong>{{ $receipts->total() }}</strong>
                        receipts
                    </div>

                    <div>
                        {{ $receipts->links() }}
                    </div>
                </div>
            </div>
        @endif

    </div>

</div>

<style>
    .fs-7 {
        font-size: 0.75rem !important;
    }
    .shadow-xs {
        box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
    }
    .receipt-link {
        color: var(--accent-brown, #8C6D53);
        transition: color 0.15s ease;
    }
    .receipt-link:hover {
        color: #5C4635;
    }

    /* Table Adjustments */
    .custom-receipt-table thead th {
        font-weight: 600;
        border-bottom: 1px solid #ECEBE9;
    }
    .custom-receipt-table tbody tr {
        border-bottom: 1px solid #F3F2F0;
        transition: background-color 0.15s ease;
    }
    .custom-receipt-table tbody tr:last-child {
        border-bottom: 0;
    }
    .custom-receipt-table tbody tr:hover {
        background-color: #FAF9F8;
    }

    /* Action Buttons */
    .btn-action {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }
    .btn-action:hover {
        background-color: #FBFBFA !important;
        transform: translateY(-1px);
    }

    .btn-action-danger {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        color: #DC3545;
        background-color: #FFFFFF;
        border-color: #F8D7DA !important;
        transition: all 0.2s ease;
    }
    .btn-action-danger:hover {
        background-color: #DC3545;
        color: #FFFFFF;
        border-color: #DC3545 !important;
        transform: translateY(-1px);
    }

    .custom-pagination-pane nav {
        margin-bottom: 0 !important;
    }
</style>
@endsection