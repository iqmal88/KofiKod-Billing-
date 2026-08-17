<div class="row g-3">
    <div class="col-md-6">
        <label for="company_name" class="form-label fw-semibold text-secondary small">
            Company Name <span class="text-danger">*</span>
        </label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted @error('company_name') border-danger text-danger @enderror">
                <i class="bi bi-building"></i>
            </span>
            <input
                type="text"
                id="company_name"
                name="company_name"
                class="form-control bg-light-focus border-start-0 @error('company_name') is-invalid @enderror"
                value="{{ old('company_name', $client->company_name ?? '') }}"
                placeholder="Enter official entity or company name">
            @error('company_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <label for="person_in_charge" class="form-label fw-semibold text-secondary small">
            Person In Charge <span class="text-danger">*</span>
        </label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted @error('person_in_charge') border-danger text-danger @enderror">
                <i class="bi bi-person"></i>
            </span>
            <input
                type="text"
                id="person_in_charge"
                name="person_in_charge"
                class="form-control bg-light-focus border-start-0 @error('person_in_charge') is-invalid @enderror"
                value="{{ old('person_in_charge', $client->person_in_charge ?? '') }}"
                placeholder="Enter PIC full name">
            @error('person_in_charge')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <label for="phone" class="form-label fw-semibold text-secondary small">Phone Number</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted @error('phone') border-danger text-danger @enderror">
                <i class="bi bi-telephone"></i>
            </span>
            <input
                type="text"
                id="phone"
                name="phone"
                class="form-control bg-light-focus border-start-0 @error('phone') is-invalid @enderror"
                value="{{ old('phone', $client->phone ?? '') }}"
                placeholder="e.g. 0123456789">
            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <label for="email" class="form-label fw-semibold text-secondary small">Email Address</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted @error('email') border-danger text-danger @enderror">
                <i class="bi bi-envelope"></i>
            </span>
            <input
                type="email"
                id="email"
                name="email"
                class="form-control bg-light-focus border-start-0 @error('email') is-invalid @enderror"
                value="{{ old('email', $client->email ?? '') }}"
                placeholder="example@company.com">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="col-md-12 mb-2">
        <label for="address" class="form-label fw-semibold text-secondary small">Physical Address</label>
        <textarea
            id="address"
            name="address"
            rows="4"
            class="form-control bg-light-focus @error('address') is-invalid @enderror"
            placeholder="Enter complete company billing or business location address...">{{ old('address', $client->address ?? '') }}</textarea>
        @error('address')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
</div>

<hr class="my-4 opacity-50">

<div class="d-flex align-items-center justify-content-end gap-2">
    <a href="{{ route('clients.index') }}" class="btn btn-light border text-secondary px-4 py-2 rounded-3">
        Cancel
    </a>

    <button type="submit" class="btn text-white px-4 py-2 rounded-3 shadow-sm btn-submit-action" style="background: var(--sidebar-bg); border: 0; font-weight: 500;">
        <i class="bi bi-cloud-check-fill me-2"></i>
        {{ isset($client) ? 'Update Client Record' : 'Save Client Profile' }}
    </button>
</div>

<style>
    /* Form control aesthetic integration mappings */
    .btn-submit-action:hover {
        background-color: #2D3E29 !important;
    }
    /* Input field grouping error structure logic fallback adjustments */
    .input-group .is-invalid {
        border-left: 0 !important;
    }
    .input-group:focus-within .input-group-text:not(.border-danger) {
        border-color: var(--accent-brown) !important;
        background-color: #fff !important;
    }
</style>