<div class="d-flex flex-column gap-3">
    
    {{-- Field Block: Subtotal --}}
    <div>
        <label for="subtotal" class="form-label fw-semibold text-secondary small">Calculated Subtotal</label>
        <div class="input-group">
            <span class="input-group-text bg-light text-muted small py-1 px-2.5">RM</span>
            <input
                type="number"
                step="0.01"
                id="subtotal"
                name="subtotal"
                class="form-control bg-light text-secondary text-end font-monospace fw-semibold"
                value="{{ old('subtotal', $quotation->subtotal ?? '0.00') }}"
                readonly>
        </div>
    </div>

    {{-- Field Block: Discount Value --}}
    <div>
        <label for="discount" class="form-label fw-semibold text-secondary small">Applied Discount (Deduction)</label>
        <div class="input-group">
            <span class="input-group-text bg-light text-muted small py-1 px-2.5">RM</span>
            <input
                type="number"
                step="0.01"
                id="discount"
                name="discount"
                class="form-control bg-light-focus text-end font-monospace text-danger"
                value="{{ old('discount', $quotation->discount ?? '0.00') }}"
                min="0">
        </div>
    </div>

    {{-- Field Block: Tax Additions --}}
    <div>
        <label for="tax" class="form-label fw-semibold text-secondary small">Service Tax / SST charges</label>
        <div class="input-group">
            <span class="input-group-text bg-light text-muted small py-1 px-2.5">RM</span>
            <input
                type="number"
                step="0.01"
                id="tax"
                name="tax"
                class="form-control bg-light-focus text-end font-monospace text-dark"
                value="{{ old('tax', $quotation->tax ?? '0.00') }}"
                min="0">
        </div>
    </div>

    <hr class="my-2 opacity-50">

    {{-- Highlight Container Block Component: Net Grand Total --}}
    <div class="p-3 rounded-3 border-0 shadow-xs mb-1" style="background-color: #F4F6F4;">
        <label for="total" class="form-label fw-bold text-dark small text-uppercase tracking-wider">Net Grand Total</label>
        <div class="input-group">
            <span class="input-group-text border-0 text-white font-medium bg-success bg-opacity-70 px-2.5">RM</span>
            <input
                type="number"
                step="0.01"
                id="total"
                name="total"
                class="form-control border-0 text-end font-monospace fw-bold fs-4 text-dark bg-transparent p-0 pe-2"
                value="{{ old('total', $quotation->total ?? '0.00') }}"
                readonly style="box-shadow: none !important;">
        </div>
    </div>
</div>

<style>
    /* Focus highlights tied natively into core system palettes rules */
    .bg-light-focus:focus {
        background-color: #ffffff !important;
        border-color: var(--accent-brown) !important;
        box-shadow: 0 0 0 0.25rem rgba(140, 109, 83, 0.15) !important;
    }
    .input-group:focus-within .input-group-text {
        border-color: var(--accent-brown) !important;
        background-color: #fff !important;
    }
    .shadow-xs {
        box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
    }
    .tracking-wider {
        letter-spacing: 0.5px;
    }
</style>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const subtotalInput = document.getElementById('subtotal');
    const discountInput = document.getElementById('discount');
    const taxInput = document.getElementById('tax');
    const totalInput = document.getElementById('total');

    function calculateGrandTotal() {
        if (!subtotalInput || !discountInput || !taxInput || !totalInput) return;

        let sub = parseFloat(subtotalInput.value) || 0;
        let dis = parseFloat(discountInput.value) || 0;
        let taxAmount = parseFloat(taxInput.value) || 0;

        let grandTotal = sub - dis + taxAmount;

        if (grandTotal < 0) {
            grandTotal = 0;
        }

        totalInput.value = grandTotal.toFixed(2);
    }

    // Bind event listeners safely to prevent runtime breakdown faults
    if (discountInput) discountInput.addEventListener('input', calculateGrandTotal);
    if (taxInput) taxInput.addEventListener('input', calculateGrandTotal);
    if (subtotalInput) subtotalInput.addEventListener('input', calculateGrandTotal);

    // Initial compute cycle initialization execution
    calculateGrandTotal();
});
</script>
@endpush