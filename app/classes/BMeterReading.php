<?php

namespace App\classes;

use App\Models\MeterReading;

class BMeterReading
{
    public static function saveMeters($data)
    {
        $reading = MeterReading::create($data);

        // Генерируем счет
        $invoiceService = app(BInvoiceService::class);
        $invoiceService->generateInvoice($reading);
    }
}
