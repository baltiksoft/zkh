<?php

namespace Database\Seeders;

use App\Models\Lease;
use Illuminate\Database\Seeder;

class LeaseSeader extends Seeder
{
    public function run(): void
    {
        Lease::create([
            'id' => 1,
            'room_id' => 1,
            'userdetail_id' => 2,
            'start_date' => '2024-11-07',
            'end_date' => '2026-04-06',
            'is_renewable' => true,
            'payment_day' => 7,
            'price' => 75000,
        ]);

        Lease::create([
            'id' => 2,
            'room_id' => 1,
            'userdetail_id' => 3,
            'start_date' => '2026-05-07',
            'end_date' => '2026-09-06',
            'payment_day' => 7,
            'price' => 73000,
        ]);
    }
}
