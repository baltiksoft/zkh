<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeterReading extends Model
{
    protected $fillable = ['lease_id', 'meter_id', 'value', 'reported_at', 'consumption'];

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
}
