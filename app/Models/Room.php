<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\Builder;

class Room extends Model
{

    protected $with = ['leases', 'meters', 'latestLease'];
    public function userDetail(): BelongsTo
    {
        return $this->belongsTo(UserDetail::class, 'userdetail_id');
    }

    public function leases(): HasMany
    {
        return $this->hasMany(Lease::class, 'room_id')->orderBy('end_date', 'desc');
    }

    /**
     * Активный договор
     */
    public function latestLease(): HasOne
    {
        return $this->hasOne(Lease::class)->latestOfMany('end_date')->where('end_date', '>=', date('Y-m-d'));
    }

    public function meters(): HasMany
    {
        return $this->hasMany(Meter::class, 'room_id')->orderBy('id');
    }
}
