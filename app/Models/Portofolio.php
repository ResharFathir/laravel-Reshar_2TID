<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Portofolio extends Model
{
    // Nama tabel (tunggal, jadi harus ditulis manual)
    protected $table = 'portofolio';

    // Kolom yang boleh diisi lewat create() dan update()
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'link_demo',
        'link_github',
        'teknologi',
        'tanggal',
    ];

    // Ubah kolom tanggal menjadi objek Carbon otomatis
    protected $casts = [
        'tanggal' => 'date',
    ];
}