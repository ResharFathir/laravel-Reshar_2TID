# Bumalo.id — toko sepatu olahraga

Website Laravel untuk katalog sepatu olahraga, stok berdasarkan ukuran, keranjang, checkout, transfer manual, status pesanan, dan panel operasional.

## Menjalankan proyek

1. Pastikan PHP 8.3+ dan Composer tersedia.
2. Salin `.env.example` menjadi `.env`, lalu sesuaikan koneksi database.
3. Jalankan `composer install` bila dependensi belum tersedia.
4. Jalankan `php artisan key:generate` bila `APP_KEY` belum terisi.
5. Jalankan `php artisan migrate --seed`.
6. Jalankan `php artisan storage:link` agar foto produk bisa diakses.
7. Jalankan aplikasi dengan `php artisan serve` atau lingkungan Laragon.

## Akses demo

- Toko: `/`
- Daftar pelanggan: `/daftar`
- Masuk pelanggan/admin: `/masuk`
- Registrasi pemilik pertama (aktif hanya sebelum ada admin): `/admin/setup`
- Kelola akun tim/pelanggan: `/admin/akun`
- Kelola produk dan foto: `/admin/produk`
- Email: `admin@bumalo.id`
- Kata sandi demo: `password`

Ganti kata sandi demo sebelum aplikasi dipakai di lingkungan bersama atau produksi. Seeder menyediakan katalog contoh dan stok ukuran 39–44.

Admin/pemilik dapat membuat, mengubah, dan menghapus akun dari panel. Pelanggan mendaftar sebagai pelanggan dan tidak dapat memilih peran admin. Registrasi pemilik pertama dibatasi hanya saat belum ada admin/pemilik.

## Catatan yang perlu ditetapkan pemilik

- Rekening pembayaran pada halaman pesanan masih data simulasi (BCA 1234567890 a.n. Bumalo.id).
- Aturan batas waktu dan biaya tukar ukuran masih berupa panduan sementara; tetapkan kebijakan final sebelum menerima transaksi nyata.
- Ongkos kirim ditampilkan sebagai konfirmasi admin dan belum masuk perhitungan checkout otomatis.
- Data produk, stok, persona, dan pesanan awal merupakan data demo pembelajaran.

Bukti transfer disimpan pada disk lokal privat dan hanya dapat dibuka admin/pemilik. Detail pesanan pelanggan dikunci menggunakan kode pesanan dan nomor telepon checkout.
