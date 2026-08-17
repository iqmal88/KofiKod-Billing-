<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    protected $fillable = [

        'invoice_id',

        'item_type',

        'payment_term_id',

        'change_request_id',

        'title',

        'description',

        'percentage',

        'amount',

    ];

    protected $casts = [

        'percentage' => 'decimal:2',

        'amount' => 'decimal:2',

    ];

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function paymentTerm(): BelongsTo
    {
        return $this->belongsTo(PaymentTerm::class);
    }

    public function changeRequest(): BelongsTo
    {
        return $this->belongsTo(ChangeRequest::class);
    }
}