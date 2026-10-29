# Dokumentasi & Rencana Revisi Visual: Navbar & Hero Section (Scrapbook Theme)

Dokumen ini mencatat rincian penyempurnaan visual yang telah diimplementasikan pada **Navbar** dan **Hero Section** portofolio agar sesuai dengan **Mockup Desain Final (Gambar 2)**, serta panduan pengelolaan data dinamis dan rencana pengembangan tahap selanjutnya.

---

## 1. Ringkasan Pekerjaan yang Baru Selesai Dikerjakan

### A. Layout & Komposisi Hero
- **Perluasan Kontainer Desktop (1440px):** Mengubah kontainer Hero dari ukuran sempit (`1240px`) menjadi `max-width: 1440px` dengan padding responsif `clamp(1.25rem, 3.5vw, 3.5rem)`. Jarak ke tepi kiri dan kanan kini proporsional pada resolusi 1366px, 1440px, maupun 1920px.
- **Komposisi Dua Kolom Editorial:** Rasio grid dioptimalkan menjadi `1.2fr : 1fr`, memberikan ruang lega pada kolom teks sehingga nama `"M. Ikhsan Hidayat"` tidak terpotong ke 3 baris di desktop dan tidak bertabrakan dengan kolom foto.
- **Pencegahan Overflow:** Diterapkan `overflow-x: hidden` dan penskalaan adaptif sehingga tidak ada pergeseran horizontal pada tablet maupun mobile.

### B. Navbar & Scroll State
- **Warna Navbar Warm White:** Mengganti warna navbar menjadi `#FFFCF8` dengan garis batas bawah tipis `#E8E1D6`.
- **Hero Tetap Cream:** Background Hero dipertahankan pada `#F6F1E7` sehingga tercipta transisi halus antara navbar dan canvas hero.
- **Konsistensi Scroll (Anti-Revert):** Menambahkan aturan `!important` pada class `.portfolio-nav.is-scrolled` dan menu mobile agar saat halaman di-scroll ke bawah, navbar tetap konsisten berwarna `#FFFCF8` dan tidak berubah ke warna lama.
- **Active State Terracotta:** Mempertahankan warna terracotta (`#A64F39`) dan aksen coretan tangan titik-garis `● ────` pada link aktif.
- **Elemen Tambahan Mockup:** Ditambahkan tombol tema bulat (ikon matahari) dan tombol `Login Admin` berlatar hitam solid sesuai mockup.

### C. Komposisi Scrapbook & Keterbacaan Kartu Informasi
- **Pelegaan Area Scrapbook (530px):** Lebar panggung scrapbook diperluas menjadi `max-width: 530px`.
- **Reposisi Foto Polaroid:** Polaroid digeser sedikit ke kiri (`max-width: 310px; margin-left: 15px; transform: rotate(1.5deg)`) dengan washi tape kraft di atas dan sage green di sudut bawah.
- **Kartu Informasi Personal Tidak Lagi Tertutup:**
  - Posisi kartu disesuaikan ke `right: -10px; width: 220px; z-index: 6;` dengan `padding-left: 1.35rem`.
  - Tumpukan foto polaroid hanya menutupi batas kosong tipis di sebelah kiri kartu, sementara seluruh teks dan ikon (📍 Lokasi, 🎓 Studi, 💻 Profesi, 🤍 Minat) tampil utuh, bebas halangan, dan 100% terbaca.
- **Elemen Dekorasi Pendukung:**
  - Sticky note kraft bertuliskan *"Build, Learn, Improve, Repeat."* dengan washi tape dan coretan smiley face `:)`.
  - Kertas latar grid beraksen hijau lembut di belakang polaroid.
  - Aksen ranting daun botani hijau sage dengan kurva *flourish* di sebelah kiri.
  - Doodle bintang di kanan atas dan kutipan tangan *"Turning Ideas into Reality."* di kanan bawah.

### D. Tekstur Background Hero (Natural Paper Grain & Fine Stipple Dots)
- **Tekstur Serat Kertas Alami:** Diimplementasikan menggunakan SVG filter noise data URI (`feTurbulence baseFrequency="0.85"` dengan opasitas sangat lembut `0.042`). Memberikan sensasi kertas seni bertekstur tanpa noise kasar dan tanpa mengganggu keterbacaan teks.
- **Pola Titik Stippling Halus:** Dipadukan dengan titik mikroskopis radius `0.75px` berselang-seling (`10px` dan `20px`) untuk menciptakan efek stippling khas cetakan scrapbook fisik.
- **Performa Ringan:** Berukuran hanya ~300 bytes, tanpa dependensi eksternal, dan dirender langsung secara native via GPU browser.

