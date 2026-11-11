<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('Portofolio_2555301154', function (Blueprint $table): void {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi');
            $table->string('teknologi');
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('Portofolio_2555301154');
    }
};
