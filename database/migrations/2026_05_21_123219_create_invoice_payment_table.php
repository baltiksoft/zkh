<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoice_payment', function (Blueprint $table) {
            $table->id()->comment('Уникальный идентификатор');
            $table->foreignId('invoice_id')->comment('Код счёта')->constrained()->onDelete('cascade');
            $table->foreignId('payment_id')->comment('Код платежа')->constrained()->onDelete('cascade');

            // Сколько именно денег из этого платежа ушло на этот счет
            $table->decimal('amount', 8, 2)->comment('Сколько именно денег из этого платежа ушло на этот счет');

            $table->timestamps();

            // Индекс для ускорения выборок
            $table->index(['invoice_id', 'payment_id']);
            $table->comment('Оплата счёта');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_payment');
    }
};
