<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->increments('id')->comment('Уникальный идентификатор единиц измерения');
            $table->string('name')->unique()->comment('Наименование единицы измерения');
            $table->string('shortname')->comment('Сокращённое наименование единицы измерения');
            $table->comment('Единицы измерения');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
