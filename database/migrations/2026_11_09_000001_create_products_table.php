<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type')->default('sepatu');   // sepatu | accessory
            $table->string('brand')->nullable();          // Nike, Adidas, dst (khusus sepatu)
            $table->string('gender')->nullable();         // pria | wanita | anak (khusus sepatu)
            $table->string('group')->nullable();          // Pakaian, Kaos kaki, dst (khusus accessory)
            $table->unsignedInteger('price');
            $table->unsignedInteger('stock')->default(20);
            $table->string('color_1', 9)->default('#14213D');
            $table->string('color_2', 9)->nullable();
            $table->boolean('is_trending')->default(false);
            $table->timestamps();

            $table->index(['type', 'gender', 'brand']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
