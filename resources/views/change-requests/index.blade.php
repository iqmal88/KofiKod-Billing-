@extends('layouts.app')

@section('title', 'Change Requests')

@section('content')
<div class="container-fluid px-0">

    {{-- ============================================================
        PAGE HEADER
    ============================================================ --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h4 class="fw-bold text-dark mb-1">
                Change Requests
            </h4>
            <p class="text-muted small mb-0">
                Manage additional project changes and approved variation costs.
            </p>
        </div>

        <a href="{{ route('change-requests.create') }}"
           class="btn text-white rounded-3 px-4 py-2 shadow-xs d-inline-flex align-items-center btn-create-action"
           style="background: var(--sidebar-bg); font-weight: 500;">
            <i class="bi bi-plus-circle me-2"></i>
            Create Change Request
        </a>
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
        CHANGE REQUEST TABLE CARD
    ============================================================ --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">

        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-3">
            <div class="d-flex align-items-center">
                <div class="p-2 bg-warning bg-opacity-10 rounded-3 text-warning me-3 d-flex align-items-center justify-content-center"
                     style="width:40px; height:40px;">
                    <i class="bi bi-arrow-repeat fs-5"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-dark mb-0">
                        Change Request List
                    </h5>
                    <p class="text-muted small mb-0">
                        View and manage all project change requests.
                    </p>
                </div>
            </div>
        </div>

        <div class="card-body p-0">
            @if($changeRequests->count())
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 custom-cr-table">
                        <thead class="bg-light text-secondary">
                            <tr>
                                <th class="ps-4 py-3 text-uppercase fs-7 font-semibold tracking-wider">
                                    CR No.
                                </th>
                                <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">
                                    Project / Client
                                </th>
                                <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">
                                    Title
                                </th>
                                <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">
                                    Request Date
                                </th>
                                <th class="py-3 text-end text-uppercase fs-7 font-semibold tracking-wider">
                                    Amount
                                </th>
                                <th class="py-3 text-center text-uppercase fs-7 font-semibold tracking-wider" width="150">
                                    Status
                                </th>
                                <th class="py-3 text-end pe-4 text-uppercase fs-7 font-semibold tracking-wider" width="90">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($changeRequests as $changeRequest)
                                <tr>
                                    {{-- CR NUMBER --}}
                                    <td class="ps-4">
                                        <a href="{{ route('change-requests.show', $changeRequest) }}"
                                           class="fw-bold text-decoration-none font-monospace cr-link">
                                            {{ $changeRequest->change_request_no }}
                                        </a>
                                    </td>

                                    {{-- PROJECT / CLIENT --}}
                                    <td>
                                        <div class="fw-semibold text-dark">
                                            {{ $changeRequest->quotation->project_name }}
                                        </div>
                                        <div class="text-muted small">
                                            {{ $changeRequest->quotation->client->company_name }}
                                        </div>
                                        <div class="text-muted small font-monospace opacity-75">
                                            {{ $changeRequest->quotation->quotation_no }}
                                        </div>
                                    </td>

                                    {{-- TITLE --}}
                                    <td>
                                        <div class="fw-medium text-dark">
                                            {{ $changeRequest->title }}
                                        </div>
                                        @if($changeRequest->description)
                                            <div class="text-muted small mt-0.5">
                                                {{ \Illuminate\Support\Str::limit($changeRequest->description, 55) }}
                                            </div>
                                        @endif
                                    </td>

                                    {{-- REQUEST DATE --}}
                                    <td>
                                        <div class="text-secondary small">
                                            <i class="bi bi-calendar3 me-1.5 opacity-75"></i>
                                            {{ $changeRequest->request_date->format('d M Y') }}
                                        </div>
                                    </td>

                                    {{-- AMOUNT --}}
                                    <td class="text-end">
                                        <span class="fw-bold font-monospace text-dark">
                                            RM {{ number_format($changeRequest->total, 2) }}
                                        </span>
                                    </td>

                                    {{-- STATUS BADGES --}}
                                    <td class="text-center">
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
                                    </td>

                                    {{-- ACTIONS DROPDOWN --}}
                                    <td class="text-end pe-4">
                                        <div class="dropdown">
                                            <button class="btn btn-action border text-secondary bg-white rounded-3 shadow-xs"
                                                    type="button"
                                                    data-bs-toggle="dropdown"
                                                    aria-expanded="false"
                                                    title="Options">
                                                <i class="bi bi-three-dots-vertical"></i>
                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 p-2">
                                                {{-- VIEW --}}
                                                <li>
                                                    <a class="dropdown-item py-2 rounded-2 d-flex align-items-center"
                                                       href="{{ route('change-requests.show', $changeRequest) }}">
                                                        <i class="bi bi-eye me-2.5 text-primary"></i>
                                                        View Details
                                                    </a>
                                                </li>

                                                {{-- EDIT --}}
                                                @if($changeRequest->status !== 'Approved')
                                                    <li>
                                                        <a class="dropdown-item py-2 rounded-2 d-flex align-items-center"
                                                           href="{{ route('change-requests.edit', $changeRequest) }}">
                                                            <i class="bi bi-pencil-square me-2.5 text-warning"></i>
                                                            Edit
                                                        </a>
                                                    </li>
                                                @endif

                                                {{-- APPROVE --}}
                                                @if($changeRequest->status === 'Pending Approval')
                                                    <li>
                                                        <hr class="dropdown-divider my-1">
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('change-requests.approve', $changeRequest) }}"
                                                              method="POST">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit"
                                                                    class="dropdown-item py-2 rounded-2 d-flex align-items-center text-success"
                                                                    onclick="return confirm('Are you sure you want to approve this change request? Once approved, it can no longer be edited.')">
                                                                <i class="bi bi-check-circle me-2.5"></i>
                                                                Approve
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif

                                                {{-- DELETE --}}
                                                @if($changeRequest->status !== 'Approved')
                                                    <li>
                                                        <hr class="dropdown-divider my-1">
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('change-requests.destroy', $changeRequest) }}"
                                                              method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="dropdown-item py-2 rounded-2 d-flex align-items-center text-danger"
                                                                    onclick="return confirm('Are you sure you want to delete this change request?')">
                                                                <i class="bi bi-trash me-2.5"></i>
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- PAGINATION --}}
                @if($changeRequests->hasPages())
                    <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top bg-light flex-wrap gap-2 custom-pagination-pane">
                        <div class="text-muted small">
                            Showing
                            <strong>{{ $changeRequests->firstItem() }}</strong>
                            to
                            <strong>{{ $changeRequests->lastItem() }}</strong>
                            of
                            <strong>{{ $changeRequests->total() }}</strong>
                            change requests
                        </div>

                        <div>
                            {{ $changeRequests->links() }}
                        </div>
                    </div>
                @endif

            @else
                {{-- EMPTY STATE --}}
                <div class="text-center py-5 px-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-warning bg-opacity-10 text-warning mb-3"
                         style="width:70px; height:70px;">
                        <i class="bi bi-arrow-repeat fs-2"></i>
                    </div>

                    <h5 class="fw-bold text-dark mb-2">
                        No Change Requests Yet
                    </h5>

                    <p class="text-muted small mb-4" style="max-width:450px; margin:auto;">
                        Create a change request when a client requests additional work or modifications outside the original quotation scope.
                    </p>

                    <a href="{{ route('change-requests.create') }}"
                       class="btn text-white rounded-3 px-4 py-2 shadow-xs d-inline-flex align-items-center btn-create-action"
                       style="background: var(--sidebar-bg); font-weight: 500;">
                        <i class="bi bi-plus-circle me-2"></i>
                        Create First Change Request
                    </a>
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
    .cr-link {
        color: var(--accent-brown, #8C6D53);
        transition: color 0.15s ease;
    }
    .cr-link:hover {
        color: #5C4635;
    }
    .btn-create-action:hover {
        background-color: #2D3E29 !important;
    }

    /* Table Adjustments */
    .custom-cr-table thead th {
        font-weight: 600;
        border-bottom: 1px solid #ECEBE9;
    }
    .custom-cr-table tbody tr {
        border-bottom: 1px solid #F3F2F0;
        transition: background-color 0.15s ease;
    }
    .custom-cr-table tbody tr:last-child {
        border-bottom: 0;
    }
    .custom-cr-table tbody tr:hover {
        background-color: #FAF9F8;
    }

    /* Dropdown Styling */
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
    .dropdown-menu {
        min-width: 180px;
    }
    .dropdown-item {
        font-size: 0.85rem;
    }

    /* Pagination */
    .custom-pagination-pane nav {
        margin-bottom: 0 !important;
    }
</style>
@endsection