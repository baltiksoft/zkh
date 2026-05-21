<?php

namespace Database\Seeders;

use App\Models\Meter;
use App\Models\MeterType;
use Illuminate\Database\Seeder;

class MeterSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(MeterTypeSeeder::class);

        Meter::create([
            'id' => 1,
            'room_id' => 1,
            'metertype_id' => 1,
            'name' => 'Счётчик электроэнергии, тариф Т1',
            'marka' => 'Меркурий-200',
            'number' => '2158119600',
            'verification' => '2031-07-02',
        ]);

        Meter::create([
            'id' => 2,
            'room_id' => 1,
            'metertype_id' => 1,
            'name' => 'Счётчик электроэнергии, тариф Т2',
            'marka' => 'Меркурий-200',
            'number' => '2158119600',
            'verification' => '2031-07-02',
        ]);

        Meter::create([
            'id' => 3,
            'room_id' => 1,
            'metertype_id' => 2,
            'name' => 'Счётчик холодной воды',
            'number' => '11 5582350',
            'verification' => '2029-09-13',
        ]);

        Meter::create([
            'id' => 4,
            'room_id' => 1,
            'metertype_id' => 2,
            'name' => 'Счётчик горячей воды',
            'number' => '2502698820',
            'verification' => '2031-06-10',
        ]);

        $this->call(MeterReadingSeeder::class);
    }
}
