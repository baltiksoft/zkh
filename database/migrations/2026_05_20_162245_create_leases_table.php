<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('leases', function (Blueprint $table) {
            $table->id()->comment('Уникальный идентификатор договора аренды');

            // Связь с помещением
            $table->foreignId('room_id')
                ->comment('Код арендуемого помещения')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('userdetail_id')
                ->comment('Код арендатора')
                ->constrained('user_detail') // Явно указываем целевую таблицу
                ->onDelete('cascade');

            // Временные рамки
            $table->date('start_date')->comment('Дата начала аренды');
            $table->date('end_date')->comment('Дата окончания аренды (планируемая)');
            $table->decimal('balance', 8, 2)->default(0.00)->comment('Баланс средств');

            // Условия договора
            $table->boolean('is_renewable')->default(false)->comment('Признак автоматической пролонгации договора');
            $table->unsignedTinyInteger('payment_day')->comment('Число месяца, до которого должна быть оплата (1-31)');
            $table->integer('price')->default(0)->comment('Сумма ежемесячной оплаты в валюте');

            $table->timestamps();
            $table->comment('Договора аренды');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('leases');
    }
};
