@extends('layouts.app')

@section('title', 'Client Details')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h3 class="fw-bold mb-1">

            Client Details

        </h3>

        <p class="text-muted mb-0">

            View client's information.

        </p>

    </div>

    <div>

        <a href="{{ route('clients.edit', $client) }}"
           class="btn btn-warning text-white">

            <i class="bi bi-pencil-square me-2"></i>

            Edit

        </a>

        <a href="{{ route('clients.index') }}"
           class="btn btn-secondary">

            <i class="bi bi-arrow-left me-2"></i>

            Back

        </a>

    </div>

</div>

<div class="row">

    <!-- Client Information -->

    <div class="col-lg-5">

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-header bg-white">

                <h5 class="mb-0 fw-bold">

                    Company Information

                </h5>

            </div>

            <div class="card-body">

                <table class="table table-borderless">

                    <tr>

                        <th width="180">

                            Company Name

                        </th>

                        <td>

                            {{ $client->company_name }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Person In Charge

                        </th>

                        <td>

                            {{ $client->person_in_charge }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Phone

                        </th>

                        <td>

                            {{ $client->phone ?: '-' }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Email

                        </th>

                        <td>

                            {{ $client->email ?: '-' }}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Address

                        </th>

                        <td>

                            {!! nl2br(e($client->address ?: '-')) !!}

                        </td>

                    </tr>

                    <tr>

                        <th>

                            Created At

                        </th>

                        <td>

                            {{ $client->created_at->format('d M Y h:i A') }}

                        </td>

                    </tr>

                </table>

            </div>

        </div>

    </div>

    <!-- Future Transaction History -->

    <div class="col-lg-7">

        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-header bg-white">

                <h5 class="mb-0 fw-bold">

                    Recent Quotations

                </h5>

            </div>

            <div class="card-body text-center py-5">

                <i class="bi bi-file-earmark-text display-3 text-secondary"></i>

                <h5 class="mt-3">

                    No Quotation Yet

                </h5>

                <p class="text-muted">

                    Quotations created for this client will appear here.

                </p>

            </div>

        </div>

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-header bg-white">

                <h5 class="mb-0 fw-bold">

                    Recent Invoices

                </h5>

            </div>

            <div class="card-body text-center py-5">

                <i class="bi bi-receipt display-3 text-secondary"></i>

                <h5 class="mt-3">

                    No Invoice Yet

                </h5>

                <p class="text-muted">

                    Invoices created for this client will appear here.

                </p>

            </div>

        </div>

    </div>

</div>

@endsection