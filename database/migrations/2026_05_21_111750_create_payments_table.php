<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('lease_id')
                ->comment('Код договора аренды')
                ->constrained()
                ->references('id')->on('leases')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->decimal('amount', 8, 2)->comment('Сумма платежа'); // Сумма платежа
            $table->string('transaction_id')->nullable(); // ID из платежной системы
            $table->timestamp('paid_at')->comment('Дата и время платежа');
            $table->string('comment')->nullable()->comment('Комментарий'); // ID из платежной системы
            $table->timestamps();
            $table->comment('Платежи пользователя по договору');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
