<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Room extends Model
{
    public function userDetail(): BelongsTo
    {
        return $this->belongsTo(UserDetail::class, 'userdetail_id');
    }
}
