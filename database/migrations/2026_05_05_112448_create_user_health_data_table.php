<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_health_data', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedTinyInteger('age');
            $table->decimal('weight', 5, 2);
            $table->decimal('height', 5, 2);
            $table->decimal('bmi', 4, 2)->nullable();
            $table->unsignedTinyInteger('systolic_min');
            $table->unsignedTinyInteger('systolic_max');
            $table->unsignedTinyInteger('diastolic_min');
            $table->unsignedTinyInteger('diastolic_max');
            $table->string('status');
            $table->text('result');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_health_data');
    }
};
