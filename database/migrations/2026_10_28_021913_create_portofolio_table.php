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
    Schema::create('portofolio', function (Blueprint $table) {
        $table->id();
        $table->string('judul');
        $table->text('deskripsi');
        $table->string('gambar')->nullable();      // path file gambar
        $table->string('link_demo')->nullable();   // URL demo/website
        $table->string('link_github')->nullable(); // URL repository
        $table->string('teknologi')->nullable();   // contoh: "Laravel, MySQL"
        $table->date('tanggal')->nullable();       // tanggal selesai proyek
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('portofolio');
}
};
