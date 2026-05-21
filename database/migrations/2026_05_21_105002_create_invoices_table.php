<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lease_id')
                ->comment('Код договора аренды')
                ->constrained()
                ->references('id')->on('leases')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('meterreading_id')
                ->comment('Код показания счётчика')
                ->constrained()
                ->references('id')->on('meter_readings')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->decimal('amount', 8, 2)->default(0.00)->comment('Сумма к оплате'); // Сумма к оплате
            $table->enum('status', ['unpaid', 'partially_paid', 'paid'])->default('unpaid')->comment('Состояние оплаты');
            $table->date('due_date')->comment('Срок оплаты'); // Срок оплаты
            $table->timestamps();
            $table->comment('Счета на оплату');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
