<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChangeRequestItem extends Model
{
    protected $fillable = [

        'change_request_id',

        'description',

        'amount',

    ];

    protected $casts = [

        'amount' => 'decimal:2',

    ];

    public function changeRequest(): BelongsTo
    {
        return $this->belongsTo(ChangeRequest::class);
    }
}