@extends('layouts.app')

@section('title', 'Company Settings')

@section('content')
<div class="container-fluid px-0">
    <!-- Header Summary Bar -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h4 class="text-dark fw-bold mb-1">Company Profile</h4>
            <p class="text-muted small mb-0">Manage the corporate identity details that appear on your generated invoices, quotations, and receipts.</p>
        </div>
    </div>

    <!-- Global Form Error Validation Alert Banner -->
    @if($errors->any())
        <div class="alert alert-danger d-flex align-items-start border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2 mt-1 fs-5"></i>
            <div>
                <span class="fw-bold">Please correct the following errors:</span>
                <ul class="mb-0 mt-1 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <form action="{{ route('company-settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <!-- Left Grid Pane: Data Fields -->
            <div class="col-lg-8">
                
                <!-- Section: Primary Information -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-1">
                        <div class="d-flex align-items-center">
                            <div class="p-2 bg-success bg-opacity-10 rounded-3 text-success me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-building-fill fs-5"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold text-dark">Company Information</h5>
                                <p class="text-muted small mb-0">Legal identity and contact pathways</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary small">Company Name</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-alphabet-uppercase"></i></span>
                                    <input type="text" name="company_name" class="form-control bg-light-focus" value="{{ old('company_name', $company->company_name) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary small">Company Tagline</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-quote"></i></span>
                                    <input type="text" name="company_tagline" class="form-control bg-light-focus" value="{{ old('company_tagline', $company->company_tagline) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary small">Phone Number</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-telephone"></i></span>
                                    <input type="text" name="phone" class="form-control bg-light-focus" value="{{ old('phone', $company->phone) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold text-secondary small">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control bg-light-focus" value="{{ old('email', $company->email) }}">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-semibold text-secondary small">Website URL</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-globe"></i></span>
                                    <input type="text" name="website" class="form-control bg-light-focus" value="{{ old('website', $company->website) }}" placeholder="https://example.com">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-semibold text-secondary small">Physical Address</label>
                                <textarea rows="3" name="address" class="form-control bg-light-focus" placeholder="Enter complete business location address...">{{ old('address', $company->address) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Financial Settlement Channel -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-1">
                        <div class="d-flex align-items-center">
                            <div class="p-2 bg-success bg-opacity-10 rounded-3 text-success me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-credit-card-2-front-fill fs-5"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold text-dark">Bank Remittance Information</h5>
                                <p class="text-muted small mb-0">Payment collection account embedded into your invoices</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-secondary small">Bank Name</label>
                                <input type="text" name="bank_name" class="form-control bg-light-focus" value="{{ old('bank_name', $company->bank_name) }}" placeholder="e.g. Maybank, CIMB">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-secondary small">Account Number</label>
                                <input type="text" name="bank_account" class="form-control bg-light-focus" value="{{ old('bank_account', $company->bank_account) }}" placeholder="e.g. 1234567890">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-semibold text-secondary small">Account Holder Name</label>
                                <input type="text" name="bank_holder" class="form-control bg-light-focus" value="{{ old('bank_holder', $company->bank_holder) }}" placeholder="Your official name">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Terms Document Footnote -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-1">
                        <div class="d-flex align-items-center">
                            <div class="p-2 bg-success bg-opacity-10 rounded-3 text-success me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                <i class="bi bi-file-earmark-ruled-fill fs-5"></i>
                            </div>
                            <div>
                                <h5 class="mb-0 fw-bold text-dark">Default Terms & Conditions</h5>
                                <p class="text-muted small mb-0">Standard baseline clauses printed at the footer of documents</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <!-- FIXED: Added explicit id="terms_conditions" attribute below -->
                        <textarea id="terms_conditions" name="terms_conditions" rows="6" class="form-control bg-light-focus" placeholder="1. All quotes are valid for 30 days. 2. 50% deposit required to initiate workflow operations.">{{ old('terms_conditions', $company->terms_conditions) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Right Grid Pane: Uploads & Command Controls -->
            <div class="col-lg-4">
                
                <!-- Utility Module: Logo Asset -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-1">
                        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-image me-2 text-muted"></i>Company Logo</h6>
                    </div>
                    <div class="card-body px-4 pb-4 pt-2 text-center">
                        <div class="p-3 border border-2 border-dashed rounded-4 bg-light mb-3 d-flex align-items-center justify-content-center style-preview-box" style="min-height: 160px;">
                            @if($company->logo)
                                <img id="logo-preview-target" src="{{ asset('storage/'.$company->logo) }}" class="img-fluid rounded-3 shadow-xs" style="max-height: 130px; object-fit: contain;">
                            @else
                                <div id="logo-preview-placeholder" class="text-muted py-3">
                                    <i class="bi bi-cloud-arrow-up fs-2 opacity-50 d-block mb-1"></i>
                                    <span class="small d-block">No transparent logo asset yet</span>
                                </div>
                                <img id="logo-preview-target" class="img-fluid rounded-3 shadow-xs d-none" style="max-height: 130px; object-fit: contain;">
                            @endif
                        </div>
                        <input type="file" name="logo" id="logo-input" class="form-control form-control-sm" accept="image/*">
                    </div>
                </div>

                <!-- Utility Module: Corporate Authorizing Signature Asset -->
                <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-1">
                        <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-pencil-square me-2 text-muted"></i>Authorized Signature</h6>
                    </div>
                    <div class="card-body px-4 pb-4 pt-2 text-center">
                        <div class="p-3 border border-2 border-dashed rounded-4 bg-light mb-3 d-flex align-items-center justify-content-center style-preview-box" style="min-height: 130px;">
                            @if($company->signature)
                                <img id="sig-preview-target" src="{{ asset('storage/'.$company->signature) }}" class="img-fluid" style="max-height: 90px; object-fit: contain;">
                            @else
                                <div id="sig-preview-placeholder" class="text-muted py-2">
                                    <i class="bi bi-vector-pen fs-2 opacity-50 d-block mb-1"></i>
                                    <span class="small d-block">No digital signature uploaded</span>
                                </div>
                                <img id="sig-preview-target" class="img-fluid d-none" style="max-height: 90px; object-fit: contain;">
                            @endif
                        </div>
                        <input type="file" name="signature" id="sig-input" class="form-control form-control-sm" accept="image/*">
                    </div>
                </div>

                <!-- Action Confirmation Core Execution Trigger -->
                <div class="d-grid mt-2">
                    <button type="submit" class="btn btn-action-trigger btn-lg text-white rounded-3 shadow-sm py-2" style="background: var(--accent-brown); border: 0; font-weight: 600; font-size: 1rem;">
                        <i class="bi bi-cloud-check-fill me-2"></i> Save Settings Profile
                    </button>
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
    .border-dashed {
        border-style: dashed !important;
        border-color: #DCDAD7 !important;
    }
    .btn-action-trigger:hover {
        background-color: #73563E !important;
    }
    /* Smooth fix to make CKEditor look seamless with the rounded cards design */
    .ck-editor__editable_inline {
        min-height: 200px;
        border-bottom-left-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
    }
    .ck-toolbar {
        border-top-left-radius: 8px !important;
        border-top-right-radius: 8px !important;
    }
</style>

<script>
    document.getElementById('logo-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = document.getElementById('logo-preview-target');
                const placeholder = document.getElementById('logo-preview-placeholder');
                img.src = event.target.result;
                img.classList.remove('d-none');
                if (placeholder) placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('sig-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const img = document.getElementById('sig-preview-target');
                const placeholder = document.getElementById('sig-preview-placeholder');
                img.src = event.target.result;
                img.classList.remove('d-none');
                if (placeholder) placeholder.classList.add('d-none');
            }
            reader.readAsDataURL(file);
        }
    });
</script>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#terms_conditions'), {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo' ]
        })
        .catch(error => {
            console.error(error);
        });
</script>
@endpush
@endsection