### E. Dinamisme Identitas Profesi (CMS & Database Integration)
- **Bebas Hardcode:** Seluruh penyebutan profesi di Hero Section:
  1. *Headline Profesi* (di bawah nama lengkap)
  2. *Kartu Informasi Scrapbook* (ikon laptop 💻)
  3. *Sub-caption Polaroid* (di bawah nama foto)
  kini secara dinamis membaca data yang sama dari database (`$profile['headline']`).
- **Integritas Database:** Tidak ada pengubahan paksa pada database SQL atau controller. Semua data tetap bersumber dari CMS.

### F. Strip Informasi Bawah (Paper Strip)
- Kartu melayang putih dengan 4 metrik berbasis data riil tanpa klaim fiktif:
  1. **Proyek:** `4+` Proyek Pengembangan (dari hitungan `count($projects)`)
  2. **Database:** `3+` Pengalaman Database (dari hitungan keahlian database & backend)
  3. **Kompetensi:** `11+` Kompetensi & Tools (dari total keahlian riil di database)
  4. **Pendidikan:** `D3` Manajemen Informatika (dari data pendidikan)

---

## 2. File-File yang Telah Diperbarui

| Nama File | Lokasi | Ringkasan Modifikasi |
|---|---|---|
| `portfolio.css` | `public/assets/css/portfolio.css` | Penambahan tekstur natural paper grain & stippling dots, styling navbar `#FFFCF8`, border `#E8E1D6`, layout Hero 1440px, reposisi polaroid & kartu info scrapbook, responsivitas. |
| `home.php` | `resources/views/public/home.php` | Sinkronisasi profesi dinamis `$heroProfession`, greeting scrapbook dengan pin & underline SVG, polaroid caption dinamis, kartu info dinamis, strip kertas data aktual. |
| `header.php` | `resources/views/layouts/header.php` | Font Google `Caveat`, perluasan navbar ke `1440px`, styling navigasi desktop, tombol theme toggle, tombol login admin rounded hitam, cache busting `portfolio.css?v=4`. |

---

## 3. Panduan Pengguna: Mengubah Profesi Menjadi "Fullstack Developer"

Untuk mengubah identitas profesi di Hero Section tanpa menyentuh kode program:

1. Buka browser dan login ke **Dashboard Admin**:
   ```
   http://localhost:8000/admin/login
   ```
2. Pilih menu **Profil** di sidebar atau kunjungi langsung:
   ```
   http://localhost:8000/admin/profile
   ```
3. Pada input formulir **"Headline Profil"** (`headline`), masukkan:
   ```text
   Fullstack Developer
   ```
4. Klik tombol **Simpan Perubahan**.
5. Buka kembali halaman depan (`/`). Headline, teks pada kartu scrapbook, dan caption polaroid akan otomatis terbarui menjadi **Fullstack Developer**.

---

## 4. Rencana Kerja Tahap Selanjutnya (Roadmap Pengembangan)

Setelah Navbar dan Hero Section selesai disempurnakan mendekati mockup, berikut rencana untuk tahapan berikutnya:

### Tahap 2 — Section "Tentang Saya" (About Section)
- [ ] Menyelaraskan tema scrapbook pada section Tentang Saya (elemen catatan kertas, pita selotip/tape, dan kutipan editorial).
- [ ] Menata ulang grid dua kolom: narasi profil di kiri dan kartu fakta personal di kanan.
- [ ] Menambahkan aksen coretan tangan (*doodle underline* & *handwritten notes*).

### Tahap 3 — Section "Keahlian & Kompetensi" (Skills Section)
- [ ] Mengubah card keahlian standar menjadi gaya *sticky notes / sample swatches* bertema scrapbook.
- [ ] Mengelompokkan keahlian (Backend, Database, Frontend, Tools) dengan aksen warna earthy pastel (sage green, warm terracotta, kraft tan, slate).
- [ ] Memastikan icon dan tingkat penguasaan tersaji rapi dan dinamis dari CMS.

### Tahap 4 — Section "Riwayat Studi & Pengalaman" (Education & Timeline)
- [ ] Mendesain timeline bergaya jurnal/buku catatan (*notebook spine / perforated paper*).
- [ ] Memastikan kartu pendidikan Politeknik LP3I dan logo tampil proporsional.
- [ ] Penanganan dinamis jika data pengalaman kerja/magang masih kosong (tetap elegan tanpa ruang kosong berlebih).

### Tahap 5 — Section "Proyek Portofolio" (Projects Section)
- [ ] Mendesain kartu proyek dengan bingkai polaroid/katalog portofolio.
- [ ] Mempertahankan filter AJAX kategori & teknologi.
- [ ] Menyempurnakan lightbox galeri multimedia (GLightbox) dan modal deskripsi proyek.

### Tahap 6 — Section "Kontak" & Footer
- [ ] Mendesain formulir kontak dengan gaya amplop surat / formulir memo klasik.
- [ ] Footer beraksen *torn craft paper edge* yang menyatu dengan tema keseluruhan halaman.

