<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::updateOrCreate(['email' => 'admin@bumalo.id'], [
            'name' => 'Admin Bumalo', 'password' => 'password', 'role' => 'admin',
        ]);

        $brands = collect(['Stride', 'Aero', 'Courtline'])->mapWithKeys(fn ($name) => [$name => Brand::firstOrCreate(['name' => $name])]);
        $categories = collect(['Lari', 'Futsal', 'Basket', 'Badminton', 'Training'])->mapWithKeys(fn ($name) => [$name => Category::firstOrCreate(['name' => $name])]);
        $items = [
            ['Stride Tempo Run', 'stride-tempo-run', 'Lari', 'Stride', 749000, 'Sepatu lari ringan dengan bantalan responsif untuk latihan harian.'],
            ['Aero Cloud Runner', 'aero-cloud-runner', 'Lari', 'Aero', 899000, 'Transisi langkah halus dan upper bernapas untuk jarak menengah.'],
            ['Courtline Pivot Pro', 'courtline-pivot-pro', 'Basket', 'Courtline', 1129000, 'Dukungan lateral stabil untuk gerak cepat di lapangan basket.'],
            ['Stride Futsal Flex', 'stride-futsal-flex', 'Futsal', 'Stride', 629000, 'Outsole indoor mencengkeram dengan fit nyaman dan fleksibel.'],
            ['Aero Shuttle Lite', 'aero-shuttle-lite', 'Badminton', 'Aero', 579000, 'Sepatu court ringan untuk langkah gesit dan perubahan arah.'],
            ['Courtline Daily Trainer', 'courtline-daily-trainer', 'Training', 'Courtline', 699000, 'Sepatu serbaguna untuk gym dan aktivitas sehari-hari.'],
        ];
        foreach ($items as [$name, $slug, $category, $brand, $price, $description]) {
            $product = Product::firstOrCreate(['slug' => $slug], ['name' => $name, 'brand_id' => $brands[$brand]->id, 'category_id' => $categories[$category]->id, 'price' => $price, 'description' => $description, 'is_active' => true]);
            foreach (range(39, 44) as $size) $product->variants()->firstOrCreate(['size' => (string) $size], ['sku' => strtoupper($brand.'-'.$size.'-'.substr($slug, 0, 8)), 'stock' => random_int(0, 12)]);
        }
    }
}
