<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_detail', function (Blueprint $table) {
            $table->id()->comment('Уникальный идентификатор записи');

            // Связь с таблицей users
            $table->foreignId('user_id')
                ->comment('Идентификатор пользователя из таблицы users')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');

            // ФИО и Дата рождения
            $table->string('family')->comment('Фамилия');
            $table->string('name')->comment('Имя');
            $table->string('surname')->nullable()->comment('Отчество (при наличии)');
            $table->date('birthdate')->comment('Дата рождения');

            // Паспортные данные
            $table->string('passport_series', 4)->comment('Серия паспорта (4 цифры)');
            $table->string('passport_number', 6)->comment('Номер паспорта (6 цифр)');
            $table->string('passport_issued')->comment('Кем выдан паспорт (наименование органа)');
            $table->date('passport_date')->comment('Дата выдачи паспорта');
            $table->string('passport_code', 7)->comment('Код подразделения (например, 770-001)');

            // Адрес регистрации
            $table->text('address')->comment('Полный адрес регистрации (прописка)');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_detail');
    }
};

