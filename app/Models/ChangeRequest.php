<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChangeRequest extends Model
{
    protected $fillable = [

        'quotation_id',

        'change_request_no',

        'request_date',

        'title',

        'description',

        'total',

        'status',

        'approved_date',

    ];

    protected $casts = [

        'request_date' => 'date',

        'approved_date' => 'date',

        'total' => 'decimal:2',

    ];

    public function quotation(): BelongsTo
    {
        return $this->belongsTo(Quotation::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ChangeRequestItem::class);
    }

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}