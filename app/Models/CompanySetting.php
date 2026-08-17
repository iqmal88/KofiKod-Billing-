<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    protected $fillable = [
        'company_name',
        'company_tagline',
        'logo',
        'phone',
        'email',
        'website',
        'address',
        'bank_name',
        'bank_account',
        'bank_holder',
        'signature',
        'terms_conditions',
    ];
}