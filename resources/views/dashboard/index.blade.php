@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-0">
    
    <div class="row align-items-center mb-4">
        <div class="col">
            <h4 class="text-dark fw-bold mb-1">Dashboard Overview</h4>
            <p class="text-muted small mb-0">Welcome back, <span class="fw-semibold text-dark">{{ auth()->user()->name }}</span> 👋 Here is your office performance tracking data.</p>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card shadow-sm border-0 rounded-4 h-100 transition-hover">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small d-block mb-1 fw-medium uppercase-tracking">Total Clients</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $totalClients }}</h2>
                    </div>
                    <div class="metric-icon-box bg-success bg-opacity-10 text-success rounded-3">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card shadow-sm border-0 rounded-4 h-100 transition-hover">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small d-block mb-1 fw-medium uppercase-tracking">Quotations Issued</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $totalQuotations }}</h2>
                    </div>
                    <div class="metric-icon-box bg-secondary bg-opacity-10 text-muted rounded-3">
                        <i class="bi bi-file-earmark-text-fill fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card shadow-sm border-0 rounded-4 h-100 transition-hover">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small d-block mb-1 fw-medium uppercase-tracking">Invoices Logged</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $totalInvoices }}</h2>
                    </div>
                    <div class="metric-icon-box bg-primary bg-opacity-10 text-primary rounded-3">
                        <i class="bi bi-receipt fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card shadow-sm border-0 rounded-4 h-100 transition-hover">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small d-block mb-1 fw-medium uppercase-tracking">Receipts Issued</span>
                        <h2 class="fw-bold mb-0 text-dark">{{ $totalReceipts }}</h2>
                    </div>
                    <div class="metric-icon-box bg-info bg-opacity-10 text-info rounded-3">
                        <i class="bi bi-wallet2 fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 text-white overflow-hidden" style="background: linear-gradient(135deg, #1E291B 0%, #2D3E29 100%);">
                <div class="card-body p-4 position-relative">
                    <div class="position-absolute end-0 bottom-0 opacity-10 mb-n3 me-n2">
                        <i class="bi bi-cash-stack" style="font-size: 9rem;"></i>
                    </div>
                    <span class="text-white-50 small d-block mb-1 fw-medium tracking-wide text-uppercase">Collected Revenue</span>
                    <h2 class="fw-bold mb-2">RM {{ number_format($totalRevenue, 2) }}</h2>
                    <div class="d-flex align-items-center gap-2 mt-3">
                        <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-3 py-1 small">
                            <i class="bi bi-shield-check me-1"></i> Paid & Settled
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 text-white overflow-hidden" style="background: linear-gradient(135deg, #8C6D53 0%, #73563E 100%);">
                <div class="card-body p-4 position-relative">
                    <div class="position-absolute end-0 bottom-0 opacity-10 mb-n3 me-n2">
                        <i class="bi bi-clock-history" style="font-size: 9rem;"></i>
                    </div>
                    <span class="text-white-50 small d-block mb-1 fw-medium tracking-wide text-uppercase">Pending Receivables</span>
                    <h2 class="fw-bold mb-2">RM {{ number_format($pendingPayments, 2) }}</h2>
                    <div class="d-flex align-items-center gap-2 mt-3">
                        <span class="badge bg-white bg-opacity-20 text-white rounded-pill px-3 py-1 small">
                            <i class="bi bi-exclamation-circle me-1"></i> Awaiting Remittance
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-xl-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-file-earmark-text text-muted me-2"></i>Recent Quotations</h5>
                </div>
                <div class="card-body px-0 py-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 custom-dashboard-table">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase fs-7 font-semibold tracking-wider">No</th>
                                    <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">Client</th>
                                    <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">Total</th>
                                    <th class="pe-4 py-3 text-center text-uppercase fs-7 font-semibold tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentQuotations as $quotation)
                                    <tr>
                                        <td class="ps-4 fw-medium text-dark">{{ $quotation->quotation_no }}</td>
                                        <td class="text-secondary fw-normal">{{ $quotation->client->company_name }}</td>
                                        <td class="fw-semibold text-dark">RM {{ number_format($quotation->total, 2) }}</td>
                                        <td class="pe-4 text-center">
                                            <span class="badge rounded-pill bg-light text-dark border px-3 py-1.5 small font-medium">
                                                {{ $quotation->status }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="bi bi-folder-x fs-2 opacity-30 d-block mb-2"></i>
                                            <span class="small">No quotation logs discovered yet</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-2 d-flex align-items-center justify-content-between">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-receipt text-muted me-2"></i>Recent Invoices</h5>
                </div>
                <div class="card-body px-0 py-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 custom-dashboard-table">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase fs-7 font-semibold tracking-wider">No</th>
                                    <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">Client</th>
                                    <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">Total</th>
                                    <th class="pe-4 py-3 text-center text-uppercase fs-7 font-semibold tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentInvoices as $invoice)
                                    <tr>
                                        <td class="ps-4 fw-medium text-dark">{{ $invoice->invoice_no }}</td>
                                        <td class="text-secondary fw-normal">{{ optional($invoice->quotation?->client)->company_name ?? '-' }}</td>
                                        <td class="fw-semibold text-dark">RM {{ number_format($invoice->total, 2) }}</td>
                                        <td class="pe-4 text-center">
                                            @if($invoice->status == 'Paid')
                                                <span class="badge rounded-pill px-3 py-1.5 small font-medium border-0" style="background-color: #EBF5EC; color: #21512A;">
                                                    Paid
                                                </span>
                                            @else
                                                <span class="badge rounded-pill px-3 py-1.5 small font-medium border-0" style="background-color: #FFF3CD; color: #856404;">
                                                    Pending
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5 text-muted">
                                            <i class="bi bi-folder-x fs-2 opacity-30 d-block mb-2"></i>
                                            <span class="small">No invoice records logged yet</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Dashboard specific layout design enhancements matching brand palette settings */
    .metric-icon-box {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .uppercase-tracking {
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 11px !important;
    }
    .fs-7 {
        font-size: 0.75rem !important;
    }
    .custom-dashboard-table tbody tr {
        border-bottom: 1px solid #F3F2F0;
    }
    .custom-dashboard-table tbody tr:last-child {
        border-bottom: 0;
    }
    .custom-dashboard-table thead th {
        font-weight: 600;
        border-bottom: 1px solid #ECEBE9;
    }
    .transition-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .transition-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05) !important;
    }
</style>
@endsection