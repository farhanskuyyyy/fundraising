<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fundraising extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'target_amount',
        'about',
        'is_active',
        'has_finished',
        'thumbnail',
        'fundraiser_id',
        'category_id',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function fundraiser(): BelongsTo
    {
        return $this->belongsTo(Fundraiser::class);
    }

    public function donaturs(): HasMany
    {
        return $this->hasMany(Donatur::class)->where('is_paid',1);
    }

    public function totalReachedAmount()
    {
        return $this->donaturs()->sum('total_amount');
    }

    public function withdrawals(): HasMany
    {
        return $this->hasMany(FundraisingWithdrawal::class);
    }

    public function phases(): HasMany
    {
        return $this->hasMany(FundraisingPhase::class);
    }

}
