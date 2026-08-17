@extends('layouts.app')

@section('title', 'Invoice Details')

@section('content')
<div class="container-fluid px-0">
    
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <span class="text-muted small text-uppercase tracking-wider fw-semibold font-monospace">{{ $invoice->invoice_no }}</span>
            <h4 class="text-dark fw-bold mb-0">Invoice Overview</h4>
        </div>
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('invoices.index') }}" class="btn btn-light border text-secondary px-3 py-2 rounded-3 d-inline-flex align-items-center small font-medium">
                <i class="bi bi-arrow-left me-2"></i> Back to List
            </a>
            
            <a href="{{ route('invoices.pdf', $invoice) }}" class="btn btn-danger px-3 py-2 rounded-3 d-inline-flex align-items-center small font-medium shadow-xs">
                <i class="bi bi-file-earmark-pdf-fill me-2"></i> Download PDF
            </a>

            @if($invoice->status === 'Pending')

                <a href="{{ route('receipts.create', $invoice) }}"
                class="btn btn-success">

                    <i class="bi bi-cash-coin me-2"></i>
                    Record Payment

                </a>

            @elseif($invoice->status === 'Paid')

                @if($invoice->receipt)

                    <a href="{{ route('receipts.show', $invoice->receipt) }}"
                    class="btn btn-success">

                        <i class="bi bi-receipt me-2"></i>
                        View Receipt

                    </a>

                @else

                    <span class="btn btn-light border text-muted disabled">

                        <i class="bi bi-exclamation-circle me-2"></i>
                        Receipt Not Available

                    </span>

                @endif

            @endif
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-file-earmark-text text-muted me-2.5"></i> Administrative Metadata
                    </h5>
                </div>
                
                <div class="card-body px-4 pb-4 pt-2">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Client Profile</span>
                            <span class="text-dark fw-bold fs-6 d-block mt-1">{{ $invoice->quotation->client->company_name }}</span>
                        </div>

                        <div class="col-md-6">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Project Assignment</span>
                            <span class="text-dark fw-semibold fs-6 d-block mt-1">{{ $invoice->quotation->project_name }}</span>
                        </div>

                        <hr class="my-2 opacity-50 border-light col-12">

                        <div class="col-sm-6">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Payment Milestone Stage</span>
                            <div class="mt-2">
                                <span class="badge bg-light border text-secondary rounded-2 px-3 py-2 small font-medium">
                                    <i class="bi bi-layers-half me-1.5 text-muted"></i>{{ $invoice->payment_stage }}
                                </span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Issue Logged Date</span>
                            <span class="text-secondary d-block mt-2 small fw-medium">
                                <i class="bi bi-calendar3 me-2 opacity-75"></i>{{ $invoice->invoice_date->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-shield-check me-2 text-muted"></i>Ledger Status</h6>
                </div>
                
                <div class="card-body p-4 pt-2">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <span class="text-secondary small">Payment Standing</span>
                        @if($invoice->status == 'Paid')
                            <span class="badge rounded-pill px-3 py-1.5 small font-medium" style="background-color: #EBF5EC; color: #21512A; font-weight: 500;">
                                <i class="bi bi-patch-check-fill me-1"></i> Paid
                            </span>
                        @else
                            <span class="badge rounded-pill px-3 py-1.5 small font-medium" style="background-color: #FFF8E6; color: #8A6D3B; font-weight: 500;">
                                <i class="bi bi-clock-history me-1"></i> Pending Payment
                            </span>
                        @endif
                    </div>

                    <hr class="my-3 opacity-50">

                    <div class="p-3 rounded-3" style="background-color: #F4F6F4;">
                        <span class="fw-bold text-dark small text-uppercase tracking-wider d-block mb-1">Total Due Amount</span>
                        <div class="d-flex align-items-baseline justify-content-between">
                            <span class="small font-medium text-success fw-bold">RM</span>
                            <span class="font-monospace fw-bold fs-4 text-dark">{{ number_format($invoice->total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling adjustments built to establish premium spacing profiles */
    .tracking-wider { letter-spacing: 0.5px; }
    .tracking-wide { letter-spacing: 0.3px; font-size: 11px !important; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important; }
    .btn-submit-action:hover {
        background-color: #2D3E29 !important;
    }
</style>
@endsection