<?php

namespace Database\Seeders;

use App\Models\Tariff;
use Illuminate\Database\Seeder;

class TariffSeeder extends Seeder
{
    public function run(): void
    {
        Tariff::create([
            'id' => 1,
            'meter_id' => 1,
            'price' => 6.79,
            'unit_id' => 1,
            'active_from' => '2021-01-01',
        ]);

        Tariff::create([
            'id' => 2,
            'meter_id' => 2,
            'price' => 2.81,
            'unit_id' => 1,
            'active_from' => '2021-01-01',
        ]);

        Tariff::create([
            'id' => 3,
            'meter_id' => 3,
            'price' => 97.14,
            'unit_id' => 2,
            'active_from' => '2021-01-01',
        ]);

        Tariff::create([
            'id' => 4,
            'meter_id' => 4,
            'price' => 300.889344,
            'unit_id' => 2,
            'active_from' => '2021-01-01',
        ]);
    }
}
