<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserDetail::create([
            'id' => 1,
            'user_id' => 1,
            'family' => 'Иванов',
            'name' => 'Иван',
            'surname' => 'Иванович',
            'birthdate' => '2002-07-02',
            'passport_series' => '4025',
            'passport_number' => '123456',
            'passport_issued' => 'ГОМ №5 в городе Люберцы Московской области',
            'passport_date' => '2025-02-19',
            'passport_code' => '298-077',
            'address' => 'Московская область, г.о. Люберцы, ул.Кирова, д.22 кв 111',
        ]);

        UserDetail::create([
            'id' => 2,
            'user_id' => 2,
            'family' => 'Нагайделли',
            'name' => 'Инна',
            'surname' => 'Алексеевна',
            'birthdate' => '1998-22-05',
            'passport_series' => '4011',
            'passport_number' => '654321',
            'passport_issued' => 'Отделом полиции №45 по г.Москва',
            'passport_date' => '2011-11-28',
            'passport_code' => '050-445',
            'address' => 'г.Москва, ул.Генерала Кузнецова, д.5 корп.1 кв.114',
        ]);

        UserDetail::create([
            'id' => 3,
            'user_id' => 3,
            'family' => 'Пуганц',
            'name' => 'Екатерина',
            'surname' => 'Михайлов',
            'birthdate' => '2002-20-06',
            'passport_series' => '4026',
            'passport_number' => '455667',
            'passport_issued' => 'Отделом полиции №45 по г.Москва',
            'passport_date' => '2024-07-08',
            'passport_code' => '055-145',
            'address' => 'Московская область, г.о.Сергев-Посад',
        ]);

        $this->call(RoomSeeder::class);
    }
}
