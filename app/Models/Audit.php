<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $fillable = [
        'token_symbol',
        'token_name',
        'risk_score',
        'threat_level',
        'reasoning',
        'is_paid',
        'tx_hash',
        'amount_xlm',
    ];
}
