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
