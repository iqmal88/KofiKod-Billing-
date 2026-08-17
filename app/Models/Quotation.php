<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quotation extends Model
{
    protected $fillable = [
        'quotation_no',
        'client_id',
        'quotation_date',
        'validity_days',
        'project_name',
        'project_description',
        'project_start',
        'project_end',
        'subtotal',
        'discount',
        'tax',
        'total',
        'status',
    ];

    protected $casts = [
        'quotation_date' => 'date',
        'project_start' => 'date',
        'project_end' => 'date',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function paymentTerms(): HasMany
    {
        return $this->hasMany(PaymentTerm::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }
    
    public function changeRequests(): HasMany
    {
        return $this->hasMany(ChangeRequest::class);
    }
}