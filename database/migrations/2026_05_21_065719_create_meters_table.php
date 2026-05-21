<?php

use App\Models\MeterType;
use App\Models\Room;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('meters', function (Blueprint $table) {
            $table->increments('id')->comment('Уникальный код счётчика');
            $table->foreignId('room_id')
                ->comment('Код арендуемого помещения')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('metertype_id')
                ->comment('Код типа счётчика')
                ->references('id')->on('meter_types')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name')->comment('Наименование счётчика');
            $table->string('marka')->nullable()->comment('Марка счётчика');
            $table->string('number')->comment('Номер счётчика');
            $table->boolean('active')->default(true)->comment('Признак действующего счётчика');
            $table->date('verification')->nullable()->comment('Дата следующей поверки');
            $table->timestamps();
            $table->comment('Счётчики в помещении');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('meters');
    }
};
