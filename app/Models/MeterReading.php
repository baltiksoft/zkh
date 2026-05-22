<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MeterReading extends Model
{
    protected $fillable = ['lease_id', 'meter_id', 'value', 'reported_at', 'consumption'];
    protected $casts = [
        'reported_at' => 'date', // Laravel сам превратит строку из базы в объект Carbon
    ];

    protected $with = ['meter', 'invoice'];

    protected static function booted()
    {
        static::creating(function (MeterReading $reading) {
            // Ищем последнее показание этого счётчика
            $previous = MeterReading::where('meter_id', $reading->meter_id)
                ->orderBy('reported_at', 'desc')
                ->first();

            if ($previous) {
                // Вычисляем разницу
                $reading->consumption = $reading->reading_value - $previous->reading_value;
            } else {
                // Если это самое первое показание
                $reading->consumption = 0;
            }
        });
    }

    /**
     * Связь со счётчиком: Показание всегда принадлежит конкретному счётчику
     */
    public function meter(): BelongsTo
    {
        return $this->belongsTo(Meter::class);
    }

    /**
     * Связь со счётом: Одно показание генерирует один счёт на оплату
     */
    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }
}
