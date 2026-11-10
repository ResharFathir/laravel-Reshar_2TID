# Bumalo.id – file Laravel

Salin isi folder ini ke root project Laravel (struktur folder sama persis), lalu:

1. Tambahkan isi `routes/web.php.snippet.php` ke `routes/web.php`.
2. Di `database/seeders/DatabaseSeeder.php` tambahkan `$this->call(ProductSeeder::class);`
3. Jalankan: `php artisan migrate --seed`
4. Buka `/` untuk toko, `/admin` untuk panel admin (perlu login).

Catatan: layout toko memakai `public/css/bumalo.css` dan `public/js/bumalo.js`.
Layout admin (`layouts/admin.blade.php`) dibuat terpisah agar tidak bentrok dengan `layouts/app.blade.php` milikmu yang sudah ada.
Jika project kamu sudah punya `layouts/app.blade.php`, ganti nama file toko ini, mis. `shop.blade.php`, lalu ubah `@extends` di view toko.
