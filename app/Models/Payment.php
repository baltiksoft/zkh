<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Payment extends Model
{
    protected $fillable = ['lease_id', 'amount', 'transaction_id', 'paid_at'];
    protected $with = ['invoices'];

    public function invoices(): BelongsToMany
    {
        return $this->belongsToMany(Invoice::class)
            ->withPivot('amount')
            ->withTimestamps();
    }
}
