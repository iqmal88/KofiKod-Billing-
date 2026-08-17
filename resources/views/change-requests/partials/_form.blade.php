{{-- ============================================================
    CHANGE REQUEST INFORMATION
============================================================ --}}
<div class="card border-0 shadow-sm rounded-4 mb-4">

    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-1">
        <div class="d-flex align-items-center">
            <div class="p-2 bg-warning bg-opacity-10 rounded-3 text-warning me-3 d-flex align-items-center justify-content-center"
                 style="width:40px; height:40px;">
                <i class="bi bi-arrow-repeat fs-5"></i>
            </div>
            <div>
                <h5 class="mb-0 fw-bold text-dark">
                    Change Request Information
                </h5>
                <p class="text-muted small mb-0">
                    Enter the project and change request details.
                </p>
            </div>
        </div>
    </div>

    <div class="card-body p-4">
        <div class="row g-3">

            {{-- QUOTATION / PROJECT --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold text-secondary small">
                    Quotation / Project <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="bi bi-hash"></i></span>
                    <select name="quotation_id"
                            class="form-select bg-light-focus fw-medium"
                            required>
                        <option value="">Select Quotation</option>
                        @foreach($quotations as $quotationOption)
                            <option value="{{ $quotationOption->id }}"
                                @selected(
                                    old(
                                        'quotation_id',
                                        isset($changeRequest)
                                            ? $changeRequest->quotation_id
                                            : ($selectedQuotation->id ?? '')
                                    ) == $quotationOption->id
                                )>
                                {{ $quotationOption->quotation_no }} - {{ $quotationOption->project_name }} - {{ $quotationOption->client->company_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @error('quotation_id')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- REQUEST DATE --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold text-secondary small">
                    Request Date <span class="text-danger">*</span>
                </label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-muted"><i class="bi bi-calendar-plus"></i></span>
                    <input type="date"
                           name="request_date"
                           class="form-control bg-light-focus"
                           value="{{ old('request_date', isset($changeRequest) ? $changeRequest->request_date->format('Y-m-d') : now()->format('Y-m-d')) }}"
                           required>
                </div>
                @error('request_date')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- TITLE --}}
            <div class="col-12">
                <label class="form-label fw-semibold text-secondary small">
                    Change Request Title <span class="text-danger">*</span>
                </label>
                <input type="text"
                       name="title"
                       class="form-control bg-light-focus"
                       placeholder="Example: Additional System Changes"
                       value="{{ old('title', $changeRequest->title ?? '') }}"
                       required>
                @error('title')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- DESCRIPTION --}}
            <div class="col-12">
                <label class="form-label fw-semibold text-secondary small">
                    Description
                </label>
                <textarea name="description"
                          class="form-control bg-light-focus"
                          rows="4"
                          placeholder="Describe the overall reason or purpose of this change request...">{{ old('description', $changeRequest->description ?? '') }}</textarea>
                @error('description')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- STATUS --}}
            <div class="col-md-6">
                <label class="form-label fw-semibold text-secondary small">
                    Status <span class="text-danger">*</span>
                </label>
                <select name="status"
                        class="form-select bg-light-focus fw-medium"
                        required>
                    <option value="Draft"
                        @selected(
                            old('status', $changeRequest->status ?? 'Draft') === 'Draft'
                        )>
                        Draft
                    </option>
                    <option value="Pending Approval"
                        @selected(
                            old('status', $changeRequest->status ?? '') === 'Pending Approval'
                        )>
                        Pending Approval
                    </option>
                </select>
                <div class="form-text text-muted small mt-1">
                    Select Pending Approval when the change request is ready to be approved.
                </div>
                @error('status')
                    <div class="text-danger small mt-1">
                        {{ $message }}
                    </div>
                @enderror
            </div>

        </div>
    </div>

</div>

