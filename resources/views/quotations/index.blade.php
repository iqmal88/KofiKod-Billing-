@extends('layouts.app')

@section('title', 'Quotations')

@section('content')
<div class="container-fluid px-0">
    
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <h4 class="text-dark fw-bold mb-1">Quotation Management</h4>
            <p class="text-muted small mb-0">Draft, track, and convert price proposals for your client accounts.</p>
        </div>
        <a href="{{ route('quotations.create') }}" class="btn text-white px-4 py-2 rounded-3 shadow-sm btn-brand-primary" style="background: var(--sidebar-bg); font-weight: 500;">
            <i class="bi bi-plus-lg me-2"></i> New Quotation
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible border-0 shadow-sm rounded-3 fade show mb-4 d-flex align-items-center" role="alert">
            <i class="bi bi-check-circle-fill me-2 fs-5"></i>
            <div>{{ session('success') }}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
        <div class="card-body p-4 bg-white">
            <form method="GET" action="{{ route('quotations.index') }}">
                <div class="row g-3 align-items-center">
                    <div class="col-12 col-md-6 col-lg-5">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control bg-light-focus border-start-0" placeholder="Search quotation number or client..." value="{{ $search }}">
                        </div>
                    </div>
                    
                    <div class="col-6 col-md-3 col-lg-2">
                        <button type="submit" class="btn btn-brand-secondary text-white w-100 py-2 rounded-3 font-medium" style="background: var(--accent-brown); border: 0;">
                            <i class="bi bi-funnel-fill me-1"></i> Filter
                        </button>
                    </div>
                    
                    <div class="col-6 col-md-3 col-lg-2">
                        <a href="{{ route('quotations.index') }}" class="btn btn-light border text-secondary w-100 py-2 rounded-3">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 custom-quotation-table">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase fs-7 font-semibold tracking-wider" width="80">#</th>
                            <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">Quotation No</th>
                            <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">Client Company</th>
                            <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">Issue Date</th>
                            <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">Grand Total</th>
                            <th class="py-3 text-center text-uppercase fs-7 font-semibold tracking-wider" width="130">Status</th>
                            <th class="pe-4 py-3 text-center text-uppercase fs-7 font-semibold tracking-wider" width="180">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quotations as $quotation)
                            <tr>
                                <td class="ps-4 text-muted small fw-medium">
                                    {{ $loop->iteration + ($quotations->currentPage()-1) * $quotations->perPage() }}
                                </td>
                                <td>
                                    <span class="text-dark fw-bold font-monospace">{{ $quotation->quotation_no }}</span>
                                </td>
                                <td>
                                    <div class="fw-medium text-dark">{{ $quotation->client->company_name }}</div>
                                </td>
                                <td>
                                    <span class="text-secondary small"><i class="bi bi-calendar3 me-1 text-muted"></i>{{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d M Y') }}</span>
                                </td>
                                <td>
                                    <span class="fw-bold text-dark">RM {{ number_format($quotation->total, 2) }}</span>
                                </td>
                                <td class="text-center">
                                    @php
                                        // Refined, customized pastel mapping variables tailored to blend perfectly with our UI scheme
                                        $statusStyles = match($quotation->status) {
                                            'Draft' => ['bg' => '#EAECEF', 'color' => '#495057'],
                                            'Sent' => ['bg' => '#E8F0FE', 'color' => '#1A73E8'],
                                            'Accepted' => ['bg' => '#EBF5EC', 'color' => '#21512A'],
                                            'Rejected' => ['bg' => '#FCE8E6', 'color' => '#C5221F'],
                                            'Expired' => ['bg' => '#F1F3F4', 'color' => '#5F6368'],
                                            default => ['bg' => '#EAECEF', 'color' => '#495057']
                                        };
                                    @endphp
                                    <span class="badge rounded-pill px-3 py-1.5 small font-medium border-0" style="background-color: {{ $statusStyles['bg'] }}; color: {{ $statusStyles['color'] }}; font-weight: 500;">
                                        {{ $quotation->status }}
                                    </span>
                                </td>
                                <td class="pe-4 text-center">
                                    <div class="d-inline-flex gap-1">
                                        <a href="{{ route('quotations.show', $quotation) }}" class="btn btn-action shadow-xs border text-secondary bg-white rounded-3" title="View Quotation Overview">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('quotations.edit', $quotation) }}" class="btn btn-action shadow-xs border text-secondary bg-white rounded-3" title="Modify Document Details">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('quotations.destroy', $quotation) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to completely remove this quotation record?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-action shadow-xs border text-danger bg-white rounded-3" title="Delete Record permanently">
                                                <i class="bi bi-trash3"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <div class="py-4">
                                        <div class="d-inline-flex p-3 bg-light rounded-circle text-muted mb-3 opacity-75">
                                            <i class="bi bi-file-earmark-text fs-1 px-1"></i>
                                        </div>
                                        <h5 class="fw-bold text-dark mb-1">No Quotations Found</h5>
                                        <p class="text-muted small mb-3">Your filtered search didn't match records, or you haven't drafted any items yet.</p>
                                        <a href="{{ route('quotations.create') }}" class="btn btn-sm btn-outline-secondary px-3 py-1.5 rounded-3">
                                            <i class="bi bi-plus-lg me-1"></i> Create First Quote
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($quotations->hasPages())
                <div class="px-4 py-3 border-top bg-light custom-pagination-pane">
                    {{ $quotations->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Scope styling adjustments built specifically for the tables configuration */
    .bg-light-focus:focus {
        background-color: #ffffff !important;
        border-color: var(--accent-brown) !important;
        box-shadow: 0 0 0 0.25rem rgba(140, 109, 83, 0.15) !important;
    }
    .input-group:focus-within .input-group-text {
        border-color: var(--accent-brown) !important;
        background-color: #fff !important;
    }
    .btn-brand-primary:hover {
        background-color: #2D3E29 !important;
    }
    .btn-brand-secondary:hover {
        background-color: #73563E !important;
    }
    .fs-7 {
        font-size: 0.75rem !important;
    }
    .custom-quotation-table tbody tr {
        border-bottom: 1px solid #F3F2F0;
    }
    .custom-quotation-table tbody tr:last-child {
        border-bottom: 0;
    }
    .custom-quotation-table thead th {
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
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }
    .btn-action:hover {
        background-color: #FBFBFA !important;
        transform: translateY(-1px);
    }
    .custom-pagination-pane nav {
        margin-bottom: 0 !important;
    }
</style>
@endsection