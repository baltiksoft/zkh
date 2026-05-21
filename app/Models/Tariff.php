<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected function casts(): array
    {
        return [
            'active_from' => 'date',
        ];
    }
}
