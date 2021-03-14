# Task Monitoring (TAMO)
Aplikasi berbasis web yang berfungsi untuk memonitoring tugas. Aplikasi ini dibuat dengan maksud untuk memenuhi kebutuhan kantor pusat dalam memantau tugas yang diberikan kepada kantor cabang.

*Aplikasi ini dibangun dengan [CodeIgniter 4](https://codeigniter.com/) dan [SB Admin 2](https://startbootstrap.com/theme/sb-admin-2/)*

---

## Requirements
* PHP Versi 7.3+

*Persyaratan lengkap lihat di [CodeIgniter 4](https://codeigniter.com/user_guide/intro/requirements.html)*

## Setup
Copy file `env` menjadi `.env`. Kemudian atur :

* `CI_ENVIRONMENT` = `development` atau `production`
* `database.default.hostname` = (hostname database)
* `database.default.database` =  (nama tabel)
* `database.default.username` = (username database)
* `database.default.password` = (password database)

**) jangan lupa untuk menonaktifkan komentar dengan menghapus tanda # pada baris yang ingin di atur.*

## Running
Untuk menjalankan local server milik [CodeIgniter 4](https://codeigniter.com/user_guide/installation/running.html) buka `cmd` pada folder **source**, lalu jalankan perintah :

```sh
php spark serve
```

Hasil akhirnya akan seperti ini :

![starting server result](/img/starting-server-result.png)

buka link (dalam kotak merah) tersebut pada web browser.

Untuk penggunaan pertama kali, jalankan perintah (database migration) berikut untuk membuat tabel-tabel yang dibutuhkan :

```sh
php spark migrate
```

Jika membutuhkan data-data sementara untuk proses development, jalankan perintah berikut :

```sh
php spark db:seed SimpleSeeder
```

Berikut data user yang akan dibuat :

|Email |Password |
|------|---------|
|shafygunawan@gmail.com |admin123 |
|admin@gmail.com |admin123 |

dan ada beberapa data kantor dan tugas.

**) untuk penjelasan tentang penggunaan lebih lanjut kunjungi dokumentasi [CodeIgniter 4](https://codeigniter.com/user_guide/index.html).*

## Contributing
Pull requests diterima! Anda dapat menambahkan sesuatu yang ingin ditambahkan.

## License
Copyright 2021 Shafy Gunawan

Dilisensikan di bawah Lisensi [Apache-2.0](https://www.apache.org/licenses/LICENSE-2.0). Anda tidak boleh menggunakan aplikasi ini kecuali sesuai dengan ketentuan Lisensi, hukum yang berlaku, atau disetujui secara tertulis.

Perangkat lunak yang didistribusikan di bawah Lisensi didistribusikan pada DASAR "SEBAGAIMANA ADANYA", TANPA JAMINAN ATAU KETENTUAN APA PUN, baik tersurat maupun tersirat. Lihat Lisensi untuk bahasa tertentu yang mengatur izin dan batasan di bawah Lisensi.

---

Jika terdapat masalah (bug) pada aplikasi ini Anda dapat melaporkannya, agar pengelola aplikasi dapat segera memperbaikinya.

Terima Kasih:)