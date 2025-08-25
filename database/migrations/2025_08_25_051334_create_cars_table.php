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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();

            $table->foreignId('brand_id')
                ->constrained('brands')
                ->cascadeOnUpdate()
                ->restrictOnDelete()
                ->index();

            $table->foreignId('car_model_id')
                ->constrained('car_models')
                ->cascadeOnUpdate()
                ->restrictOnDelete()
                ->index();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete()
                ->index();

            $table->year('year')->nullable()->index();
            $table->unsignedInteger('mileage')->nullable();
            $table->string('color', 50)->nullable()->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
