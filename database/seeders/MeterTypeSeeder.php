<?php

namespace Database\Seeders;

use App\Models\MeterType;
use Illuminate\Database\Seeder;

class MeterTypeSeeder extends Seeder
{
    public function run(): void
    {
        MeterType::create([
            'id' => 1,
            'name' => 'Электроэнергии'
        ]);

        MeterType::create([
            'id' => 2,
            'name' => 'Воды'
        ]);
    }
}
