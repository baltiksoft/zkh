<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Invoice extends Model
{
    protected $fillable = ['lease_id', 'meterreading_id', 'amount', 'status', 'due_date'];

    public function payments(): BelongsToMany
    {
        return $this->belongsToMany(Payment::class)
            ->withPivot('amount') // Позволяет обращаться к $payment->pivot->amount
            ->withTimestamps();
    }

    /**
     * Посчитать, сколько уже фактически оплачено по этому счету
     */
    public function getPaidAmountAttribute(): float
    {
        return (float) $this->payments()->sum('invoice_payment.amount');
    }

    /**
     * Сколько осталось доплатить по счету
     */
    public function getAmountLeftAttribute(): float
    {
        return max(0, $this->amount - $this->paid_amount);
    }
}
