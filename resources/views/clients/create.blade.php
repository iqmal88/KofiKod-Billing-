@extends('layouts.app')

@section('title', 'Add Client')

@section('content')
<div class="container-fluid px-0" style="max-width: 900px; margin: 0 auto;">
    
    <!-- Header Summary Section Panel -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h4 class="text-dark fw-bold mb-1">Register New Client</h4>
            <p class="text-muted small mb-0">Enter your customer details below to save them for seamless invoice, quotation, and receipt mapping.</p>
        </div>
        <a href="{{ route('clients.index') }}" class="btn btn-light border text-secondary px-3 py-2 rounded-3 d-inline-flex align-items-center small fw-medium shadow-xs">
            <i class="bi bi-arrow-left me-2"></i> Back to List
        </a>
    </div>

    <!-- Main Registration Form Container Workframe -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <!-- Section Accent Visual Context Header Anchor -->
        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
            <div class="d-flex align-items-center">
                <div class="p-2 bg-success bg-opacity-10 rounded-3 text-success me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                    <i class="bi bi-person-plus-fill fs-5"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold text-dark">Client Information Profile</h5>
                    <p class="text-muted small mb-0">Fill up company or individual personal contact endpoints</p>
                </div>
            </div>
        </div>

        <div class="card-body p-4">
            <!-- Dynamic Submission Route Core Action Engine Entry -->
            <form action="{{ route('clients.store') }}" method="POST">
                @csrf

                <!-- Embedded Section Fields Mapping Partial Hook -->
                @include('clients._form')

            </form>
        </div>
    </div>
</div>

<style>
    /* Styling adjustments custom built to frame entry dashboards beautifully */
    .shadow-xs {
        box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
    }
    /* Simple custom placeholder to make sure input elements within form partials scale nicely on focus states */
    .card-body form input:focus, 
    .card-body form textarea:focus, 
    .card-body form select:focus {
        border-color: var(--accent-brown) !important;
        box-shadow: 0 0 0 0.25rem rgba(140, 109, 83, 0.15) !important;
    }
</style>
@endsection