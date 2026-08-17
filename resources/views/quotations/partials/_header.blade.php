<!-- Section Block: Header Meta Details Information -->
<div class="d-flex align-items-center mb-4">
    <div class="p-2 bg-success bg-opacity-10 rounded-3 text-success me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
        <i class="bi bi-file-earmark-text-fill fs-5"></i>
    </div>
    <div>
        <h5 class="mb-0 fw-bold text-dark">Quotation Metadata</h5>
        <p class="text-muted small mb-0">Define tracking indices, execution windows, and client account links</p>
    </div>
</div>

<div class="row g-3">
    {{-- Quotation Number --}}
    <div class="col-md-4">
        <label class="form-label fw-semibold text-secondary small">Quotation Number</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-hash"></i></span>
            <input
                type="text"
                class="form-control bg-light border-start-0 text-secondary fw-semibold font-monospace"
                value="{{ isset($quotation) ? $quotation->quotation_no : 'Auto Generated' }}"
                readonly>
        </div>
    </div>

    {{-- Date --}}
    <div class="col-md-4">
        <label class="form-label fw-semibold text-secondary small">Quotation Date <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted @error('quotation_date') border-danger text-danger @enderror">
                <i class="bi bi-calendar-event"></i>
            </span>
            <input
                type="date"
                name="quotation_date"
                class="form-control bg-light-focus border-start-0 @error('quotation_date') is-invalid @enderror"
                value="{{ old('quotation_date', isset($quotation) ? $quotation->quotation_date->format('Y-m-d') : now()->format('Y-m-d')) }}">
            @error('quotation_date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    {{-- Validity --}}
    <div class="col-md-4">
        <label class="form-label fw-semibold text-secondary small">Validity (Days)</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-clock-history"></i></span>
            <input
                type="number"
                name="validity_days"
                class="form-control bg-light-focus border-start-0"
                value="{{ old('validity_days', $quotation->validity_days ?? 30) }}"
                min="1">
        </div>
    </div>

    {{-- Client Selection --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small">Client Account Reference <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted @error('client_id') border-danger text-danger @enderror">
                <i class="bi bi-building"></i>
            </span>
            <select
                name="client_id"
                class="form-select bg-light-focus border-start-0 @error('client_id') is-invalid @enderror">
                <option value="">-- Select Target Client --</option>
                @foreach($clients as $client)
                    <option
                        value="{{ $client->id }}"
                        {{ old('client_id', $quotation->client_id ?? '') == $client->id ? 'selected' : '' }}>
                        {{ $client->company_name }}
                    </option>
                @endforeach
            </select>
            @error('client_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    {{-- Project Name --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small">Project Assignment Title <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted @error('project_name') border-danger text-danger @enderror">
                <i class="bi bi-folder2-open"></i>
            </span>
            <input
                type="text"
                name="project_name"
                class="form-control bg-light-focus border-start-0 @error('project_name') is-invalid @enderror"
                value="{{ old('project_name', $quotation->project_name ?? '') }}"
                placeholder="e.g. System Infrastructure Phase 2">
            @error('project_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    {{-- Timeline Start --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small">Estimated Scope Start</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-calendar-play"></i></span>
            <input
                type="date"
                name="project_start"
                class="form-control bg-light-focus border-start-0"
                value="{{ old('project_start', isset($quotation) && $quotation->project_start ? $quotation->project_start->format('Y-m-d') : '') }}">
        </div>
    </div>

    {{-- Timeline End --}}
    <div class="col-md-6">
        <label class="form-label fw-semibold text-secondary small">Estimated Scope End</label>
        <div class="input-group">
            <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-calendar-check"></i></span>
            <input
                type="date"
                name="project_end"
                class="form-control bg-light-focus border-start-0"
                value="{{ old('project_end', isset($quotation) && $quotation->project_end ? $quotation->project_end->format('Y-m-d') : '') }}">
        </div>
    </div>

    {{-- Description Workspace --}}
    <div class="col-md-12 mt-2">
        <label class="form-label fw-semibold text-secondary small">Detailed Project Scope Overview</label>
        <textarea
            id="project_description"
            name="project_description"
            class="form-control bg-light-focus"
            placeholder="Outline structural parameters or project deliverables...">{{ old('project_description', $quotation->project_description ?? '') }}</textarea>
        @error('project_description')
            <div class="text-danger small mt-1 d-block">{{ $message }}</div>
        @enderror
    </div>
</div>

<style>
    /* Ensure proper styling alignment with icon frames */
    .input-group .is-invalid {
        border-left: 0 !important;
    }
    .input-group:focus-within .input-group-text:not(.border-danger) {
        border-color: var(--accent-brown) !important;
        background-color: #fff !important;
    }
</style>