# Catatan Revisi Visual

## Tahap 3 — Penyempurnaan Minor Skills & Tech Stack

### Scope

Penyempurnaan hanya pada section Keahlian & Kompetensi (`#keahlian`). Konsep Minimalist Editorial Scrapbook dan komposisi desktop 3+2 dipertahankan. Tidak melanjutkan ke section Studi.

### File yang diubah

- `public/assets/css/portfolio.css`
- `resources/views/public/home.php` tidak diubah pada revisi minor ini.

### Perbaikan

- Ukuran judul kategori: `1.4rem` menjadi `1.5rem`.
- Ukuran deskripsi kategori: `0.78rem` menjadi `0.85rem`.
- Ukuran nama skill: `0.825rem` menjadi `0.9rem`.
- Ukuran teks badge: `0.7rem` menjadi `0.75rem`.
- Line-height deskripsi dan label skill serta padding label/badge diperbesar untuk keterbacaan.
- Scroll margin section Skills: `6rem` menjadi `7rem` agar heading memiliki jarak tambahan dari navbar. Perilaku smooth scrolling tidak diubah.

### Keputusan yang dipertahankan

- Container responsif maksimal `1200px` dengan gutter `clamp(1.25rem, 4vw, 3rem)`, sesuai About. Pelebaran 10–15% tidak diterapkan karena akan melewati batas container About. Hero menggunakan batas `1440px` dengan gutter berbeda.
- Tinggi kartu tetap mengikuti konten, bukan dipaksa sama.
- Layout 3+2, urutan kategori, pengelompokan skill, empty state, dan badge level tetap dipertahankan.
- Warna, tekstur kertas, washi tape, paperclip, dan dekorasi scrapbook tidak diubah.
- Ikon kategori tetap menjadi fallback; tidak ditemukan aset logo teknologi lokal yang sesuai. Tidak menambahkan dependency atau logo yang berpotensi keliru.

### Hasil pengujian yang dijalankan

- PHP syntax check: lulus.
- `git diff --check`: lulus.
- Pengujian rendering terisolasi untuk 1, 2, 3, 5, dan 7 kategori serta jumlah item berbeda: lulus.
- Pemeriksaan urutan, escaping label panjang, empty state, level kosong/tidak dikenal, dan variasi badge: lulus.
- Perbandingan snapshot memastikan seluruh template homepage dan CSS di luar Skills identik dengan kondisi sebelum revisi minor.

### Belum diverifikasi

- Tampilan browser pada lebar 375px, 390px, 768px, 1366px, dan 1920px.
- Tampilan desktop pada zoom 100%.
- Pengukuran horizontal overflow dan posisi anchor secara langsung di browser.
- Regresi visual halaman penuh pada Hero dan About. Yang sudah diverifikasi adalah tidak adanya perubahan kode di luar scope, bukan kesamaan hasil rendering browser.

Pengujian browser belum berhasil dilakukan; probe versi Firefox tidak memberikan output dan Playwright/Puppeteer tidak tersedia. Tidak ditemukan script lint/typecheck proyek yang terkonfigurasi.

### Batasan yang dijaga

Tidak ada perubahan controller, database, routing, dashboard admin, Hero, About, atau section lainnya. Tidak ada instalasi dependency, perubahan build system, commit, atau push.

### Tindak lanjut

Review visual di browser diperlukan untuk memvalidasi keterbacaan, responsivitas, overflow, dan offset anchor. Pekerjaan section Studi menunggu persetujuan.

## Revisi Konten & Metadata — 30 Oktober 2026

### Scope dan status

Perbaikan literal nama, metadata fallback, dan data awal CLI. Data dinamis tetap dibaca dari database; database aktif tidak diperiksa atau diubah. Tidak ada perubahan desain, layout, warna, struktur kode, library, `STACK_TOTAL`, atau batas jumlah tag kartu proyek.

### File dan perubahan yang diterapkan

