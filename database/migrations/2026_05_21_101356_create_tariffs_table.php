<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('tariffs', function (Blueprint $table) {
            $table->increments('id')->comment('Уникальный идентификатор тарифа');
            $table->foreignId('meter_id')
                ->comment('Код счётчика (для чего считается тариф)')
                ->constrained()
                ->references('id')->on('meters')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->decimal('price')->comment('Цена за единицу');
            $table->foreignId('unit_id')
                ->comment('Код единицы измерения')
                ->constrained()
                ->references('id')->on('units')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('active_from')->comment('С какой даты действует тариф');
            $table->timestamps();
            $table->comment('Тарифы');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tariffs');
    }
};
