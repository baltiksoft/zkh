<?php

namespace App\classes;

use App\Models\Invoice;
use App\Models\MeterReading;
use App\Models\Tariff;

class BInvoiceService
{
    public function generateInvoice(MeterReading $reading): Invoice
    {
        dd($reading->meter->meter_id);
        // Ищем актуальный тариф для типа счетчика на момент подачи показаний
        $tariff = Tariff::where('meter_id', $reading->meter->meter_id)
            ->where('active_from', '<=', $reading->reported_at)
            ->orderBy('active_from', 'desc')
            ->first();

        if (!$tariff) {
            throw new \Exception("Активный тариф не найден.");
        }

        // Расчет суммы: расход  * стоимость тарифа
        $amount = $reading->consumption * $tariff->price;

        // Создаем счет для пользователя
        return Invoice::create([
            'lease_id' => $reading->meter->lease_id,
            'meterreading_id' => $reading->id,
            'amount' => $amount,
            'status' => 'unpaid',
            'due_date' => now()->addDays(20), // Срок оплаты 20 дней
        ]);
    }
}
