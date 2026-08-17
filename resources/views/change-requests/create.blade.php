@extends('layouts.app')

@section('title', 'Create Change Request')

@section('content')

<div class="container-fluid px-0">

    {{-- ============================================================
        PAGE HEADER
    ============================================================ --}}
    <div class="d-flex justify-content-between
                align-items-center mb-4 flex-wrap gap-3">

        <div>

            <h4 class="fw-bold text-dark mb-1">
                Create Change Request
            </h4>

            <p class="text-muted small mb-0">
                Record additional work or modifications outside
                the original quotation scope.
            </p>

        </div>


        <a href="{{ route('change-requests.index') }}"
           class="btn btn-light border text-secondary
                  rounded-3 px-3 py-2">

            <i class="bi bi-arrow-left me-2"></i>

            Back

        </a>

    </div>


    {{-- ============================================================
        VALIDATION ERRORS
    ============================================================ --}}
    @if($errors->any())

        <div class="alert alert-danger border-0
                    shadow-sm rounded-3 mb-4">

            <div class="fw-bold mb-2">

                <i class="bi bi-exclamation-circle me-2"></i>

                Please check the following:

            </div>


            <ul class="mb-0 ps-3">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    {{-- ============================================================
        CREATE FORM
    ============================================================ --}}
    <form action="{{ route('change-requests.store') }}"
          method="POST">

        @csrf


        {{-- Shared Form --}}
        @include('change-requests.partials._form')


        {{-- ========================================================
            ACTION BUTTONS
        ======================================================== --}}
        <div class="d-flex justify-content-end
                    align-items-center gap-2 mt-4">


            <a href="{{ route('change-requests.index') }}"
               class="btn btn-light border rounded-3 px-4">

                Cancel

            </a>


            <button type="submit"
                    class="btn text-white rounded-3 px-4"
                    style="background:var(--sidebar-bg);">

                <i class="bi bi-check-circle me-2"></i>

                Create Change Request

            </button>

        </div>

    </form>

</div>

@endsection