| File dan baris | Sebelum | Sesudah |
| --- | --- | --- |
| `app/Controllers/HomeController.php:90` | Fallback title `Portofolio M. Ikhsanul Karim` | `Muhamad Ikhsan Hidayat \| Fullstack Developer Portfolio` |
| `resources/views/layouts/header.php:7` | Fallback title `M. Ikhsan Hidayat — Fullstack Developer` | Title baru sesuai teks di bawah |
| `resources/views/layouts/header.php:8` | Fallback deskripsi singkat dengan nama `M. Ikhsan Hidayat` | Meta description baru sesuai teks di bawah |
| `bin/console.php:126` | Nama seed `M. Ikhsanul Karim` | `Muhamad Ikhsan Hidayat` |
| `bin/console.php:128` | Target peran seed `Backend Developer Intern` | `Fullstack Developer` |
| `bin/console.php:359–360` | Tahun pendidikan seed `2023`, `2026` | `2024`, `2027` |
| `bin/console.php:371–374` | Nama, title, deskripsi, dan footer seed memuat nama lama | Nama diperbaiki; title dan deskripsi mengikuti teks baru |

Title baru:

```text
Muhamad Ikhsan Hidayat | Fullstack Developer Portfolio
```

Meta description baru:

```text
Portofolio Muhamad Ikhsan Hidayat, Fullstack Developer lulusan D3 Manajemen Informatika yang berpengalaman membangun aplikasi web dengan Laravel, PHP, dan MySQL.
```

Fallback tidak menimpa nilai Settings yang sudah tersimpan. Tidak ditemukan tag eksplisit Open Graph atau Twitter pada sumber aplikasi yang diperiksa; tidak ada tag baru ditambahkan. Kemunculan nama lama dalam dump SQL sengaja tidak diubah. Tahun contoh pengalaman kerja pada prototipe HTML juga tidak diubah karena bukan data kuliah.

### Perubahan manual melalui admin yang masih diperlukan

1. **Pengaturan Website:** pada tabel `settings`, perbarui `value` untuk `key = meta_title` dan `key = meta_description` menggunakan teks di atas. Snapshot title lama adalah `M.  |Ikhasan Hidayat Backend Developer Intern Portfolio`; deskripsi lama masih menyebut `M. Ikhsanul Karim`.
2. **Pendidikan:** edit record kuliah terkait pada tabel `educations`: `start_year` dari `2023` menjadi `2024`, dan `end_year` dari `NULL` menjadi `2027`. Tahun kosong sebelumnya ditampilkan sebagai `SEKARANG` oleh `resources/views/public/home.php:416`. Tambahkan keterangan sedang berjalan, semester 5, perkiraan selesai 2027 melalui kolom deskripsi bila sesuai.
3. Kata **lulusan** pada meta description mengikuti permintaan, tetapi perlu dikonfirmasi karena status pendidikan juga disebut masih berjalan.
4. Jangan menjalankan seeder atau `schema.sql` untuk menerapkan koreksi ini. Seeder memuat `TRUNCATE`; skema bootstrap memuat `DROP TABLE`.

### Tag teknologi proyek: hasil penelusuran

Master berada pada `technologies` (`id`, `name`, `icon`, `is_active`). Relasi berada pada `project_technologies` (`project_id`, `technology_id`) dengan primary key gabungan dan foreign key ke `projects` serta `technologies`. Definisi: `database/migrations/schema.sql:108–121`.

Query dinamis berada pada `app/Controllers/HomeController.php:69–76` dan `:137–144`. Kartu tetap menampilkan maksimal tiga tag melalui `resources/views/public/home.php:572–578`; detail menampilkan seluruh tag aktif melalui `resources/views/public/project_detail.php:268–275`.

Perbandingan berikut berasal dari **dump repository, bukan database live**:

| Proyek | Tag pada snapshot | Tag yang kurang | Tag berlebih |
| --- | --- | --- | --- |
| E-Cashier Pasar | MySQL, JavaScript, Git, Bootstrap, Goravel | HTML, CSS, Tailwind CSS | Bootstrap |
| Keuangan BUMDes | PHP Native, MySQL, Tailwind CSS, JavaScript, Git | Tidak ada | Git |
| Profil Wisata | MySQL, Tailwind CSS, JavaScript, Laravel, Git | Tidak ada | Laravel, Git |
| Inventory Gudang | MySQL, Tailwind CSS, JavaScript, Laravel, Git | Google Gemini API | Git |

