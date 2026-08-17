@extends('layouts.app')

@section('title', 'Invoices')

@section('content')
<div class="container-fluid px-0">
    
    <!-- Top Action Header Summary Bar -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h4 class="text-dark fw-bold mb-1">Invoice Ledger</h4>
            <p class="text-muted small mb-0">Track, monitor, and manage all generated milestone account invoices.</p>
        </div>
    </div>

    <!-- Flash Alert Messages -->
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

    <!-- Main Data Table Container -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 custom-invoice-table">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase fs-7 font-semibold tracking-wider">Invoice No</th>
                            <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">Quotation Ref</th>
                            <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">Client Company</th>
                            <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">Payment Stage</th>
                            <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">Issue Date</th>
                            <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">Grand Total</th>
                            <th class="py-3 text-center text-uppercase fs-7 font-semibold tracking-wider" width="120">Status</th>
                            <th class="pe-4 py-3 text-center text-uppercase fs-7 font-semibold tracking-wider" width="110">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                            <tr>
                                <td class="ps-4">
                                    <span class="text-dark fw-bold font-monospace">{{ $invoice->invoice_no }}</span>
                                </td>
                                <td>
                                    <span class="text-secondary small font-monospace">{{ $invoice->quotation->quotation_no }}</span>
                                </td>
                                <td>
                                    <div class="fw-medium text-dark">{{ $invoice->quotation->client->company_name }}</div>
                                </td>
                                <td>
                                    <span class="badge bg-light border text-secondary rounded-2 px-2.5 py-1.5 small font-medium">
                                        {{ $invoice->payment_stage ?? 'Milestone Phase' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-secondary small">
                                        <i class="bi bi-calendar3 me-1.5 opacity-75"></i>{{ $invoice->invoice_date->format('d M Y') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">RM {{ number_format($invoice->total, 2) }}</span>
                                </td>
                                <td class="text-center">
                                    @if($invoice->status === 'Paid')
                                        <span class="badge rounded-pill px-3 py-1.5 small font-medium" style="background-color: #EBF5EC; color: #21512A;">
                                            <i class="bi bi-patch-check-fill me-1"></i> Paid
                                        </span>
                                    @else
                                        <span class="badge rounded-pill px-3 py-1.5 small font-medium" style="background-color: #FFF8E6; color: #8A6D3B;">
                                            <i class="bi bi-clock-history me-1"></i> Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="pe-4 text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-1.5">
                                        <!-- View Button -->
                                        <a href="{{ route('invoices.show', $invoice) }}" 
                                           class="btn btn-action shadow-xs border text-secondary bg-white rounded-3" 
                                           title="View Invoice">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- Delete Button (Only for Unpaid Invoices) -->
                                        @if($invoice->status !== 'Paid')
                                            <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-action-danger shadow-xs border rounded-3" 
                                                        title="Delete Invoice"
                                                        onclick="return confirm('Are you sure you want to delete invoice {{ $invoice->invoice_no }}? This action cannot be undone.')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <div class="py-4">
                                        <div class="d-inline-flex p-3 bg-light rounded-circle text-muted mb-3 opacity-75">
                                            <i class="bi bi-file-earmark-ruled fs-1 px-1"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">No Invoices Found</h5>
                                        <p class="text-muted small mb-0">There are no generated corporate invoices registered in the system ledger yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($invoices->hasPages())
                <div class="px-4 py-3 border-top bg-light custom-pagination-pane">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .fs-7 {
        font-size: 0.75rem !important;
    }
    .shadow-xs {
        box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
    }
    .custom-invoice-table tbody tr {
        border-bottom: 1px solid #F3F2F0;
        transition: background-color 0.15s ease;
    }
    .custom-invoice-table tbody tr:last-child {
        border-bottom: 0;
    }
    .custom-invoice-table tbody tr:hover {
        background-color: #FAF9F8;
    }
    .custom-invoice-table thead th {
        font-weight: 600;
        border-bottom: 1px solid #ECEBE9;
    }
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