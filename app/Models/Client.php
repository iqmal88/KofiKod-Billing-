<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'company_name',
        'person_in_charge',
        'phone',
        'email',
        'address',
    ];

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class);
    }
}