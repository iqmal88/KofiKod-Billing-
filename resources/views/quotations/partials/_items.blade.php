<!-- Section Header Visual Link -->
<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div class="d-flex align-items-center">
        <div class="p-2 bg-success bg-opacity-10 rounded-3 text-success me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            <i class="bi bi-list-ul fs-5"></i>
        </div>
        <div>
            <h5 class="mb-0 fw-bold text-dark">Line Items Workspace</h5>
            <p class="text-muted small mb-0">Define structural services, physical scopes, quantities, and milestone billing units</p>
        </div>
    </div>
    
    <button type="button" class="btn btn-light border text-dark font-medium px-3 py-2 rounded-3 btn-add-row-action d-inline-flex align-items-center shadow-xs" id="addItem">
        <i class="bi bi-plus-lg me-2 text-success"></i> Add New Row
    </button>
</div>

<!-- Main Table Grid Module Container Workspace -->
<div class="table-responsive">
    <table class="table align-middle custom-line-entry-table mb-0" id="itemsTable">
        <thead class="bg-light text-secondary">
            <tr>
                <th class="ps-3 py-3 text-uppercase fs-7 font-semibold tracking-wider">Service / Deliverable Item Description</th>
                <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider" width="100">Qty</th>
                <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider" width="180">Unit Price</th>
                <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider" width="180">Total Amount</th>
                <th class="pe-3 py-3 text-center text-uppercase fs-7 font-semibold tracking-wider" width="60"></th>
            </tr>
        </thead>
        <tbody>
            @if(isset($quotation) && $quotation->items->count())
                @foreach($quotation->items as $item)
                    <tr>
                        <td class="ps-3">
                            <input
                                type="text"
                                name="item_name[]"
                                class="form-control bg-light-focus"
                                placeholder="e.g. Website Interface UI/UX Wireframing Design"
                                value="{{ old('item_name.' . $loop->index, $item->item_name) }}" required>
                        </td>
                        <td>
                            <input
                                type="number"
                                name="quantity[]"
                                class="form-control bg-light-focus text-center quantity"
                                placeholder="1"
                                min="1"
                                value="{{ old('quantity.' . $loop->index, $item->quantity) }}" required>
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted small py-1 px-2.5">RM</span>
                                <input
                                    type="number"
                                    step="0.01"
                                    name="unit_price[]"
                                    class="form-control bg-light-focus unit_price"
                                    placeholder="0.00"
                                    min="0"
                                    value="{{ old('unit_price.' . $loop->index, $item->unit_price) }}" required>
                            </div>
                        </td>
                        <td>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-muted small py-1 px-2.5">RM</span>
                                <input
                                    type="number"
                                    step="0.01"
                                    name="amount[]"
                                    class="form-control bg-light text-dark fw-bold amount"
                                    value="{{ old('amount.' . $loop->index, $item->amount) }}"
                                    readonly>
                            </div>
                        </td>
                        <td class="pe-3 text-center">
                            <button type="button" class="btn btn-link link-danger p-1 removeItem" title="Remove Row Item">
                                <i class="bi bi-trash3 fs-5"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
                <!-- Default Baseline Entry Line row mapping logic hook -->
                <tr>
                    <td class="ps-3">
                        <input
                            type="text"
                            name="item_name[]"
                            class="form-control bg-light-focus"
                            placeholder="e.g. Core System Feature Engineering Operations" required>
                    </td>
                    <td>
                        <input
                            type="number"
                            name="quantity[]"
                            class="form-control bg-light-focus text-center quantity"
                            value="1"
                            min="1" required>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted small py-1 px-2.5">RM</span>
                            <input
                                type="number"
                                step="0.01"
                                name="unit_price[]"
                                class="form-control bg-light-focus unit_price"
                                placeholder="0.00"
                                min="0"
                                value="0.00" required>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <span class="input-group-text bg-light text-muted small py-1 px-2.5">RM</span>
                            <input
                                type="number"
                                step="0.01"
                                name="amount[]"
                                class="form-control bg-light text-dark fw-bold amount"
                                value="0.00"
                                readonly>
                        </div>
                    </td>
                    <td class="pe-3 text-center">
                        <button type="button" class="btn btn-link link-danger p-1 removeItem" title="Remove Row Item">
                            <i class="bi bi-trash3 fs-5"></i>
                        </button>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<style>
    /* Table scope UI alignment configuration rules */
    .fs-7 {
        font-size: 0.75rem !important;
    }
    .shadow-xs {
        box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
    }
    .custom-line-entry-table th {
        font-weight: 600;
        border-bottom: 1px solid #ECEBE9;
    }
    .custom-line-entry-table td {
        border-bottom: 1px solid #F3F2F0;
        padding-top: 12px;
        padding-bottom: 12px;
    }
    .custom-line-entry-table tbody tr:last-child td {
        border-bottom: 0;
    }
    .btn-add-row-action:hover {
        background-color: #F1F0EE !important;
    }
    .input-group:focus-within .input-group-text {
        border-color: var(--accent-brown) !important;
        background-color: #fff !important;
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#itemsTable tbody');

    // Add Dynamic Table Line Row Framework
    document.getElementById('addItem').addEventListener('click', function () {
        const rows = tableBody.querySelectorAll('tr');
        if (rows.length === 0) return;
        
        // Clone the first row structural signature baseline safely
        const newRow = rows[0].cloneNode(true);

        // Reset and normalize entry parameter states safely without targeting missing DOM types
        newRow.querySelectorAll('input').forEach(function(input) {
            if (input.classList.contains('quantity')) {
                input.value = 1;
            } else if (input.classList.contains('unit_price') || input.classList.contains('amount')) {
                input.value = "0.00";
            } else {
                input.value = "";
            }
            // Remove lingering validation error borders if present
            input.classList.remove('is-invalid');
        });

        tableBody.appendChild(newRow);
        calculateTotalFormSummaryValues();
    });

    // Remove Selected Line Row Trigger
    tableBody.addEventListener('click', function(e) {
        if (e.target.closest('.removeItem')) {
            const rows = tableBody.querySelectorAll('tr');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                calculateTotalFormSummaryValues();
            } else {
                alert('Your quotation documentation must retain at least one baseline billing item row.');
            }
        }
    });

    // Watch values changes mapping live computation updates
    tableBody.addEventListener('input', function(e) {
        if (e.target.classList.contains('quantity') || e.target.classList.contains('unit_price')) {
            calculateTotalFormSummaryValues();
        }
    });

    // Unified live arithmetic summation computation block engine
    function calculateTotalFormSummaryValues() {
        let subtotalAccumulator = 0;

        tableBody.querySelectorAll('tr').forEach(function(row) {
            const qtyField = row.querySelector('.quantity');
            const priceField = row.querySelector('.unit_price');
            const amountField = row.querySelector('.amount');

            if (!qtyField || !priceField || !amountField) return;

            let qty = parseFloat(qtyField.value) || 0;
            let price = parseFloat(priceField.value) || 0;
            let amount = qty * price;

            amountField.value = amount.toFixed(2);
            subtotalAccumulator += amount;
        });

        // Broadcast calculation matrix values outward cleanly into parent summary modules listeners
        const externalParentSubtotalTrackerField = document.getElementById('subtotal');
        if (externalParentSubtotalTrackerField) {
            externalParentSubtotalTrackerField.value = subtotalAccumulator.toFixed(2);
            externalParentSubtotalTrackerField.dispatchEvent(new Event('input', { bubbles: true }));
        }
    }

    // Initialize tracking validation states calculations context instantly at load time
    calculateTotalFormSummaryValues();
});
</script>
@endpush