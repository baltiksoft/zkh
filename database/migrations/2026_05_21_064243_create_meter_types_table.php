<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('meter_types', function (Blueprint $table) {
            $table->increments('id')->comment('Уникальный код типа счётчика');
            $table->string('name')->comment('Наименование типа счётчика');
            $table->comment('Типы счётчиков');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meter_types');
    }
};
