<?php

namespace App\classes;

use App\Models\Invoice;
use App\Models\Lease;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class BPaymentService
{
    public function processPayment(Lease $lease, float $amount, ?string $transactionId = null): Payment
    {
        return DB::transaction(function () use ($lease, $amount, $transactionId) {
            // 1. Создаем запись о платеже
            $payment = Payment::create([
                'lease_id' => $lease->id,
                'amount' => $amount,
                'transaction_id' => $transactionId,
                'paid_at' => now(),
            ]);

            // 2. Выбираем все неоплаченные или частично оплаченные счета (от старых к новым)
            $unpaidInvoices = Invoice::where('lease_id', $lease->id)
                ->whereIn('status', ['unpaid', 'partially_paid'])
                ->orderBy('due_date', 'asc')
                ->get();

            $leftToDistribute = $amount; // Доступный остаток денег для распределения

            foreach ($unpaidInvoices as $invoice) {
                if ($leftToDistribute <= 0) {
                    break;
                }

                // Используем написанный нами ранее accessor 'amount_left'
                $amountNeeded = $invoice->amount_left;

                if ($leftToDistribute >= $amountNeeded) {
                    // Платеж полностью покрывает остаток этого счета
                    $payment->invoices()->attach($invoice->id, ['amount' => $amountNeeded]);

                    $invoice->update(['status' => 'paid']);
                    $leftToDistribute -= $amountNeeded;
                } else {
                    // Платеж покрывает счет лишь частично
                    $payment->invoices()->attach($invoice->id, ['amount' => $leftToDistribute]);

                    $invoice->update(['status' => 'partially_paid']);
                    $leftToDistribute = 0; // Все деньги распределены
                }
            }

            // 3. Если после закрытия всех долгов остались лишние деньги — зачисляем на баланс
            if ($leftToDistribute > 0) {
                $lease->increment('balance', $leftToDistribute);
            }

            return $payment;
        });
    }
}
