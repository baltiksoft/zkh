<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Meter extends Model
{
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
