<div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
    <div class="d-flex align-items-center">
        <div class="p-2 bg-success bg-opacity-10 rounded-3 text-success me-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
            <i class="bi bi-credit-card-fill fs-5"></i>
        </div>
        <div>
            <h5 class="mb-0 fw-bold text-dark">Payment Schedule Phases</h5>
            <p class="text-muted small mb-0">Break down project milestones into partial billing installments matching project progress</p>
        </div>
    </div>
    
    <button type="button" class="btn btn-light border text-dark font-medium px-3 py-2 rounded-3 btn-add-phase-action d-inline-flex align-items-center shadow-xs" id="addPayment">
        <i class="bi bi-plus-lg me-2 text-success"></i> Add Phase
    </button>
</div>

<div class="table-responsive">
    <table class="table align-middle custom-payment-table mb-0" id="paymentTable">
        <thead class="bg-light text-secondary">
            <tr>
                <th class="ps-3 py-3 text-uppercase fs-7 font-semibold tracking-wider" width="280">Payment Stage / Title</th>
                <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider" width="160">Percentage (%)</th>
                <th class="py-3 text-uppercase fs-7 font-semibold tracking-wider">Milestone Trigger Description</th>
                <th class="pe-3 py-3 text-center text-uppercase fs-7 font-semibold tracking-wider" width="60"></th>
            </tr>
        </thead>
        <tbody>
            @if(isset($quotation) && $quotation->paymentTerms->count())
                @foreach($quotation->paymentTerms as $term)
                    <tr>
                        <td class="ps-3">
                            <input
                                type="text"
                                name="payment_title[]"
                                class="form-control bg-light-focus"
                                placeholder="e.g. Deposit / Project Initiation"
                                value="{{ old('payment_title.' . $loop->index, $term->title) }}" required>
                        </td>
                        <td>
                            <div class="input-group">
                                <input
                                    type="number"
                                    name="payment_percentage[]"
                                    class="form-control bg-light-focus text-center payment-percentage"
                                    placeholder="0"
                                    value="{{ old('payment_percentage.' . $loop->index, $term->percentage) }}"
                                    min="0"
                                    max="100"
                                    step="0.01" required>
                                <span class="input-group-text bg-light text-muted small px-2.5">%</span>
                            </div>
                        </td>
                        <td>
                            <input
                                type="text"
                                name="payment_description[]"
                                class="form-control bg-light-focus"
                                placeholder="e.g. Payable upon delivery of design wireframes"
                                value="{{ old('payment_description.' . $loop->index, $term->description) }}">
                        </td>
                        <td class="pe-3 text-center">
                            <button type="button" class="btn btn-link link-danger p-1 removePayment" title="Remove Milestone Phase">
                                <i class="bi bi-trash3 fs-5"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="ps-3">
                        <input
                            type="text"
                            name="payment_title[]"
                            class="form-control bg-light-focus"
                            placeholder="e.g. Commencement Deposit" required>
                    </td>
                    <td>
                        <div class="input-group">
                            <input
                                type="number"
                                name="payment_percentage[]"
                                class="form-control bg-light-focus text-center payment-percentage"
                                value="0"
                                min="0"
                                max="100"
                                step="0.01" required>
                            <span class="input-group-text bg-light text-muted small px-2.5">%</span>
                        </div>
                    </td>
                    <td>
                        <input
                            type="text"
                            name="payment_description[]"
                            class="form-control bg-light-focus"
                            placeholder="e.g. Upfront payment required to initiate design sprint operations">
                    </td>
                    <td class="pe-3 text-center">
                        <button type="button" class="btn btn-link link-danger p-1 removePayment" title="Remove Milestone Phase">
                            <i class="bi bi-trash3 fs-5"></i>
                        </button>
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-end align-items-center mt-3 px-3 py-2 bg-light rounded-3 border border-light">
    <div class="small fw-semibold text-secondary me-2">Accumulated Schedule Weight:</div>
    <div id="paymentTotal" class="fw-bold fs-5 font-monospace text-success">0%</div>
</div>

<style>
    /* Table scope UI alignment configuration rules */
    .fs-7 {
        font-size: 0.75rem !important;
    }
    .shadow-xs {
        box-shadow: 0 1px 2px rgba(0,0,0,0.04) !important;
    }
    .custom-payment-table th {
        font-weight: 600;
        border-bottom: 1px solid #ECEBE9;
    }
    .custom-payment-table td {
        border-bottom: 1px solid #F3F2F0;
        padding-top: 12px;
        padding-bottom: 12px;
    }
    .custom-payment-table tbody tr:last-child td {
        border-bottom: 0;
    }
    .btn-add-phase-action:hover {
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
    const paymentBody = document.querySelector('#paymentTable tbody');

    // Add Row Cloner Logic Implementation
    document.getElementById('addPayment').addEventListener('click', function () {
        const rows = paymentBody.querySelectorAll('tr');
        if (rows.length === 0) return;

        const newRow = rows[0].cloneNode(true);

        newRow.querySelectorAll('input').forEach(function(input) {
            if (input.classList.contains('payment-percentage')) {
                input.value = 0;
            } else {
                input.value = '';
            }
            input.classList.remove('is-invalid');
        });

        paymentBody.appendChild(newRow);
        calculatePercentage();
    });

    // Remove Selected Phase Trigger Row Execution
    paymentBody.addEventListener('click', function (e) {
        if (e.target.closest('.removePayment')) {
            const rows = paymentBody.querySelectorAll('tr');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                calculatePercentage();
            } else {
                alert('Your payment terms mapping must retain at least one baseline phase distribution line.');
            }
        }
    });

    // Real-time calculation change listener
    paymentBody.addEventListener('input', function (e) {
        if (e.target.classList.contains('payment-percentage')) {
            calculatePercentage();
        }
    });

    // Metric percentage checker framework
    function calculatePercentage() {
        let totalWeightAccumulator = 0;

        document.querySelectorAll('.payment-percentage').forEach(function (input) {
            totalWeightAccumulator += parseFloat(input.value) || 0;
        });

        const outputIndicatorElement = document.getElementById('paymentTotal');
        if (outputIndicatorElement) {
            outputIndicatorElement.innerHTML = totalWeightAccumulator.toFixed(2) + "%";

            if (totalWeightAccumulator > 100) {
                outputIndicatorElement.classList.remove('text-success');
                outputIndicatorElement.classList.add('text-danger');
            } else if (totalWeightAccumulator === 100) {
                outputIndicatorElement.classList.remove('text-danger');
                outputIndicatorElement.classList.add('text-success');
            } else {
                // If it is below 100%, show text warning using brown tone values
                outputIndicatorElement.classList.remove('text-success', 'text-danger');
                outputIndicatorElement.style.color = 'var(--accent-brown)';
            }
        }
    }

    // Call execution instantly upon bootup frame
    calculatePercentage();
});
</script>
@endpush