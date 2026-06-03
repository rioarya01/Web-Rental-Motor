# Daftar Perubahan Sistem

## User

1. Pada halaman **Daftar Pesanan**, di dalam **modal Detail Pesanan**, tambahkan tombol atau link **Chat WhatsApp Admin** yang ditampilkan tepat di bawah tombol **Bukti Pembayaran**.
2. Fitur chat WhatsApp hanya ditampilkan ketika status pesanan telah berubah menjadi **Paid**, sehingga pelanggan dapat langsung menghubungi admin terkait pesanan yang telah berhasil dibayar.

## Admin

### Dashboard

1. Tambahkan kartu statistik yang menampilkan:
    - Total pesanan dengan status **Pending**.
    - Total pesanan dengan status **Paid**.

2. Tambahkan fitur filter periode pendapatan pada tampilan **Total Pendapatan** dengan pilihan:
    - Harian
    - Bulanan
    - Tahunan

    Nominal pendapatan yang ditampilkan harus berubah secara dinamis sesuai periode filter yang dipilih.

### Data Konfirmasi Booking

1. Pada halaman **Data Konfirmasi Booking**, di dalam **modal Bukti Pembayaran**, tambahkan tombol atau link **Chat WhatsApp Customer**.
2. Tombol chat hanya ditampilkan untuk pesanan dengan status **Paid**.
3. Fitur ini digunakan agar admin dapat langsung mengirimkan pesan kepada customer bahwa pembayaran telah diverifikasi dan pesanan telah dikonfirmasi.

### Pengaturan Diskon dan Pembayaran

1. Tambahkan tabel database **Rekening Pembayaran** untuk menyimpan informasi rekening tujuan pembayaran.
2. Buat fitur **CRUD (Create, Read, Update, Delete)** untuk data rekening pembayaran.
3. Data rekening yang dikelola minimal mencakup:
    - Nama Bank
    - Nomor Rekening
    - Nama Pemilik Rekening
    - Status Aktif/Tidak Aktif

### Pengaturan Diskon

1. Pada modal **Tambah Diskon Baru**, tambahkan field **Target Diskon** berupa dropdown/select dengan pilihan:
    - Kendaraan
    - Brand Kendaraan
    - Tipe Kendaraan

2. Setelah admin memilih salah satu target diskon, tampilkan dropdown/select lanjutan yang menyesuaikan pilihan target:
    - Jika memilih **Kendaraan**, tampilkan daftar seluruh kendaraan.
    - Jika memilih **Brand Kendaraan**, tampilkan daftar seluruh brand kendaraan.
    - Jika memilih **Tipe Kendaraan**, tampilkan daftar seluruh tipe kendaraan.

3. Diskon yang dibuat hanya berlaku untuk target yang dipilih oleh admin.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
