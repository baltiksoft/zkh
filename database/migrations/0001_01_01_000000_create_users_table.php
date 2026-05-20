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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->comment('Уникальный идентификатор');
            $table->string('name')->comment('Имя пользователя');
            $table->string('email')->unique()->comment('Почта пользователя');
            $table->boolean('root')->default(false)->comment('Признак Администратора');
            $table->boolean('active')->default(true)->comment('Признак действительного пользователя');
            $table->timestamp('email_verified_at')->nullable()->comment('Дата подтверждения e-mail');
            $table->string('password')->comment('Пароль пользователя');
            $table->rememberToken()->comment('Запомнить пользователя');
            $table->timestamps();
            $table->comment('Пользователи системы');

        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary()->comment('Почта пользователя');
            $table->string('token')->comment('Токен для сбросв');
            $table->timestamp('created_at')->nullable();
            $table->comment('Сброс пароля');
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary()->comment('Уникальный идентификатор');
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
            $table->comment('Сессия пользователя');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
