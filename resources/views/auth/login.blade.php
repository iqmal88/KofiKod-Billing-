@extends('layouts.auth')

@section('title','Login')

@section('content')
 
 <div class="min-h-screen bg-slate-100">
        <div class="container-fluid">
            <div class="row min-vh-100">

                <!-- Left Side -->
                <div class="col-lg-7 d-none d-lg-flex align-items-center justify-content-center bg-primary text-white p-5">

                    <div style="max-width:500px;">

                        <h1 class="fw-bold display-5 mb-3">
                            KOFI AND KOD
                        </h1>

                        <h4 class="mb-4">
                            Business Management System
                        </h4>

                        <p class="fs-5 opacity-75">
                            Manage Quotations, Invoices and Receipts
                            professionally in one place.
                        </p>

                        <div class="mt-5">

                            <div class="mb-3">
                                ✅ Client Management
                            </div>

                            <div class="mb-3">
                                ✅ Quotation Generator
                            </div>

                            <div class="mb-3">
                                ✅ Invoice Generator
                            </div>

                            <div class="mb-3">
                                ✅ Receipt Generator
                            </div>

                            <div class="mb-3">
                                ✅ PDF Export
                            </div>

                        </div>

                    </div>

                </div>

                <!-- Right Side -->
                <div class="col-lg-5 d-flex align-items-center justify-content-center">

                    <div class="card shadow-lg border-0 rounded-4 p-5"
                         style="width:420px;">

                        <div class="text-center mb-4">

                            <h2 class="fw-bold">
                                Welcome Back
                            </h2>

                            <p class="text-muted">
                                Login to your account
                            </p>

                        </div>

                        <x-auth-session-status class="mb-3" :status="session('status')" />

                        <form method="POST" action="{{ route('login') }}">

                            @csrf

                            <!-- Email -->

                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Email Address
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control form-control-lg"
                                    value="{{ old('email') }}"
                                    required
                                    autofocus>

                                <x-input-error :messages="$errors->get('email')" class="mt-2"/>

                            </div>

                            <!-- Password -->

                            <div class="mb-3">

                                <label class="form-label fw-semibold">
                                    Password
                                </label>

                                <input
                                    type="password"
                                    name="password"
                                    class="form-control form-control-lg"
                                    required>

                                <x-input-error :messages="$errors->get('password')" class="mt-2"/>

                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">

                                <div class="form-check">

                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="remember">

                                    <label class="form-check-label">

                                        Remember Me

                                    </label>

                                </div>

                                @if(Route::has('password.request'))

                                    <a href="{{ route('password.request') }}"
                                       class="text-decoration-none">

                                        Forgot Password?

                                    </a>

                                @endif

                            </div>

                            <button
                                class="btn btn-primary btn-lg w-100">

                                Login

                            </button>

                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection