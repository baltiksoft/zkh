<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $payment = Payment::create([
            'lease_id' => 1,
            'amount' => 77700.0,
            'paid_at' => '2024-12-07',
            'comment' => 'Получено через Альфа-Банк',
        ]);

        $payment->invoices()->attach(1, ['amount' => 434.56]);
        $payment->invoices()->attach(2, ['amount' => 59.01]);
        $payment->invoices()->attach(3, ['amount' => 485.7]);
        $payment->invoices()->attach(4, ['amount' => 1805.37]);
    }
}
