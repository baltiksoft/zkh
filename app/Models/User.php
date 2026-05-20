<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<string>|bool
     */
    protected $guarded = ['id'];

    protected $with = ['userDetail', 'userDetail.rooms'];
    protected $appends = ['short_name'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function shortName(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Проверяем, заполнены ли паспортные данные, чтобы не вызвать ошибку
                return $this->usertDetail
                    ? $this->userDetail->family
                    : $this->name; // Фоллбэк: если паспорта нет, вернет дефолтное имя
            }
        );
    }

    public function userDetail(): HasOne
    {
        return $this->hasOne(UserDetail::class);
    }
}
