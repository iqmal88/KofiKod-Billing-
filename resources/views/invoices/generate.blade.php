@extends('layouts.app')

@section('title', 'Generate Invoice')

@section('content')
<div class="container-fluid px-0">

    {{-- ============================================================
        PAGE HEADER
    ============================================================ --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h4 class="text-dark fw-bold mb-1">Generate Invoice</h4>
            <p class="text-muted small mb-0">
                Select one or multiple payment phases and approved change requests to include in this invoice.
            </p>
        </div>

        <a href="{{ route('quotations.show', $quotation) }}"
           class="btn btn-light border text-secondary px-3 py-2 rounded-3 d-inline-flex align-items-center small fw-medium shadow-xs">
            <i class="bi bi-arrow-left me-2"></i>
            Back to Quotation
        </a>
    </div>

    {{-- ============================================================
        VALIDATION ERRORS
    ============================================================ --}}
    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 p-3">
            <div class="fw-bold mb-2 text-danger d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                Please check the following error(s):
            </div>
            <ul class="mb-0 ps-3 small text-danger">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ============================================================
        FORM CONTAINER
    ============================================================ --}}
    <form method="POST" action="{{ route('invoices.store', ['quotation' => $quotation->id]) }}">
        @csrf

        <div class="row g-4">

            {{-- ====================================================
                LEFT SIDE: FORM CONFIGURATION & SELECTIONS
            ==================================================== --}}
            <div class="col-lg-8">

                {{-- INVOICE META SETTINGS --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-1">
                        <div class="d-flex align-items-center">
                            <div class="p-2 bg-success bg-opacity-10 rounded-3 text-success me-3 d-flex align-items-center justify-content-center"
                                 style="width:40px; height:40px;">
                                <i class="bi bi-file-earmark-ruled-fill fs-5"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold text-dark">Invoice Information</h5>
                                <p class="text-muted small mb-0">Configure invoice reference and billing dates.</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">

                            {{-- Source Quotation (Read-only) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary small">Source Quotation</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted font-monospace"><i class="bi bi-hash"></i></span>
                                    <input type="text" class="form-control bg-light text-secondary fw-semibold font-monospace" value="{{ $quotation->quotation_no }}" readonly>
                                </div>
                            </div>

                            {{-- Client Company (Read-only) --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary small">Client Profile</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="bi bi-building"></i></span>
                                    <input type="text" class="form-control bg-light text-secondary fw-medium" value="{{ $quotation->client->company_name }}" readonly>
                                </div>
                            </div>

                            {{-- Invoice Date --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary small">
                                    Invoice Date <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="bi bi-calendar-plus"></i></span>
                                    <input type="date"
                                           name="invoice_date"
                                           class="form-control bg-light-focus"
                                           value="{{ old('invoice_date', now()->format('Y-m-d')) }}"
                                           required>
                                </div>
                            </div>

                            {{-- Due Date --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary small">
                                    Due Date <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="bi bi-calendar-check"></i></span>
                                    <input type="date"
                                           name="due_date"
                                           class="form-control bg-light-focus"
                                           value="{{ old('due_date', now()->addDays(7)->format('Y-m-d')) }}"
                                           required>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                {{-- PAYMENT PHASES SELECTION CARD --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                        <div class="d-flex align-items-center">
                            <div class="p-2 bg-primary bg-opacity-10 rounded-3 text-primary me-3 d-flex align-items-center justify-content-center"
                                 style="width:40px; height:40px;">
                                <i class="bi bi-layers-fill fs-5"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold text-dark">Payment Phases</h5>
                                <p class="text-muted small mb-0">Select one or multiple quotation payment phases.</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        @if($availablePaymentTerms->count())
                            <div class="d-flex flex-column gap-3">
                                @foreach($availablePaymentTerms as $term)
                                    @php
                                        $phaseAmount = ((float) $quotation->total * (float) $term->percentage) / 100;
                                    @endphp

                                    <label class="invoice-selection-item d-block m-0">
                                        <div class="border rounded-3 p-3 selection-card">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3">
                                                    <input type="checkbox"
                                                           class="form-check-input invoice-payment-term"
                                                           name="payment_terms[]"
                                                           value="{{ $term->id }}"
                                                           data-percentage="{{ $term->percentage }}"
                                                           data-amount="{{ number_format($phaseAmount, 2, '.', '') }}"
                                                           {{ in_array($term->id, old('payment_terms', [])) ? 'checked' : '' }}>
                                                </div>

                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                                        <div>
                                                            <div class="fw-bold text-dark">{{ $term->title }}</div>
                                                            @if($term->description)
                                                                <div class="text-muted small mt-0.5">{{ $term->description }}</div>
                                                            @endif
                                                        </div>

                                                        <div class="text-end">
                                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1.5 small font-medium">
                                                                {{ number_format($term->percentage, 2) }}%
                                                            </span>
                                                            <div class="fw-bold text-dark font-monospace mt-1">
                                                                RM {{ number_format($phaseAmount, 2) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="d-inline-flex p-3 bg-success bg-opacity-10 rounded-circle text-success mb-2">
                                    <i class="bi bi-check-circle-fill fs-3"></i>
                                </div>
                                <h6 class="fw-bold text-dark mt-2 mb-1">No Available Payment Phases</h6>
                                <p class="text-muted small mb-0">All payment phases for this quotation have already been invoiced.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- CHANGE REQUESTS SELECTION CARD --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                        <div class="d-flex align-items-center">
                            <div class="p-2 bg-warning bg-opacity-10 rounded-3 text-warning me-3 d-flex align-items-center justify-content-center"
                                 style="width:40px; height:40px;">
                                <i class="bi bi-arrow-repeat fs-5"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold text-dark">Approved Change Requests</h5>
                                <p class="text-muted small mb-0">Add approved additional work to this invoice.</p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        @if($availableChangeRequests->count())
                            <div class="d-flex flex-column gap-3">
                                @foreach($availableChangeRequests as $changeRequest)
                                    <label class="invoice-selection-item d-block m-0">
                                        <div class="border rounded-3 p-3 selection-card">
                                            <div class="d-flex align-items-start">
                                                <div class="me-3 pt-1">
                                                    <input type="checkbox"
                                                           class="form-check-input invoice-change-request"
                                                           name="change_requests[]"
                                                           value="{{ $changeRequest->id }}"
                                                           data-amount="{{ number_format($changeRequest->total, 2, '.', '') }}"
                                                           {{ in_array($changeRequest->id, old('change_requests', [])) ? 'checked' : '' }}>
                                                </div>

                                                <div class="flex-grow-1">
                                                    <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                                        <div>
                                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                                <span class="fw-bold text-dark">{{ $changeRequest->change_request_no }}</span>
                                                                <span class="badge rounded-pill px-2.5 py-1 small font-medium" style="background-color: #EBF5EC; color: #21512A;">
                                                                    Approved
                                                                </span>
                                                            </div>

                                                            <div class="fw-semibold text-secondary small">{{ $changeRequest->title }}</div>

                                                            @if($changeRequest->description)
                                                                <div class="text-muted small mt-1">{{ $changeRequest->description }}</div>
                                                            @endif

                                                            @if($changeRequest->items->count())
                                                                <div class="mt-2 pt-2 border-top border-light">
                                                                    @foreach($changeRequest->items as $crItem)
                                                                        <div class="small text-muted d-flex align-items-center gap-1">
                                                                            <i class="bi bi-dot"></i>
                                                                            <span>{{ $crItem->description }}</span>
                                                                            <span class="ms-auto font-monospace">RM {{ number_format($crItem->amount, 2) }}</span>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div class="text-end">
                                                            <div class="fw-bold text-dark font-monospace fs-6">
                                                                RM {{ number_format($changeRequest->total, 2) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <div class="d-inline-flex p-3 bg-light rounded-circle text-muted mb-2 opacity-75">
                                    <i class="bi bi-file-earmark-check fs-3"></i>
                                </div>
                                <h6 class="fw-bold text-dark mt-2 mb-1">No Approved Change Requests</h6>
                                <p class="text-muted small mb-0">There are currently no approved and uninvoiced change requests for this quotation.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            {{-- ====================================================
                RIGHT SIDE: CALCULATIONS SUMMARY PANEL
            ==================================================== --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 sticky-lg-top" style="top: 90px; z-index: 1020;">
                    
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <div class="d-flex align-items-center">
                            <div class="p-2 bg-success bg-opacity-10 rounded-3 text-success me-3 d-flex align-items-center justify-content-center"
                                 style="width:36px; height:36px;">
                                <i class="bi bi-calculator-fill fs-5"></i>
                            </div>
                            <h6 class="mb-0 fw-bold text-dark">Invoice Summary</h6>
                        </div>
                    </div>

                    <div class="card-body p-4">

                        {{-- Quotation Base Total --}}
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-secondary small">Quotation Base Total</span>
                            <span class="font-monospace text-dark fw-medium">RM {{ number_format($quotation->total, 2) }}</span>
                        </div>

                        {{-- Selected Phase Allocation Percentage --}}
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-secondary small">Selected Phase Allocation</span>
                            <span class="font-monospace text-success fw-bold" id="percentageText">0.00%</span>
                        </div>

                        <hr class="my-3 opacity-50">

                        {{-- Payment Phase Total --}}
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-secondary small">Payment Phases</span>
                            <span class="font-monospace fw-semibold text-dark">RM <span id="paymentPhaseTotal">0.00</span></span>
                        </div>

                        {{-- Change Request Total --}}
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-secondary small">Change Requests</span>
                            <span class="font-monospace fw-semibold text-dark">RM <span id="changeRequestTotal">0.00</span></span>
                        </div>

                        {{-- Subtotal --}}
                        <div class="d-flex justify-content-between align-items-center mb-3 pt-2 border-top border-light">
                            <span class="fw-semibold text-dark small">Calculated Subtotal</span>
                            <span class="font-monospace fw-bold text-dark">RM <span id="subtotalText">0.00</span></span>
                        </div>

                        {{-- Discount Input --}}
                        <div class="mb-3">
                            <label class="form-label text-secondary small fw-semibold">Discount (Deduction)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted small py-1 px-2.5">RM</span>
                                <input type="number"
                                       name="discount"
                                       id="discount"
                                       class="form-control bg-light-focus text-end font-monospace text-danger"
                                       value="{{ old('discount', 0) }}"
                                       min="0"
                                       step="0.01">
                            </div>
                        </div>

                        {{-- Tax Input --}}
                        <div class="mb-4">
                            <label class="form-label text-secondary small fw-semibold">Service Tax / SST</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted small py-1 px-2.5">RM</span>
                                <input type="number"
                                       name="tax"
                                       id="tax"
                                       class="form-control bg-light-focus text-end font-monospace text-dark"
                                       value="{{ old('tax', 0) }}"
                                       min="0"
                                       step="0.01">
                            </div>
                        </div>

                        {{-- Grand Total Display Container --}}
                        <div class="p-3 rounded-3 mb-4" style="background-color: #F4F6F4;">
                            <label class="form-label fw-bold text-dark small text-uppercase tracking-wider">Total Invoice Amount</label>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-success fw-bold fs-5">RM</span>
                                <span id="invoiceAmount" class="font-monospace fw-bold fs-3 text-dark">0.00</span>
                            </div>
                        </div>

                        {{-- Selection Trackers Count --}}
                        <div class="small text-muted mb-4 p-2 bg-light rounded-3">
                            <div class="d-flex justify-content-between">
                                <span>Selected Payment Phases</span>
                                <span id="selectedPhaseCount" class="fw-bold text-dark">0</span>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <span>Selected Change Requests</span>
                                <span id="selectedCRCount" class="fw-bold text-dark">0</span>
                            </div>
                        </div>

                        {{-- Submit Command Button --}}
                        <div class="d-grid">
                            <button type="submit"
                                    class="btn text-white btn-lg rounded-3 shadow-sm py-2.5 btn-submit-action"
                                    style="background: var(--sidebar-bg); border: 0; font-weight: 600; font-size: 1rem;">
                                <i class="bi bi-cloud-lightning-fill me-2"></i>
                                Generate Invoice
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<style>
    .bg-light-focus:focus {
        background-color: #ffffff !important;
        border-color: var(--accent-brown) !important;
        box-shadow: 0 0 0 0.25rem rgba(140, 109, 83, 0.15) !important;
    }

    .input-group:focus-within .input-group-text {
        border-color: var(--accent-brown) !important;
        background-color: #fff !important;
    }

    .shadow-xs {
        box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
    }

    .tracking-wider {
        letter-spacing: 0.5px;
    }

    .btn-submit-action:hover {
        background-color: #2D3E29 !important;
    }

    /* Selection Card Styling */
    .invoice-selection-item {
        cursor: pointer;
    }

    .selection-card {
        transition: all 0.2s ease;
        background: #fff;
    }

    .selection-card:hover {
        border-color: #adb5bd !important;
        background: #fafafa;
    }

    .invoice-selection-item:has(input:checked) .selection-card {
        border-color: #198754 !important;
        background: rgba(25, 135, 84, 0.04);
        box-shadow: 0 0 0 1px rgba(25, 135, 84, 0.08);
    }

    .invoice-selection-item .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        cursor: pointer;
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const paymentTerms = document.querySelectorAll('.invoice-payment-term');
    const changeRequests = document.querySelectorAll('.invoice-change-request');
    const discountInput = document.getElementById('discount');
    const taxInput = document.getElementById('tax');

    function calculateInvoice() {
        let paymentPhaseTotal = 0;
        let changeRequestTotal = 0;
        let totalPercentage = 0;
        let selectedPhaseCount = 0;
        let selectedCRCount = 0;

        // Payment Phases calculation loop
        paymentTerms.forEach(function (checkbox) {
            if (checkbox.checked) {
                paymentPhaseTotal += parseFloat(checkbox.dataset.amount || 0);
                totalPercentage += parseFloat(checkbox.dataset.percentage || 0);
                selectedPhaseCount++;
            }
        });

        // Change Requests calculation loop
        changeRequests.forEach(function (checkbox) {
            if (checkbox.checked) {
                changeRequestTotal += parseFloat(checkbox.dataset.amount || 0);
                selectedCRCount++;
            }
        });

        // Subtotal summation
        const subtotal = paymentPhaseTotal + changeRequestTotal;

        // Deductions & Taxes
        const discount = parseFloat(discountInput.value || 0);
        const tax = parseFloat(taxInput.value || 0);

        // Grand Total Calculation
        let grandTotal = subtotal - discount + tax;
        if (grandTotal < 0) {
            grandTotal = 0;
        }

        // Render UI Nodes
        document.getElementById('percentageText').textContent = totalPercentage.toFixed(2) + '%';
        document.getElementById('paymentPhaseTotal').textContent = paymentPhaseTotal.toFixed(2);
        document.getElementById('changeRequestTotal').textContent = changeRequestTotal.toFixed(2);
        document.getElementById('subtotalText').textContent = subtotal.toFixed(2);
        document.getElementById('invoiceAmount').textContent = grandTotal.toFixed(2);
        document.getElementById('selectedPhaseCount').textContent = selectedPhaseCount;
        document.getElementById('selectedCRCount').textContent = selectedCRCount;
    }

    // Attach Event Handlers
    paymentTerms.forEach(function (checkbox) {
        checkbox.addEventListener('change', calculateInvoice);
    });

    changeRequests.forEach(function (checkbox) {
        checkbox.addEventListener('change', calculateInvoice);
    });

    if (discountInput) discountInput.addEventListener('input', calculateInvoice);
    if (taxInput) taxInput.addEventListener('input', calculateInvoice);

    // Initial Trigger on Page Load
    calculateInvoice();
});
</script>
@endpush

@endsection