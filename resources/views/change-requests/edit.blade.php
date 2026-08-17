@extends('layouts.app')

@section('title', 'Edit Change Request')

@section('content')

<div class="container-fluid px-0">

    {{-- ============================================================
        PAGE HEADER
    ============================================================ --}}
    <div class="d-flex justify-content-between
                align-items-center mb-4 flex-wrap gap-3">

        <div>

            <h4 class="fw-bold text-dark mb-1">
                Edit Change Request
            </h4>

            <p class="text-muted small mb-0">
                Update change request information and requested changes.
            </p>

        </div>


        <a href="{{ route('change-requests.show', $changeRequest) }}"
           class="btn btn-light border text-secondary
                  rounded-3 px-3 py-2">

            <i class="bi bi-arrow-left me-2"></i>

            Back

        </a>

    </div>


    {{-- ============================================================
        CHANGE REQUEST REFERENCE
    ============================================================ --}}
    <div class="alert bg-light border shadow-sm rounded-3 mb-4">

        <div class="d-flex align-items-center">

            <div class="me-3">

                <div class="d-flex align-items-center
                            justify-content-center rounded-3
                            bg-warning bg-opacity-10 text-warning"
                     style="width:42px;height:42px;">

                    <i class="bi bi-pencil-square fs-5"></i>

                </div>

            </div>


            <div>

                <div class="text-muted small">
                    Editing Change Request
                </div>

                <div class="fw-bold font-monospace text-dark">
                    {{ $changeRequest->change_request_no }}
                </div>

            </div>

        </div>

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
        EDIT FORM
    ============================================================ --}}
    <form action="{{ route('change-requests.update', $changeRequest) }}"
          method="POST">

        @csrf

        @method('PUT')


        {{-- Shared Form --}}
        @include('change-requests.partials._form')


        {{-- ========================================================
            ACTION BUTTONS
        ======================================================== --}}
        <div class="d-flex justify-content-end
                    align-items-center gap-2 mt-4">


            <a href="{{ route('change-requests.show', $changeRequest) }}"
               class="btn btn-light border rounded-3 px-4">

                Cancel

            </a>


            <button type="submit"
                    class="btn btn-warning text-white
                           rounded-3 px-4">

                <i class="bi bi-pencil-square me-2"></i>

                Update Change Request

            </button>

        </div>

    </form>

</div>

@endsection