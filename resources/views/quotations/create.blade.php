@extends('layouts.app')

@section('title', 'Create Quotation')

@section('content')
<div class="container-fluid px-0">
    
    <!-- Top Action Header Summary Bar -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h4 class="text-dark fw-bold mb-1">Create New Quotation</h4>
            <p class="text-muted small mb-0">Draft a detailed cost estimation proposal. Items will automatically save under your calculation logs.</p>
        </div>
        <a href="{{ route('quotations.index') }}" class="btn btn-light border text-secondary px-3 py-2 rounded-3 d-inline-flex align-items-center small fw-medium shadow-xs">
            <i class="bi bi-arrow-left me-2"></i> Back to List
        </a>
    </div>

    <!-- Main Quotation Building Form Execution Anchor -->
    <form action="{{ route('quotations.store') }}" method="POST">
        @csrf

        <div class="row g-4">
            <!-- Left Primary Form Column Pane -->
            <div class="col-lg-8">
                <!-- Section Block 1: Header Meta Details Information -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        @include('quotations.partials._header')
                    </div>
                </div>

                <!-- Section Block 2: Interactive Line Items Entry Workspace -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        @include('quotations.partials._items')
                    </div>
                </div>

                <!-- Section Block 3: Terms Footnote Document Configuration Info -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4">
                        @include('quotations.partials._payment_terms')
                    </div>
                </div>
            </div>

            <!-- Right Fixed Calculations Summary Panel Column -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 sticky-lg-top" style="top: 90px; z-index: 1020;">
                    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                        <div class="d-flex align-items-center">
                            <div class="p-2 bg-success bg-opacity-10 rounded-3 text-success me-3 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                <i class="bi bi-calculator-fill fs-5"></i>
                            </div>
                            <h6 class="mb-0 fw-bold text-dark">Quotation Summary</h6>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @include('quotations.partials._summary')

                        <hr class="my-4 opacity-50">

                        <!-- Primary Process Form Core Submission Trigger Button -->
                        <div class="d-grid">
                            <button type="submit" class="btn text-white btn-lg rounded-3 shadow-sm py-2.5 btn-submit-trigger" style="background: var(--sidebar-bg); border: 0; font-weight: 600; font-size: 1rem;">
                                <i class="bi bi-cloud-check-fill me-2"></i> Save Quotation
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    /* Framework utility layout overrides tailored to tie elements elegantly into theme standards */
    .shadow-xs {
        box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
    }
    .btn-submit-trigger:hover {
        background-color: #2D3E29 !important;
    }
    
    /* Global form focus styling updates mapped contextually across the quotation building sub-modules */
    .card-body form input:focus, 
    .card-body form textarea:focus, 
    .card-body form select:focus {
        border-color: var(--accent-brown) !important;
        box-shadow: 0 0 0 0.25rem rgba(140, 109, 83, 0.15) !important;
    }

    /* CKEditor theme aesthetic border customization injection matching card profiles */
    .ck-editor__editable_inline {
        min-height: 180px;
        border-bottom-left-radius: 8px !important;
        border-bottom-right-radius: 8px !important;
    }
    .ck-toolbar {
        border-top-left-radius: 8px !important;
        border-top-right-radius: 8px !important;
    }
</style>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    // Safe initialization block verification fallback pattern
    const projectDescTarget = document.querySelector('#project_description');
    if (projectDescTarget) {
        ClassicEditor
            .create(projectDescTarget, {
                toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|', 'undo', 'redo' ]
            })
            .catch(error => {
                console.error(error);
            });
    }
</script>
@endpush
@endsection