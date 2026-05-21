<?php

namespace Database\Seeders;

use App\Models\MeterReading;
use Illuminate\Database\Seeder;

class MeterReadingSeeder extends Seeder
{
    public function run(): void
    {
        MeterReading::create([
            'id' => 1,
            'lease_id' => 1,
            'meter_id' => 1,
            'value' => 32745,
            'consumption' => null,
            'reported_at' => '2024-11-07',
        ]);
        MeterReading::create([
            'id' => 2,
            'lease_id' => 1,
            'meter_id' => 2,
            'value' => 8010,
            'consumption' => null,
            'reported_at' => '2024-11-07',
        ]);
        MeterReading::create([
            'id' => 3,
            'lease_id' => 1,
            'meter_id' => 3,
            'value' => 596,
            'consumption' => null,
            'reported_at' => '2024-11-07',
        ]);
        MeterReading::create([
            'id' => 4,
            'lease_id' => 1,
            'meter_id' => 4,
            'value' => 695,
            'consumption' => null,
            'reported_at' => '2024-11-07',
        ]);

        // 1
        MeterReading::create([
            'id' => 5,
            'lease_id' => 1,
            'meter_id' => 1,
            'value' => 32809,
            'consumption' => 64,
            'reported_at' => '2024-11-20',
        ]);
        MeterReading::create([
            'id' => 6,
            'lease_id' => 1,
            'meter_id' => 2,
            'value' => 8031,
            'consumption' => 21,
            'reported_at' => '2024-11-20',
        ]);
        MeterReading::create([
            'id' => 7,
            'lease_id' => 1,
            'meter_id' => 3,
            'value' => 601,
            'consumption' => 5,
            'reported_at' => '2024-11-20',
        ]);
        MeterReading::create([
            'id' => 8,
            'lease_id' => 1,
            'meter_id' => 4,
            'value' => 701,
            'consumption' => 6,
            'reported_at' => '2024-11-20',
        ]);

        // 2
        MeterReading::create([
            'id' => 9,
            'lease_id' => 1,
            'meter_id' => 1,
            'value' => 32962,
            'consumption' => 153,
            'reported_at' => '2024-12-20',
        ]);
        MeterReading::create([
            'id' => 10,
            'lease_id' => 1,
            'meter_id' => 2,
            'value' => 8086,
            'consumption' => 55,
            'reported_at' => '2024-12-20',
        ]);
        MeterReading::create([
            'id' => 11,
            'lease_id' => 1,
            'meter_id' => 3,
            'value' => 610,
            'consumption' => 9,
            'reported_at' => '2024-12-20',
        ]);
        MeterReading::create([
            'id' => 12,
            'lease_id' => 1,
            'meter_id' => 4,
            'value' => 710,
            'consumption' => 9,
            'reported_at' => '2024-12-20',
        ]);
    }
}
