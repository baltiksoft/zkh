<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id()->comment('Уникальный идентификатор');
            $table->foreignId('userdetail_id')
                ->comment('Идентификатор владельца')
                ->nullable()
                ->constrained()
                ->references('id')->on('user_detail')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name')->comment('Наименование');
            $table->integer('area')->comment('Площадь');
            $table->text('address')->comment('Адрес');
            $table->string('number')->unique()->comment('Кадастровый номер')->nullable();
            $table->timestamps();
            $table->comment('Помещения');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
