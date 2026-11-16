<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // [nama, merek, gender, harga, warna 1, warna 2, trending]
        $shoes = [
            ['Air Pace 270', 'Nike', 'pria', 1649000, '#14213D', '#D9F24B', 1],
            ['Court Runner', 'Nike', 'wanita', 1399000, '#E8506A', '#FFFFFF', 0],
            ['Flex Kid 3', 'Nike', 'anak', 649000, '#2F5BFF', '#D9F24B', 0],
            ['Samba Street', 'Adidas', 'pria', 1599000, '#F4F1E8', '#1B1B1B', 1],
            ['Ultra Glide', 'Adidas', 'wanita', 1799000, '#9B7BFF', '#FFFFFF', 1],
            ['Gazelle Mini', 'Adidas', 'anak', 699000, '#1F8F6B', '#FFFFFF', 0],
            ['Suede Classic', 'Puma', 'pria', 1299000, '#C7312B', '#FFFFFF', 0],
            ['Cali Bloom', 'Puma', 'wanita', 1449000, '#F5C6D6', '#FFFFFF', 1],
            ['Smash Junior', 'Puma', 'anak', 599000, '#14213D', '#FFFFFF', 0],
            ['Mills Rafale', 'Mills', 'pria', 549000, '#222222', '#D9F24B', 0],
            ['Mills Aira', 'Mills', 'wanita', 499000, '#F08A5D', '#FFFFFF', 0],
            ['Mills Tiny', 'Mills', 'anak', 299000, '#FFC145', '#14213D', 0],
            ['Ortuseight Jogosala', 'Ortuseight', 'pria', 429000, '#2F5BFF', '#FFFFFF', 1],
            ['Ortuseight Lyra', 'Ortuseight', 'wanita', 449000, '#6ED3C2', '#14213D', 0],
            ['Ortuseight Bolt', 'Ortuseight', 'anak', 289000, '#FF7A3D', '#FFFFFF', 0],
            ['Gel-Kayano Lite', 'Asics', 'pria', 1899000, '#C9D1DB', '#3C4A6B', 1],
            ['Gel-Nimbus Air', 'Asics', 'wanita', 1999000, '#D9F24B', '#14213D', 0],
            ['Contend Kids', 'Asics', 'anak', 749000, '#E8506A', '#14213D', 0],
        ];

        foreach ($shoes as [$name, $brand, $gender, $price, $c1, $c2, $trend]) {
            Product::updateOrCreate(['name' => $name], [
                'type' => 'sepatu', 'brand' => $brand, 'gender' => $gender, 'price' => $price,
                'color_1' => $c1, 'color_2' => $c2, 'is_trending' => (bool) $trend,
            ]);
        }

        // [nama, grup, harga, warna]
        $acc = [
            ['Kaos Basic Bumalo', 'Pakaian', 129000, '#2F5BFF'],
            ['Hoodie Street', 'Pakaian', 349000, '#14213D'],
            ['Kaos Kaki Crew 3 Pasang', 'Kaos kaki', 59000, '#D9F24B'],
            ['Kaos Kaki Ankle Sport', 'Kaos kaki', 45000, '#E8506A'],
            ['Tali Sepatu Flat', 'Perawatan', 29000, '#9B7BFF'],
            ['Shoe Cleaner Kit', 'Perawatan', 89000, '#6ED3C2'],
            ['Topi Dad Hat', 'Aksesori', 99000, '#FFC145'],
            ['Tas Selempang Mini', 'Aksesori', 179000, '#1F8F6B'],
        ];

        foreach ($acc as [$name, $group, $price, $c1]) {
            Product::updateOrCreate(['name' => $name], [
                'type' => 'accessory', 'group' => $group, 'price' => $price, 'color_1' => $c1,
            ]);
        }
    }
}
