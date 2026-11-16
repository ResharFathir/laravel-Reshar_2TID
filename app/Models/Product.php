<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'brand', 'gender', 'type', 'group', 'price', 'stock', 'color_1', 'color_2', 'is_trending'];

    protected $casts = ['is_trending' => 'boolean'];

    public const BRANDS = ['Nike', 'Adidas', 'Puma', 'Mills', 'Ortuseight', 'Asics'];
    public const GENDERS = ['pria' => 'Pria', 'wanita' => 'Wanita', 'anak' => 'Anak-anak'];

    public function scopeShoes($q)       { return $q->where('type', 'sepatu'); }
    public function scopeAccessories($q) { return $q->where('type', 'accessory'); }

    // Nama tampil: tambahkan merek bila belum ada di nama
    public function getFullNameAttribute(): string
    {
        if (!$this->brand || stripos($this->name, $this->brand) === 0) {
            return $this->name;
        }
        return $this->brand . ' ' . $this->name;
    }

    public function getPriceRpAttribute(): string
    {
        return 'Rp' . number_format($this->price, 0, ',', '.');
    }
}
