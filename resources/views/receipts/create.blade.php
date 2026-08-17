@extends('layouts.app')

@section('title', 'Record Payment')

@section('content')
<div class="container-fluid px-0">

    {{-- ============================================================
        PAGE HEADER
    ============================================================ --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <span class="text-muted small text-uppercase tracking-wider fw-semibold font-monospace">{{ $invoice->invoice_no }}</span>
            <h4 class="fw-bold text-dark mb-0">Record Payment</h4>
        </div>

        <a href="{{ route('invoices.show', $invoice) }}"
           class="btn btn-light border text-secondary px-3 py-2 rounded-3 d-inline-flex align-items-center small font-medium shadow-xs">
            <i class="bi bi-arrow-left me-2"></i>
            Back to Invoice
        </a>
    </div>

    {{-- ============================================================
        VALIDATION ERRORS
    ============================================================ --}}
    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-xs rounded-3 mb-4 p-3">
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

    <div class="row g-4">

        {{-- ========================================================
            LEFT SIDE - PAYMENT FORM
        ======================================================== --}}
        <div class="col-lg-8">

            <form action="{{ route('receipts.store', $invoice) }}" method="POST">
                @csrf

                {{-- PAYMENT INFORMATION CARD --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">

                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-1">
                        <div class="d-flex align-items-center">
                            <div class="p-2 bg-success bg-opacity-10 text-success rounded-3 me-3 d-flex align-items-center justify-content-center"
                                 style="width:40px; height:40px;">
                                <i class="bi bi-cash-coin fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0">
                                    Payment Information
                                </h5>
                                <p class="text-muted small mb-0">
                                    Enter the payment details received from the client.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">

                            {{-- PAYMENT DATE --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary small">
                                    Payment Date <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="bi bi-calendar-check"></i></span>
                                    <input type="date"
                                           name="payment_date"
                                           class="form-control bg-light-focus @error('payment_date') is-invalid @enderror"
                                           value="{{ old('payment_date', now()->format('Y-m-d')) }}"
                                           required>
                                </div>
                                @error('payment_date')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- PAYMENT METHOD --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary small">
                                    Payment Method <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="bi bi-credit-card"></i></span>
                                    <select name="payment_method"
                                            class="form-select bg-light-focus fw-medium @error('payment_method') is-invalid @enderror"
                                            required>
                                        <option value="">Select Payment Method</option>
                                        <option value="Bank Transfer" {{ old('payment_method') === 'Bank Transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="Cash" {{ old('payment_method') === 'Cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="Cheque" {{ old('payment_method') === 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                        <option value="Online Payment" {{ old('payment_method') === 'Online Payment' ? 'selected' : '' }}>Online Payment</option>
                                        <option value="Other" {{ old('payment_method') === 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                                @error('payment_method')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- REFERENCE NUMBER --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary small">
                                    Payment Reference
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="bi bi-hash"></i></span>
                                    <input type="text"
                                           name="reference_no"
                                           class="form-control bg-light-focus @error('reference_no') is-invalid @enderror"
                                           value="{{ old('reference_no') }}"
                                           placeholder="e.g. Bank transaction reference">
                                </div>
                                <div class="form-text text-muted small mt-1">
                                    Optional. Enter the bank transaction or payment reference.
                                </div>
                                @error('reference_no')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            {{-- AMOUNT RECEIVED --}}
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary small">
                                    Amount Received (RM) <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted small fw-bold">RM</span>
                                    <input type="number"
                                           name="amount_received"
                                           id="amount_received"
                                           class="form-control text-end bg-light-focus font-monospace fw-bold fs-6 @error('amount_received') is-invalid @enderror"
                                           value="{{ old('amount_received', number_format($invoice->total, 2, '.', '')) }}"
                                           min="0.01"
                                           step="0.01"
                                           required>
                                </div>
                                @error('amount_received')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                        </div>
                    </div>

                </div>

                {{-- CONFIRMATION SUBMIT CARD --}}
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                            <div>
                                <h6 class="fw-bold text-dark mb-1">
                                    Confirm Payment
                                </h6>
                                <p class="text-muted small mb-0">
                                    Recording this payment will mark the invoice as paid and generate an official receipt.
                                </p>
                            </div>

                            <button type="submit"
                                    class="btn text-white rounded-3 px-4 py-2.5 shadow-xs font-medium d-inline-flex align-items-center btn-submit-action"
                                    style="background: var(--sidebar-bg); border: 0;"
                                    onclick="return confirm('Confirm this payment and generate the receipt?')">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                Record Payment & Generate Receipt
                            </button>
                        </div>
                    </div>
                </div>

            </form>

        </div>

        {{-- ========================================================
            RIGHT SIDE - INVOICE SUMMARY
        ======================================================== --}}
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">

                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <h5 class="fw-bold text-dark mb-0 d-flex align-items-center">
                        <i class="bi bi-receipt me-2 text-muted"></i>
                        Invoice Summary
                    </h5>
                </div>

                <div class="card-body p-4 pt-2">

                    {{-- INVOICE NUMBER --}}
                    <div class="mb-3">
                        <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Invoice Number</span>
                        <a href="{{ route('invoices.show', $invoice) }}"
                           class="fw-bold font-monospace text-decoration-none cr-link fs-6 mt-1 d-inline-block">
                            {{ $invoice->invoice_no }}
                        </a>
                    </div>

                    {{-- CLIENT --}}
                    <div class="mb-3">
                        <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Client Profile</span>
                        <span class="fw-bold text-dark mt-1 d-block">{{ $invoice->quotation->client->company_name }}</span>
                    </div>

                    {{-- PROJECT --}}
                    <div class="mb-3">
                        <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Project Assignment</span>
                        <span class="fw-semibold text-secondary mt-1 d-block">{{ $invoice->quotation->project_name }}</span>
                    </div>

                    {{-- INVOICE DATE --}}
                    <div class="mb-3">
                        <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide">Issue Date</span>
                        <span class="text-secondary small fw-medium mt-1 d-block">
                            <i class="bi bi-calendar3 me-1.5 opacity-75"></i>
                            {{ $invoice->invoice_date->format('d M Y') }}
                        </span>
                    </div>

                    {{-- STATUS --}}
                    <div class="mb-4">
                        <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide mb-1.5">Current Status</span>
                        <span class="badge rounded-pill px-3 py-1.5 small font-medium" style="background-color: #FFF8E6; color: #8A6D3B;">
                            <i class="bi bi-clock-history me-1"></i>
                            {{ $invoice->status }}
                        </span>
                    </div>

                    <hr class="my-3 opacity-50 border-light">

                    {{-- AMOUNT DUE HIGHLIGHT BLOCK --}}
                    <div class="p-3 rounded-3" style="background-color: #F4F6F4;">
                        <span class="text-muted d-block small fw-semibold text-uppercase tracking-wide mb-1">Total Amount Due</span>
                        <div class="d-flex align-items-baseline justify-content-between">
                            <span class="small font-medium text-success fw-bold">RM</span>
                            <span class="font-monospace fw-bold fs-4 text-dark">{{ number_format($invoice->total, 2) }}</span>
                        </div>
                    </div>

                </div>

            </div>

            {{-- NOTICE INFORMATION CARD --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-start">
                        <div class="p-2 bg-primary bg-opacity-10 text-primary rounded-3 me-3 d-flex align-items-center justify-content-center"
                             style="width:36px; height:36px; flex-shrink: 0;">
                            <i class="bi bi-info-circle-fill fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-semibold text-dark small mb-0.5">
                                Payment Record Notice
                            </div>
                            <div class="text-muted small" style="line-height: 1.4;">
                                Once recorded, an official receipt number will automatically be generated and linked to this invoice.
                            </div>
                        </div>
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

    .bg-light-focus:focus {
        background-color: #ffffff !important;
        border-color: var(--accent-brown, #8C6D53) !important;
        box-shadow: 0 0 0 0.25rem rgba(140, 109, 83, 0.15) !important;
    }

    .input-group:focus-within .input-group-text {
        border-color: var(--accent-brown, #8C6D53) !important;
        background-color: #ffffff !important;
    }

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
</style>
@endsection