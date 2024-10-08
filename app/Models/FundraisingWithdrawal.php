<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class FundraisingWithdrawal extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'proof',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'amount_requested',
        'amount_received',
        'has_received',
        'has_sent',
        'fundraiser_id',
        'fundraising_id',
    ];

    public function fundraiser(): BelongsTo
    {
        return $this->belongsTo(Fundraiser::class);
    }

    public function fundraising(): BelongsTo
    {
        return $this->belongsTo(Fundraising::class);
    }
}
