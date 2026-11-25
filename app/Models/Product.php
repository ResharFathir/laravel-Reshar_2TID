<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // ----- dipakai toko /toko -----
    public const BRANDS = ['Nike', 'Adidas', 'Puma', 'Mills', 'Ortuseight', 'Asics'];
    public const GENDERS = ['pria' => 'Pria', 'wanita' => 'Wanita', 'anak' => 'Anak-anak'];

    protected $fillable = [
        // kolom milik BumaloController
        'name', 'slug', 'brand_id', 'category_id', 'description', 'price', 'image', 'is_active',
        // kolom milik toko /toko
        'brand', 'gender', 'type', 'group', 'stock', 'color_1', 'color_2', 'is_trending',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_trending' => 'boolean',
    ];

    // ----- relasi milik BumaloController -----
    public function brand() { return $this->belongsTo(Brand::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function variants() { return $this->hasMany(ProductVariant::class); }

    // ----- scope dan accessor milik toko /toko -----
    public function scopeShoes($q)       { return $q->where('type', 'sepatu'); }
    public function scopeAccessories($q) { return $q->where('type', 'accessory'); }

    // Nama tampil: tambahkan merek bila belum ada di nama.
    // Memakai $this->attributes supaya tidak bentrok dengan relasi brand().
    public function getFullNameAttribute(): string
    {
        $brand = $this->attributes['brand'] ?? null;

        if (! $brand || stripos($this->name, $brand) === 0) {
            return $this->name;
        }

        return $brand . ' ' . $this->name;
    }

    public function getPriceRpAttribute(): string
    {
        return 'Rp' . number_format((int) $this->price, 0, ',', '.');
    }
}