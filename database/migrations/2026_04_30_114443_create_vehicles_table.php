<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained('vehicle_categories')
                ->cascadeOnDelete();
            $table->foreignId('brand_id')
                ->constrained('vehicle_brands')
                ->cascadeOnDelete();
            $table->string('code', 50)->unique();
            $table->string('name', 150);
            $table->string('slug')->unique();
            $table->string('plate_number', 30)->unique();
            $table->decimal('fuel_tank_capacity', 5, 2)->nullable();
            $table->text('description')->nullable();
            $table->decimal('price_per_day', 12, 2);
            $table->boolean('is_featured')->default(false);
            $table->enum('operational_status', ['active', 'inactive', 'maintenance'])
                ->default('active');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
