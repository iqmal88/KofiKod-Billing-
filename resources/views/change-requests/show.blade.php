@extends('layouts.app')

@section('title', 'Change Request Details')

@section('content')
<div class="container-fluid px-0">

    {{-- ============================================================
        PAGE HEADER
    ============================================================ --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="text-muted small text-uppercase tracking-wider fw-semibold font-monospace">{{ $changeRequest->change_request_no }}</span>
                
                {{-- STATUS BADGES --}}
                @if($changeRequest->status === 'Draft')
                    <span class="badge rounded-pill px-3 py-1.5 small font-medium"
                          style="background-color: #F1F5F9; color: #475569;">
                        <i class="bi bi-pencil me-1 opacity-75"></i>
                        Draft
                    </span>
                @elseif($changeRequest->status === 'Pending Approval')
                    <span class="badge rounded-pill px-3 py-1.5 small font-medium"
                          style="background-color: #FFF8E6; color: #8A6D3B;">
                        <i class="bi bi-clock-history me-1 opacity-75"></i>
                        Pending Approval
                    </span>
                @elseif($changeRequest->status === 'Approved')
                    <span class="badge rounded-pill px-3 py-1.5 small font-medium"
                          style="background-color: #EBF5EC; color: #21512A;">
                        <i class="bi bi-patch-check-fill me-1 opacity-75"></i>
                        Approved
                    </span>
                @elseif($changeRequest->status === 'Rejected')
                    <span class="badge rounded-pill px-3 py-1.5 small font-medium"
                          style="background-color: #FDF2F2; color: #9B1C1C;">
                        <i class="bi bi-x-circle-fill me-1 opacity-75"></i>
                        Rejected
                    </span>
                @endif
            </div>

            <h4 class="fw-bold text-dark mb-0">
                Change Request Details
            </h4>
        </div>

        {{-- HEADER ACTIONS --}}
        <div class="d-flex align-items-center gap-2 flex-wrap">

            {{-- BACK --}}
            <a href="{{ route('change-requests.index') }}"
               class="btn btn-light border text-secondary px-3 py-2 rounded-3 d-inline-flex align-items-center small font-medium shadow-xs">
                <i class="bi bi-arrow-left me-2"></i>
                Back to List
            </a>

            {{-- EDIT --}}
            @if($changeRequest->status !== 'Approved')
                <a href="{{ route('change-requests.edit', $changeRequest) }}"
                   class="btn text-white px-3 py-2 rounded-3 d-inline-flex align-items-center small font-medium shadow-xs"
                   style="background: var(--accent-brown, #8C6D53);">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Draft
                </a>
            @endif

            {{-- APPROVE --}}
            @if($changeRequest->status === 'Pending Approval')
                <form action="{{ route('change-requests.approve', $changeRequest) }}"
                      method="POST"
                      class="d-inline">
                    @csrf
                    @method('PATCH')

                    <button type="submit"
                            class="btn btn-success text-white px-3 py-2 rounded-3 d-inline-flex align-items-center small font-medium shadow-xs btn-submit-action"
                            style="background: var(--sidebar-bg); border: 0;"
                            onclick="return confirm('Are you sure you want to approve this change request? Once approved, it can no longer be edited.')">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        Approve Change Request
                    </button>
                </form>
            @endif

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
        INFORMATION CARDS GRID
    ============================================================ --}}
    <div class="row g-4 mb-4">

        {{-- CHANGE REQUEST INFORMATION --}}
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">

                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <div class="d-flex align-items-center">
                        <div class="p-2 bg-warning bg-opacity-10 rounded-3 text-warning me-3 d-flex align-items-center justify-content-center"
                             style="width:40px; height:40px;">
                            <i class="bi bi-arrow-repeat fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">
                                Change Request Information
                            </h5>
                            <p class="text-muted small mb-0">
                                General information about this change request.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 pt-2">
                    <div class="row g-3">

                        {{-- CR NUMBER --}}
                        <div class="col-md-6">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Change Request No.</span>
                            <span class="text-dark fw-bold font-monospace fs-6 mt-1 d-block">{{ $changeRequest->change_request_no }}</span>
                        </div>

                        {{-- REQUEST DATE --}}
                        <div class="col-md-6">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Request Date</span>
                            <span class="text-secondary small fw-medium mt-1 d-block">
                                <i class="bi bi-calendar3 me-1.5 opacity-75"></i>
                                {{ $changeRequest->request_date->format('d M Y') }}
                            </span>
                        </div>

                        <hr class="my-2 opacity-50 border-light col-12">

                        {{-- TITLE --}}
                        <div class="col-12">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Title</span>
                            <span class="text-dark fw-bold fs-6 mt-1 d-block">{{ $changeRequest->title }}</span>
                        </div>

                        {{-- DESCRIPTION --}}
                        <div class="col-12">
                            <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide mb-1">Description</span>
                            @if($changeRequest->description)
                                <div class="text-secondary small p-3 rounded-3 bg-light border-0" style="white-space: pre-line; line-height: 1.5;">
                                    {{ $changeRequest->description }}
                                </div>
                            @else
                                <div class="text-muted fst-italic small">
                                    No description provided.
                                </div>
                            @endif
                        </div>

                        {{-- APPROVED DATE --}}
                        @if($changeRequest->status === 'Approved')
                            <div class="col-md-6 pt-2">
                                <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Approved Date</span>
                                <span class="text-success small fw-bold mt-1 d-block">
                                    <i class="bi bi-check-circle me-1"></i>
                                    {{ $changeRequest->approved_date ? $changeRequest->approved_date->format('d M Y') : '-' }}
                                </span>
                            </div>
                        @endif

                    </div>
                </div>

            </div>
        </div>

        {{-- RELATED PROJECT / QUOTATION INFORMATION --}}
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">

                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <div class="d-flex align-items-center">
                        <div class="p-2 bg-primary bg-opacity-10 rounded-3 text-primary me-3 d-flex align-items-center justify-content-center"
                             style="width:40px; height:40px;">
                            <i class="bi bi-file-earmark-text fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0">
                                Related Project
                            </h5>
                            <p class="text-muted small mb-0">
                                Original quotation information.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 pt-2">

                    {{-- QUOTATION REF --}}
                    <div class="mb-3">
                        <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Source Quotation</span>
                        <a href="{{ route('quotations.show', $changeRequest->quotation) }}"
                           class="fw-bold text-decoration-none font-monospace cr-link mt-1 d-inline-block">
                            <i class="bi bi-hash me-0.5"></i>{{ $changeRequest->quotation->quotation_no }}
                        </a>
                    </div>

                    {{-- PROJECT --}}
                    <div class="mb-3">
                        <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Project Title</span>
                        <span class="fw-bold text-dark mt-1 d-block">{{ $changeRequest->quotation->project_name }}</span>
                    </div>

                    {{-- CLIENT --}}
                    <div class="mb-3">
                        <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Client Profile</span>
                        <span class="fw-semibold text-secondary mt-1 d-block">{{ $changeRequest->quotation->client->company_name }}</span>
                    </div>

                    <hr class="my-3 opacity-50 border-light">

                    {{-- ORIGINAL QUOTATION VALUE --}}
                    <div class="p-3 rounded-3" style="background-color: #F4F6F4;">
                        <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide mb-1">Original Quotation Total</span>
                        <div class="fw-bold fs-5 text-dark font-monospace">
                            RM {{ number_format($changeRequest->quotation->total, 2) }}
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </div>

    {{-- ============================================================
        CHANGE ITEMS
    ============================================================ --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">

        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-3">
            <div class="d-flex align-items-center">
                <div class="p-2 bg-primary bg-opacity-10 rounded-3 text-primary me-3 d-flex align-items-center justify-content-center"
                     style="width:40px; height:40px;">
                    <i class="bi bi-list-check fs-5"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-dark mb-0">
                        Change Items
                    </h5>
                    <p class="text-muted small mb-0">
                        Additional work included in this change request.
                    </p>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 custom-cr-details-table">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4 py-3 text-uppercase fs-7 font-semibold tracking-wider" width="80">
                                #
                            </th>
                            <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">
                                Description
                            </th>
                            <th class="text-end py-3 pe-4 text-uppercase fs-7 font-semibold tracking-wider" width="220">
                                Amount
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($changeRequest->items as $item)
                            <tr>
                                <td class="ps-4 text-muted small font-monospace">
                                    {{ sprintf('%02d', $loop->iteration) }}
                                </td>
                                <td>
                                    <div class="fw-medium text-dark">
                                        {{ $item->description }}
                                    </div>
                                </td>
                                <td class="text-end pe-4">
                                    <span class="fw-semibold font-monospace text-dark">
                                        RM {{ number_format($item->amount, 2) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                        <tr class="bg-light border-top">
                            <td colspan="2" class="text-end fw-bold py-3 text-dark text-uppercase fs-7 tracking-wider">
                                Change Request Total
                            </td>
                            <td class="text-end pe-4 py-3">
                                <span class="fw-bold fs-5 text-dark font-monospace">
                                    RM {{ number_format($changeRequest->total, 2) }}
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    {{-- ============================================================
        INVOICE STATUS
    ============================================================ --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">

        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
            <div class="d-flex align-items-center">
                <div class="p-2 bg-success bg-opacity-10 rounded-3 text-success me-3 d-flex align-items-center justify-content-center"
                     style="width:40px; height:40px;">
                    <i class="bi bi-receipt fs-5"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-dark mb-0">
                        Invoice Information
                    </h5>
                    <p class="text-muted small mb-0">
                        Invoice status for this change request.
                    </p>
                </div>
            </div>
        </div>

        <div class="card-body p-4">

            @if($changeRequest->invoiceItems->count())

                <div class="d-flex flex-column gap-3">
                    @foreach($changeRequest->invoiceItems as $invoiceItem)
                        <div class="border rounded-3 p-3 bg-white d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div>
                                <div class="text-muted small mb-1">
                                    Included in Invoice
                                </div>
                                <a href="{{ route('invoices.show', $invoiceItem->invoice) }}"
                                   class="fw-bold font-monospace cr-link text-decoration-none fs-6">
                                    {{ $invoiceItem->invoice->invoice_no }}
                                </a>
                            </div>

                            <div class="text-end">
                                <div class="text-muted small mb-1">
                                    Invoice Amount for this CR
                                </div>
                                <div class="fw-bold text-dark font-monospace">
                                    RM {{ number_format($invoiceItem->amount, 2) }}
                                </div>
                            </div>

                            <div>
                                @if($invoiceItem->invoice->status === 'Paid')
                                    <span class="badge rounded-pill px-3 py-1.5 small font-medium"
                                          style="background-color: #EBF5EC; color: #21512A;">
                                        <i class="bi bi-patch-check-fill me-1"></i>
                                        Paid
                                    </span>
                                @else
                                    <span class="badge rounded-pill px-3 py-1.5 small font-medium"
                                          style="background-color: #FFF8E6; color: #8A6D3B;">
                                        <i class="bi bi-clock-history me-1"></i>
                                        {{ $invoiceItem->invoice->status }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

            @else

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <div class="fw-semibold text-dark mb-1">
                            @if($changeRequest->status === 'Approved')
                                Ready for Invoicing
                            @else
                                Not Available for Invoicing
                            @endif
                        </div>

                        <div class="text-muted small">
                            @if($changeRequest->status === 'Approved')
                                This change request has been approved and can now be included in an invoice.
                            @else
                                This change request must be approved before it can be included in an invoice.
                            @endif
                        </div>
                    </div>

                    @if($changeRequest->status === 'Approved')
                        <a href="{{ route('invoices.generate', $changeRequest->quotation) }}"
                           class="btn btn-success text-white rounded-3 px-4 py-2 shadow-xs font-medium d-inline-flex align-items-center btn-submit-action"
                           style="background: var(--sidebar-bg); border: 0;">
                            <i class="bi bi-receipt me-2"></i>
                            Generate Invoice
                        </a>
                    @endif
                </div>

            @endif

        </div>

    </div>

    {{-- ============================================================
        DELETE SECTION
    ============================================================ --}}
    @if($changeRequest->status !== 'Approved')
        <div class="card border-danger border-opacity-25 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                    <div>
                        <h6 class="fw-bold text-danger mb-1">
                            Delete Change Request
                        </h6>
                        <p class="text-muted small mb-0">
                            Permanently remove this change request and all of its change items.
                        </p>
                    </div>

                    <form action="{{ route('change-requests.destroy', $changeRequest) }}"
                          method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                class="btn btn-outline-danger rounded-3 px-3 py-2 small font-medium"
                                onclick="return confirm('Are you sure you want to delete this change request? This action cannot be undone.')">
                            <i class="bi bi-trash me-2"></i>
                            Delete Change Request
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif

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

    .custom-cr-details-table th {
        font-weight: 600;
        border-bottom: 1px solid #ECEBE9;
    }
    .custom-cr-details-table td {
        border-bottom: 1px solid #F3F2F0;
        padding-top: 12px;
        padding-bottom: 12px;
    }
    .custom-cr-details-table tbody tr:last-child td {
        border-bottom: 0;
    }
</style>
@endsection