Sumber snapshot: `database/migrations/if0_42753817_porto_ikhsan.sql:211–214`, `:293–313`, dan `:393–401`.

Langkah manual:

- Periksa `/admin/technologies`; tambahkan HTML, CSS, dan Google Gemini API hanya jika belum tersedia, lalu aktifkan. Goravel sudah tersedia dalam snapshot.
- Edit proyek dan pilih seluruh tag target, bukan hanya tambahan. Penyimpanan menyinkronkan seluruh checkbox yang dipilih.
- E-Cashier: Goravel, MySQL, HTML, CSS, Tailwind CSS, JavaScript, Git.
- BUMDes: PHP Native, MySQL, Tailwind CSS, JavaScript.
- Wisata: MySQL, Tailwind CSS, JavaScript.
- Inventory: Laravel, MySQL, Tailwind CSS, JavaScript, Google Gemini API.
- Hilangkan centang relasi berlebih; jangan hapus master teknologi yang dipakai proyek lain.
- Urutan tag belum dijamin query; urutan tiga tag kartu mungkin berbeda dari daftar target.
- Tinjau deskripsi proyek: snapshot BUMDes masih menyebut Laravel/Eloquent, dan Wisata menyebut Bootstrap. Deskripsi tersebut belum diubah.

### Label proyek: usulan, belum diterapkan

Label kartu memotong slug menjadi 14 karakter sebelum menambahkan `.EXE` di `resources/views/public/home.php:506–507`, sehingga beberapa label sama. Detail memiliki pemotongan terpisah di `resources/views/public/project_detail.php:25`.

Usulan: potongan slug lebih pendek ditambah ID proyek sebelum `.EXE`, atau aturan singkatan seperti `BUMDES.EXE` dan `INVENTORY.EXE`. Tidak ada perubahan label atau slug pada revisi ini.

### Keamanan artefak: rekomendasi, belum diterapkan

Git melacak `core.zip`, `public/public.zip`, dump `database/migrations/if0_42753817_porto_ikhsan.sql`, arsip dump `.sql.zip`, dan `schema.sql`. Status deployment belum diverifikasi; `deploy.yml` tidak diperiksa. `public/public.zip` berpotensi terlayani publik jika ikut deployment dan server mengizinkannya.

Usulan tambahan `.gitignore`:

```gitignore
/core.zip
/public/public.zip
*.sql.zip
/database/migrations/if0_42753817_porto_ikhsan.sql
```

Aturan ignore tidak menghapus tracking atau riwayat file yang sudah tercatat. Skema/migration yang memang diperlukan tetap versioned. Tidak ada penghapusan file, perubahan `.gitignore`, atau perubahan deployment.

### Verifikasi dan batasan

- Pemeriksaan sintaks ketiga file PHP yang diubah: lulus.
- `git diff --check` untuk perubahan konten: lulus.
- Tidak ada verifikasi browser atau pembacaan database aktif pada pekerjaan ini.
- Tidak mengubah `.env`, `deploy.yml`, folder uploads, atau file SQL; tidak menjalankan query database, seeder, migration, commit, atau push.

### Checklist manual browser

- [ ] Simpan Meta Title dan Meta Description baru melalui admin.
- [ ] Title tab beranda sesuai title baru.
- [ ] View Source menampilkan meta description baru tanpa nama lama.
- [ ] Riwayat Studi menampilkan `2024 — 2027` dan status berjalan yang sesuai.
- [ ] Kartu proyek tetap menampilkan maksimal tiga tag.
- [ ] Detail E-Cashier menampilkan tujuh tag target.
- [ ] Detail BUMDes menampilkan empat tag target.
- [ ] Detail Wisata menampilkan tiga tag target.
- [ ] Detail Inventory menampilkan lima tag target.
- [ ] Desain dan teks `STACK_TOTAL` tetap tidak berubah.
