<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserDetail extends Model
{
    // Разрешаем заполнение всех полей, кроме защищенных
    protected $guarded = [];
    protected $table = 'user_detail';

    protected $appends = ['full_name', 'short_name', 'age', 'age_with_suffix', 'masked_series'];

    // Указываем, что дата рождения и дата выдачи — это даты (Carbon объекты)
    protected $casts = [
        'birthdate' => 'date',
        'passport_date' => 'date',
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                return collect([
                    $attributes['family']   ?? null,
                    $attributes['name']  ?? null,
                    $attributes['surname'] ?? null,
                ])
                    ->filter() // Удаляет null, false и пустые строки
                    ->implode(' '); // Соединяет через пробел
            },
        );
    }

    protected function shortName(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                $f = $attributes['family'] ?? '';
                $i = isset($attributes['name']) ? mb_substr($attributes['name'], 0, 1) . '.' : '';
                $o = isset($attributes['surname']) ? mb_substr($attributes['surname'], 0, 1) . '.' : '';

                return trim("{$f} {$i}{$o}");
            },
        );
    }

    protected function maskedSeries(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                $series = $attributes['passport_series'];
                $number = $attributes['passport_number'];
                return mb_substr($series, 0, 2) . '** **' . mb_substr($series, 2, 2) . '**';
            }
        );
    }

    protected function age(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                // Если дата рождения не заполнена, возвращаем null
                if (empty($attributes['birthdate'])) {
                    return null;
                }

                // Создаем объект даты и считаем разницу с текущим моментом в годах
                return \Carbon\Carbon::parse($attributes['birthdate'])->age;
            },
        );
    }

    protected function ageWithSuffix(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                if (empty($attributes['birthdate'])) return null;

                $age = \Carbon\Carbon::parse($attributes['birthdate'])->age;

                // Логика склонения
                $lastDigit = $age % 10;
                $lastTwoDigits = $age % 100;

                if ($lastTwoDigits >= 11 && $lastTwoDigits <= 19) {
                    $suffix = 'лет';
                } elseif ($lastDigit === 1) {
                    $suffix = 'год';
                } elseif ($lastDigit >= 2 && $lastDigit <= 4) {
                    $suffix = 'года';
                } else {
                    $suffix = 'лет';
                }

                return "{$age} {$suffix}";
            },
        );
    }


    // Обратная связь: паспорт принадлежит пользователю
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'userdetail_id');
    }
}