{{-- ============================================================
    CHANGE REQUEST ITEMS
============================================================ --}}
<div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">

    <div class="card-header bg-transparent border-0 pt-4 px-4 pb-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center">
                <div class="p-2 bg-primary bg-opacity-10 rounded-3 text-primary me-3 d-flex align-items-center justify-content-center"
                     style="width:40px; height:40px;">
                    <i class="bi bi-list-check fs-5"></i>
                </div>
                <div>
                    <h5 class="mb-0 fw-bold text-dark">
                        Change Items
                    </h5>
                    <p class="text-muted small mb-0">
                        Add each requested change and its corresponding price.
                    </p>
                </div>
            </div>

            <button type="button"
                    class="btn btn-primary btn-sm rounded-3 px-3 py-1.5 font-medium shadow-xs"
                    id="addChangeItem">
                <i class="bi bi-plus-circle me-1.5"></i>
                Add Change
            </button>
        </div>
    </div>

    <div class="card-body p-4 pt-1">

        @error('items')
            <div class="alert alert-danger py-2 rounded-3 small">
                {{ $message }}
            </div>
        @enderror

        <div class="table-responsive">
            <table class="table align-middle mb-0 custom-items-table" id="changeItemsTable">
                <thead class="bg-light text-secondary">
                    <tr>
                        <th class="ps-3 py-2.5 text-uppercase fs-7 font-semibold tracking-wider">
                            Description
                        </th>
                        <th class="py-2.5 text-uppercase fs-7 font-semibold tracking-wider" width="220">
                            Amount (RM)
                        </th>
                        <th class="pe-3 py-2.5 text-center text-uppercase fs-7 font-semibold tracking-wider" width="60"></th>
                    </tr>
                </thead>

                <tbody>
                    {{-- EDIT MODE --}}
                    @if(isset($changeRequest) && $changeRequest->items->count())

                        @foreach($changeRequest->items as $item)
                            <tr>
                                <td class="ps-3 py-2">
                                    <input type="text"
                                           name="item_description[]"
                                           class="form-control bg-light-focus"
                                           value="{{ old('item_description.' . $loop->index, $item->description) }}"
                                           placeholder="Describe the requested change"
                                           required>
                                </td>

                                <td class="py-2">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted small">RM</span>
                                        <input type="number"
                                               name="item_amount[]"
                                               class="form-control text-end bg-light-focus font-monospace change-item-amount"
                                               value="{{ old('item_amount.' . $loop->index, $item->amount) }}"
                                               min="0"
                                               step="0.01"
                                               required>
                                    </div>
                                </td>

                                <td class="text-center pe-3 py-2">
                                    <button type="button"
                                            class="btn btn-action-danger border rounded-3 removeChangeItem"
                                            title="Remove Item">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                    {{-- VALIDATION FAILED --}}
                    @elseif(old('item_description'))

                        @foreach(old('item_description') as $index => $description)
                            <tr>
                                <td class="ps-3 py-2">
                                    <input type="text"
                                           name="item_description[]"
                                           class="form-control bg-light-focus"
                                           value="{{ $description }}"
                                           placeholder="Describe the requested change"
                                           required>
                                </td>

                                <td class="py-2">
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted small">RM</span>
                                        <input type="number"
                                               name="item_amount[]"
                                               class="form-control text-end bg-light-focus font-monospace change-item-amount"
                                               value="{{ old('item_amount.' . $index, 0) }}"
                                               min="0"
                                               step="0.01"
                                               required>
                                    </div>
                                </td>

                                <td class="text-center pe-3 py-2">
                                    <button type="button"
                                            class="btn btn-action-danger border rounded-3 removeChangeItem"
                                            title="Remove Item">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                    {{-- CREATE MODE --}}
                    @else

                        <tr>
                            <td class="ps-3 py-2">
                                <input type="text"
                                       name="item_description[]"
                                       class="form-control bg-light-focus"
                                       placeholder="Example: Add additional report feature"
                                       required>
                            </td>

                            <td class="py-2">
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted small">RM</span>
                                    <input type="number"
                                           name="item_amount[]"
                                           class="form-control text-end bg-light-focus font-monospace change-item-amount"
                                           value="0"
                                           min="0"
                                           step="0.01"
                                           required>
                                </div>
                            </td>

                            <td class="text-center pe-3 py-2">
                                <button type="button"
                                        class="btn btn-action-danger border rounded-3 removeChangeItem"
                                        title="Remove Item">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>

                    @endif
                </tbody>
            </table>
        </div>

        {{-- TOTAL CALCULATED CONTAINER --}}
        <div class="row justify-content-end mt-4">
            <div class="col-md-5 col-lg-4">
                <div class="rounded-3 p-3" style="background-color: #F4F6F4;">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-semibold text-secondary small text-uppercase tracking-wider">
                            Change Request Total
                        </span>
                        <div class="fw-bold fs-5 text-dark font-monospace">
                            RM <span id="changeRequestTotal">0.00</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<style>
    .fs-7 {
        font-size: 0.75rem !important;
    }
    .shadow-xs {
        box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
    }
    .tracking-wider {
        letter-spacing: 0.5px;
    }

    .bg-light-focus:focus {
        background-color: #ffffff !important;
        border-color: var(--accent-brown, #8C6D53) !important;
        box-shadow: 0 0 0 0.25rem rgba(140, 109, 83, 0.15) !important;
    }

    .input-group:focus-within .input-group-text {
        border-color: var(--accent-brown, #8C6D53) !important;
        background-color: #ffffff !important;
    }

    .custom-items-table th {
        font-weight: 600;
        border-bottom: 1px solid #ECEBE9;
    }

    .btn-action-danger {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #DC3545;
        background-color: #FFFFFF;
        border-color: #F8D7DA !important;
        transition: all 0.2s ease;
    }
    .btn-action-danger:hover {
        background-color: #DC3545;
        color: #FFFFFF;
        border-color: #DC3545 !important;
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const table = document.querySelector('#changeItemsTable tbody');
    const addButton = document.getElementById('addChangeItem');

    /* Add Change Item */
    if (addButton && table) {
        addButton.addEventListener('click', function () {
            const row = table.rows[0].cloneNode(true);

            row.querySelectorAll('input').forEach(function (input) {
                if (input.classList.contains('change-item-amount')) {
                    input.value = '0';
                } else {
                    input.value = '';
                }
            });

            table.appendChild(row);
            calculateTotal();
        });

        /* Remove Change Item */
        table.addEventListener('click', function (event) {
            const removeButton = event.target.closest('.removeChangeItem');
            if (!removeButton) return;

            if (table.rows.length > 1) {
                removeButton.closest('tr').remove();
                calculateTotal();
            }
        });

        /* Recalculate When Amount Changes */
        table.addEventListener('input', function (event) {
            if (event.target.classList.contains('change-item-amount')) {
                calculateTotal();
            }
        });
    }

    /* Calculate Total Sum */
    function calculateTotal() {
        let total = 0;
        document.querySelectorAll('.change-item-amount').forEach(function (input) {
            total += parseFloat(input.value) || 0;
        });

        const totalElement = document.getElementById('changeRequestTotal');
        if (totalElement) {
            totalElement.textContent = total.toFixed(2);
        }
    }

    /* Initial Calculation */
    calculateTotal();
});
</script>
@endpush