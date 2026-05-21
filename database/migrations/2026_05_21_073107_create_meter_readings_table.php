<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('meter_readings', function (Blueprint $table) {
            $table->increments('id')->comment('Уникальный код показания');
            $table->foreignId('lease_id')
                ->comment('Код договора аренды')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('meter_id')
                ->comment('Код счётчика')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedInteger('value')->comment('Текущее показание'); // Текущее значение
            $table->unsignedInteger('consumption')->nullable()->comment('Разница с предыдущим показанием. Если null - начальное показание.'); // Разница с прошлым месяцем
            $table->date('reported_at')->comment('Дата подачи показания'); // Дата подачи (фиксируем месяц/год)
            $table->boolean('is_estimated')->default(false)->comment('Расчёт по среднему, если пользователь не дал вовремя показания');
            $table->timestamps();
            $table->comment('Показания счётчиков');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meter_readings');
    }
};
