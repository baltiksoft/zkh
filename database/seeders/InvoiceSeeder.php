<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        Invoice::create([
            'lease_id' => 1,
            'meterreading_id' => 5,
            'amount' => 434.56,
            'status' => 'paid',
            'due_date'  => '2024-12-08',
        ]);

        Invoice::create([
            'lease_id' => 1,
            'meterreading_id' => 6,
            'amount' => 59.01,
            'status' => 'paid',
            'due_date'  => '2024-12-08',
        ]);

        Invoice::create([
            'lease_id' => 1,
            'meterreading_id' => 7,
            'amount' => 485.7,
            'status' => 'paid',
            'due_date'  => '2024-12-08',
        ]);

        Invoice::create([
            'lease_id' => 1,
            'meterreading_id' => 8,
            'amount' => 1805.37,
            'status' => 'paid',
            'due_date'  => '2024-12-08',
        ]);

        Invoice::create([
            'lease_id' => 1,
            'meterreading_id' => 9,
            'amount' => 1038.87,
            'status' => 'unpaid',
            'due_date'  => '2025-01-08',
        ]);

        Invoice::create([
            'lease_id' => 1,
            'meterreading_id' => 10,
            'amount' => 154.55,
            'status' => 'unpaid',
            'due_date'  => '2025-01-08',
        ]);

        Invoice::create([
            'lease_id' => 1,
            'meterreading_id' => 11,
            'amount' => 874.26,
            'status' => 'unpaid',
            'due_date'  => '2025-01-08',
        ]);

        Invoice::create([
            'lease_id' => 1,
            'meterreading_id' => 12,
            'amount' => 2708,
            'status' => 'unpaid',
            'due_date'  => '2025-01-08',
        ]);
    }
}
