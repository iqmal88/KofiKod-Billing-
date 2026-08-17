@extends('layouts.app')

@section('title', 'Quotation Details')

@section('content')
<div class="container-fluid px-0">
    
    <!-- Top Action Header Summary Bar -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-3">
        <div>
            <span class="text-muted small text-uppercase tracking-wider fw-semibold font-monospace">{{ $quotation->quotation_no }}</span>
            <h4 class="text-dark fw-bold mb-0">Quotation Overview</h4>
        </div>

        <div class="d-flex align-items-center gap-2 flex-wrap">
            <a href="{{ route('quotations.index') }}" class="btn btn-light border text-secondary px-3 py-2 rounded-3 d-inline-flex align-items-center small font-medium shadow-xs">
                <i class="bi bi-arrow-left me-1.5"></i> Back
            </a>

            <a href="{{ route('invoices.generate', $quotation) }}" class="btn text-white px-3 py-2 rounded-3 d-inline-flex align-items-center small font-medium shadow-xs btn-submit-action" style="background: var(--sidebar-bg, #1E291B);">
                <i class="bi bi-receipt me-1.5"></i> Generate Invoice
            </a>

            <a href="{{ route('change-requests.create', ['quotation' => $quotation->id]) }}" class="btn btn-warning text-white px-3 py-2 rounded-3 d-inline-flex align-items-center small font-medium shadow-xs" style="background: var(--accent-brown, #8C6D53); border: 0;">
                <i class="bi bi-arrow-repeat me-1.5"></i> New Change Request
            </a>

            <a href="{{ route('quotations.edit', $quotation) }}" class="btn btn-light border text-dark px-3 py-2 rounded-3 d-inline-flex align-items-center small font-medium shadow-xs">
                <i class="bi bi-pencil-square me-1.5"></i> Edit
            </a>

            <a href="{{ route('quotations.pdf', $quotation) }}" class="btn btn-danger px-3 py-2 rounded-3 d-inline-flex align-items-center small font-medium shadow-xs">
                <i class="bi bi-file-earmark-pdf-fill me-1.5"></i> Download PDF
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Side Pane: Core Scope & Project Details -->
        <div class="col-lg-8">
            
            <!-- Card Block: Project Information -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-building text-muted me-2.5"></i> Project Information
                    </h5>
                </div>
                <div class="card-body px-4 pb-4 pt-2">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Client Profile</span>
                            <span class="text-dark fw-bold fs-6 mt-1 d-block">{{ $quotation->client->company_name }}</span>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Project Assignment Title</span>
                            <span class="text-dark fw-semibold fs-6 mt-1 d-block">{{ $quotation->project_name }}</span>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Issue Date</span>
                            <span class="text-secondary small fw-medium mt-1 d-block">
                                <i class="bi bi-calendar3 me-1.5 opacity-75"></i>{{ \Carbon\Carbon::parse($quotation->quotation_date)->format('d M Y') }}
                            </span>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Validity Period</span>
                            <span class="text-secondary small fw-medium mt-1 d-block">
                                <i class="bi bi-clock me-1.5 opacity-75"></i>{{ $quotation->validity_days }} Days
                            </span>
                        </div>
                        <div class="col-sm-4">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Execution Timeline</span>
                            <span class="text-secondary small fw-medium font-monospace mt-1 d-block">
                                {{ $quotation->project_start ? \Carbon\Carbon::parse($quotation->project_start)->format('d/m/y') : '—' }} 
                                to 
                                {{ $quotation->project_end ? \Carbon\Carbon::parse($quotation->project_end)->format('d/m/y') : '—' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Block: Project Description (If exists) -->
            @if($quotation->project_description)
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-1">
                        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-file-earmark-text me-2 text-muted"></i>Detailed Project Description</h6>
                    </div>
                    <div class="card-body px-4 pb-4 pt-2 text-secondary lead-style-fix small">
                        {!! $quotation->project_description !!}
                    </div>
                </div>
            @endif

            <!-- Card Block: Scope of Work Items -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                        <i class="bi bi-list-task text-muted me-2.5"></i> Scope of Work Line Items
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 custom-details-table">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-4 py-3 text-uppercase fs-7 font-semibold tracking-wider">Service Description</th>
                                    <th class="py-3 text-center text-uppercase fs-7 font-semibold tracking-wider" width="90">Qty</th>
                                    <th class="py-3 text-end text-uppercase fs-7 font-semibold tracking-wider" width="160">Unit Price</th>
                                    <th class="pe-4 py-3 text-end text-uppercase fs-7 font-semibold tracking-wider" width="160">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quotation->items as $item)
                                    <tr>
                                        <td class="ps-4 fw-medium text-dark">{{ $item->item_name }}</td>
                                        <td class="text-center font-monospace text-secondary">{{ $item->quantity }}</td>
                                        <td class="text-end font-monospace text-secondary">RM {{ number_format($item->unit_price, 2) }}</td>
                                        <td class="pe-4 text-end font-monospace fw-semibold text-dark">RM {{ number_format($item->amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Card Block: Related Change Requests -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <h5 class="fw-bold mb-0 text-dark d-flex align-items-center">
                                <i class="bi bi-arrow-repeat text-muted me-2.5"></i> Change Requests
                            </h5>
                            <p class="text-muted small mb-0 mt-0.5">Additional variations outside the original quotation scope.</p>
                        </div>
                        <a href="{{ route('change-requests.create', ['quotation' => $quotation->id]) }}" class="btn btn-warning btn-sm text-white rounded-3 px-3 py-1.5 font-medium shadow-xs" style="background: var(--accent-brown, #8C6D53); border: 0;">
                            <i class="bi bi-plus-circle me-1"></i> New Change Request
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    @forelse($quotation->changeRequests as $changeRequest)
                        <div class="px-4 py-3 border-bottom-dashed">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                                <div>
                                    <a href="{{ route('change-requests.show', $changeRequest) }}" class="fw-bold text-decoration-none font-monospace cr-link">
                                        {{ $changeRequest->change_request_no }}
                                    </a>
                                    <div class="fw-semibold text-dark small mt-0.5">{{ $changeRequest->title }}</div>
                                    <div class="text-muted small mt-0.5"><i class="bi bi-calendar3 me-1 opacity-75"></i>{{ $changeRequest->request_date->format('d M Y') }}</div>
                                </div>

                                <div class="text-end">
                                    <div class="fw-bold text-dark font-monospace mb-1">
                                        RM {{ number_format($changeRequest->total, 2) }}
                                    </div>
                                    
                                    {{-- Status Badges --}}
                                    @if($changeRequest->status === 'Draft')
                                        <span class="badge rounded-pill px-3 py-1 small font-medium" style="background-color: #F1F5F9; color: #475569;">Draft</span>
                                    @elseif($changeRequest->status === 'Pending Approval')
                                        <span class="badge rounded-pill px-3 py-1 small font-medium" style="background-color: #FFF8E6; color: #8A6D3B;">Pending Approval</span>
                                    @elseif($changeRequest->status === 'Approved')
                                        <span class="badge rounded-pill px-3 py-1 small font-medium" style="background-color: #EBF5EC; color: #21512A;"><i class="bi bi-patch-check-fill me-1"></i> Approved</span>
                                    @elseif($changeRequest->status === 'Rejected')
                                        <span class="badge rounded-pill px-3 py-1 small font-medium" style="background-color: #FDF2F2; color: #9B1C1C;">Rejected</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 px-4">
                            <div class="d-inline-flex p-3 bg-light rounded-circle text-muted mb-2 opacity-75">
                                <i class="bi bi-arrow-repeat fs-3"></i>
                            </div>
                            <h6 class="fw-bold text-dark mb-1">No Change Requests Recorded</h6>
                            <p class="text-muted small mb-3">No additional variations have been logged for this project scope.</p>
                            <a href="{{ route('change-requests.create', ['quotation' => $quotation->id]) }}" class="btn btn-outline-secondary btn-sm rounded-3">
                                <i class="bi bi-plus-circle me-1"></i> Create First Change Request
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right Side Pane: Accounting Matrix & Payment Schedule -->
        <div class="col-lg-4">
            
            <!-- Card Block: Accounting Summary -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-calculator me-2 text-muted"></i>Accounting Summary</h6>
                </div>
                <div class="card-body p-4 pt-2">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-secondary small">Subtotal</span>
                        <span class="font-monospace text-dark fw-medium">RM {{ number_format($quotation->subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-secondary small">Discount Deduction</span>
                        <span class="font-monospace text-danger">- RM {{ number_format($quotation->discount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-secondary small">Service Tax (SST)</span>
                        <span class="font-monospace text-dark">RM {{ number_format($quotation->tax, 2) }}</span>
                    </div>
                    
                    <hr class="my-3 opacity-50">
                    
                    <div class="p-3 rounded-3 d-flex justify-content-between align-items-center" style="background-color: #F4F6F4;">
                        <span class="fw-bold text-dark small text-uppercase tracking-wider">Grand Total</span>
                        <span class="font-monospace fw-bold fs-5 text-dark">RM {{ number_format($quotation->total, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Card Block: Milestone Payment Schedule -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-calendar-check me-2 text-muted"></i>Payment Schedule Matrix</h6>
                </div>
                <div class="card-body p-4 pt-1">
                    @forelse($quotation->paymentTerms as $term)
                        <div class="py-3 border-bottom-dashed row g-0">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="fw-bold text-dark small d-flex align-items-center">
                                    <i class="bi bi-circle-fill text-success small me-2" style="font-size: 0.45rem;"></i>{{ $term->title }}
                                </span>
                                <span class="badge bg-light border text-dark font-monospace px-2.5 py-1 small rounded-pill fw-semibold">{{ number_format($term->percentage, 0) }}%</span>
                            </div>
                            @if($term->description)
                                <div class="text-muted small ps-3" style="font-size: 0.8rem; line-height: 1.4;">{{ $term->description }}</div>
                            @endif
                        </div>
                    @empty
                        <div class="text-muted small text-center py-3">
                            <i class="bi bi-info-circle me-1"></i> No milestones specified.
                        </div>
                    @endforelse
                </div>
            </div>
            
        </div>
    </div>
</div>

<style>
    .tracking-wider { letter-spacing: 0.5px; }
    .tracking-wide { letter-spacing: 0.3px; font-size: 11px !important; }
    .fs-7 { font-size: 0.75rem !important; }
    .shadow-xs { box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important; }
    
    .cr-link {
        color: var(--accent-brown, #8C6D53);
        transition: color 0.15s ease;
    }
    .cr-link:hover {
        color: #5C4635;
    }

    .btn-submit-action:hover {
        background-color: #2D3E29 !important;
    }

    .border-bottom-dashed {
        border-bottom: 1px dashed #ECEBE9;
    }
    .border-bottom-dashed:last-child {
        border-bottom: 0 !important;
        padding-bottom: 0 !important;
    }
    
    .custom-details-table th {
        font-weight: 600;
        border-bottom: 1px solid #ECEBE9;
    }
    .custom-details-table td {
        border-bottom: 1px solid #F3F2F0;
        padding-top: 14px;
        padding-bottom: 14px;
    }
    .custom-details-table tbody tr:last-child td {
        border-bottom: 0;
    }
    
    .lead-style-fix p { margin-bottom: 0.5rem; }
    .lead-style-fix p:last-child { margin-bottom: 0; }
</style>
@endsection