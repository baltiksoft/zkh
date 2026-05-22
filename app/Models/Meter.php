<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Meter extends Model
{
    protected $with = ['latestReading'];

    public function readings(): HasMany
    {
        return $this->hasMany(MeterReading::class);
    }

    /**
     * Самое последнее (текущее) показание
     */
    public function latestReading(): HasOne
    {
        return $this->hasOne(MeterReading::class)->latestOfMany('reported_at');
    }

    /**
     * Предыдущее показание (перед самым последним)
     */
    public function previousReading()
    {
        return $this->readings()
            ->orderBy('reported_at', 'desc')
            ->skip(1) // Пропускаем самое последнее
            ->first();
    }

    public function metertype(): BelongsTo
    {
        return $this->belongsTo(MeterType::class, 'metertype_id');
    }

    protected function casts(): array
    {
        return [
            'verification' => 'date',
        ];
    }
}
