# Rundown Pengembangan Portofolio Mahasiswa Manajemen Informatika

File ini digunakan untuk melacak kemajuan pengerjaan aplikasi portofolio pribadi Anda. Perkembangan akan diperbarui secara berkala setelah setiap fase selesai dikerjakan agar Anda dapat langsung meninjau dan mengujinya.

## Ringkasan Progres
- **Fase 1 — Fondasi & Kerangka MVC**: `[x]` Selesai
- **Fase 2 — Skema Database, Migrasi, & Seeder CLI**: `[x]` Selesai
- **Fase 3 — Sistem Autentikasi Admin & Layout Dashboard**: `[x]` Selesai
- **Fase 4 — CMS CRUD Profil, Keahlian, Pendidikan, & CV**: `[x]` Selesai
- **Fase 5 — CMS CRUD Proyek, Teknologi, & Galeri Dokumentasi**: `[x]` Selesai
- **Fase 6 — CMS Kotak Pesan Masuk (Inbox)**: `[x]` Selesai
- **Fase 7 — Halaman Publik (Frontend)**: `[x]` Selesai
- **Fase 8 — Optimasi SEO, Aksesibilitas, & Final Polishing**: `[x]` Selesai

---

## Rincian Checklist Pengujian per Fase

### 1. Fase 1 — Fondasi & Kerangka MVC `[x]`
- [x] Inisialisasi Composer (`composer.json`) & PSR-4 Autoloading
- [x] Konfigurasi `.env` & Loader environment variabel
- [x] Koneksi MySQL via PDO (Singleton Wrapper)
- [x] Router minimalis (Handling GET/POST, URL Parameters `{slug}`, Middleware)
- [x] Front Controller (`public/index.php`) & penanganan error logging
- [x] Helper utilitas (CSRF token, Session, Old Input, XSS Protection Escaping)
- [x] Layout HTML dasar & Integrasi Awal Tailwind CSS

### 2. Fase 2 — Skema Database, Migrasi, & Seeder CLI `[x]`
- [x] File Migrasi SQL untuk 13 tabel database
- [x] Script CLI `bin/console.php` untuk menjalankan migrasi
- [x] Seeder data proyek (BUMDes, Wisata, Inventory) & Profil awal
- [x] CLI command untuk mendaftarkan akun admin pertama dengan aman

### 3. Fase 3 — Sistem Autentikasi Admin & Layout Dashboard `[x]`
- [x] Middleware `AuthMiddleware` (hanya login) & `GuestMiddleware` (belum login)
- [x] Login rate limiting untuk mencegah brute-force
- [x] Form login admin (`/admin/login`) dengan validasi CSRF & error masking
- [x] Template dashboard admin (`/admin/dashboard`) dengan sidebar responsive & statistik ringkas

### 4. Fase 4 — CMS CRUD Profil, Keahlian, Pendidikan, & CV `[x]`
- [x] CMS Profil (Update info personal, foto, kontak, ketersediaan magang)
- [x] CMS Keahlian (CRUD, kategori, pengurutan `sort_order`, status aktif)
- [x] CMS Pendidikan & Pengalaman (CRUD, validasi, pengurutan)
- [x] CMS CV (Upload PDF, validasi ukuran & tipe file, hapus file lama)

### 5. Fase 5 — CMS CRUD Proyek, Teknologi, & Galeri Dokumentasi `[x]`
- [x] CMS Kategori & Tagging Teknologi (Many-to-many relationship)
- [x] CMS Proyek (CRUD, status draft/publish, featured, slug otomatis)
- [x] CMS Galeri Multi-foto (Upload banyak foto per proyek dengan deskripsi terpisah)
- [x] Image Service (GD/Imagick resize, kompresi otomatis ke WebP/JPEG, thumbnail)

### 6. Fase 6 — CMS Kotak Pesan Masuk (Inbox) `[x]`
- [x] Form kontak publik (validasi input & anti-spam honeypot)
- [x] CRUD Inbox Admin (Pencarian, filter status read/unread/archived, arsip/hapus)
- [x] Tombol reply via `mailto:` email

### 7. Fase 7 — Halaman Publik (Frontend) `[x]`
- [x] Sticky navbar & responsive mobile hamburger menu
- [x] Visualisasi Hero, About, Skills, Educations & Experiences
- [x] AJAX/Vanilla JS filter untuk kategori/teknologi proyek
- [x] Sembunyikan bagian "Pengalaman" secara dinamis jika tidak ada entri aktif
- [x] Visualisasi Detail Proyek dengan galeri multimedia (GLightbox) & YouTube video embed
- [x] AJAX Submit form kontak dengan Toast pemberitahuan

### 8. Fase 8 — Optimasi SEO, Aksesibilitas, & Final Polishing `[x]`
- [x] Dynamic SEO Meta Tags, `sitemap.xml`, & `robots.txt`
- [x] Optimasi SQL (Eager Loading manual / No N+1 queries)
- [x] Keyboard navigation accessibility & screen reader alt texts
- [x] Linter audit (Zero warning & compile error)`README.md` & persiapan deployment hosting

---

## Revisi Visual Desain Scrapbook (Oktober 2026)
Dokumentasi lengkap dan rencana pengerjaan per section tersedia di: [REVISI_VISUAL_HERO_NAVBAR.md](file:///home/mikhsanhidayat/Projects/ikhsan_dev_portofolio/REVISI_VISUAL_HERO_NAVBAR.md).
- [x] **Tahap 1 — Navbar & Hero Section**:
  - [x] Desain Navbar warm white (`#FFFCF8`) dengan border bawah tipis (`#E8E1D6`) dan active state terracotta.
  - [x] Layout Hero dua kolom editorial dengan kontainer luas `1440px` dan padding responsif.
  - [x] Komposisi scrapbook: polaroid foto asli dengan washi tape, sticky note, grid paper, aksen botani, bintang doodle, dan kutipan tangan.
  - [x] Penataan ulang kartu informasi personal di kanan polaroid agar seluruh teks & ikon terbaca 100% tanpa tertutup foto.
  - [x] Tekstur background natural paper grain (SVG fractal noise) & micro stipple dots halus.
  - [x] Sinkronisasi seluruh identitas profesi di Hero secara dinamis ke database/CMS (`$profile['headline']`).
  - [x] Strip informasi bawah berbasis data riil tanpa klaim fiktif.
- [ ] **Tahap 2 — Section "Tentang Saya" (About Section)**
- [ ] **Tahap 3 — Section "Keahlian & Kompetensi" (Skills Section)**
- [ ] **Tahap 4 — Section "Riwayat Studi & Pengalaman" (Education & Timeline)**
- [ ] **Tahap 5 — Section "Proyek Portofolio" (Projects Section)**
- [ ] **Tahap 6 — Section "Kontak" & Footer**

---

## Fitur Tambahan & Kustomisasi (Agustus 2026) `[x]`
- [x] **Peta Google Maps Dinamis & Konversi Otomatis**:
  - Peta Google Maps tidak lagi di-hardcode, melainkan dimuat secara dinamis dari database.
  - Membuat menu **Pengaturan Website** di CMS Admin untuk mengelola data website (nama, meta title, meta description, teks footer, aksen warna, dan lokasi Google Maps).
  - Menambahkan fungsi pembersih URL pintar (`get_google_maps_embed_url()`) agar admin cukup mengetikkan alamat sederhana/nama kota (misal: *Ciawi, Tasikmalaya*) atau menempelkan link Google Maps biasa, dan sistem akan mengubahnya menjadi embed link yang valid secara otomatis.
- [x] **Penghapusan Teks Ketersediaan Magang**:
  - Menyembunyikan badge status ketersediaan magang di halaman utama.
  - Menghapus input opsi ketersediaan magang di Manajemen Profil Admin.
  - Menghapus teks penyebutan *"tawaran magang"* pada deskripsi form kontak halaman publik dan teks *"penawaran magang"* di footer website.
- [x] **Penambahan Media Sosial Baru**:
  - Menambahkan kolom media sosial `instagram_url`, `tiktok_url`, dan `youtube_url` pada database.
  - Menambahkan form input untuk ketiga sosial media tersebut di CMS Manajemen Profil.
  - Memperbarui footer agar menampilkan tombol sosial media tersebut secara dinamis menggunakan **inline SVG** natif demi mencegah *race condition* dan memastikan ikon selalu tampil stabil.
- [x] **Pemberlakuan & Perbaikan CSP (Content Security Policy)**:
  - Memperbarui header CSP di `public/index.php` untuk meloloskan aset script/style dari `unpkg.com` (Lucide Icons) dan `cdn.jsdelivr.net` (GLightbox) sehingga seluruh ikon sidebar, tombol aksi edit/delete, notifikasi sukses, dan modal foto kembali berfungsi.
  - Meloloskan domain `google.com` & `maps.google.com` pada CSP `frame-src` agar iframe peta interaktif dapat termuat tanpa diblokir oleh browser.

---

## Panduan & Checklist Deployment ZIP (InfinityFree) `[ ]`
- [ ] **Langkah 1: Ekspor Database Lokal**
  - [ ] Ekspor database lokal menjadi file `.sql` melalui phpMyAdmin lokal Anda.
- [ ] **Langkah 2: Setup Database & Impor di InfinityFree**
  - [ ] Buat akun hosting di InfinityFree & daftarkan domain gratis (`.rf.gd` atau sejenisnya).
  - [ ] Buat database MySQL baru di control panel InfinityFree.
  - [ ] Catat detail `DB_HOST`, `DB_NAME`, `DB_USER`, dan `DB_PASS` dari halaman detail database.
  - [ ] Impor file `.sql` lokal ke database hosting menggunakan phpMyAdmin online InfinityFree.
- [ ] **Langkah 3: Kompresi File ke ZIP (Lokal)**
  - [ ] Buat file **`core.zip`** berisi folder/file utama: `app`, `database`, `resources`, `routes`, `storage`, `vendor`, `.env`, `composer.json` (semua file proyek kecuali folder `public`).
  - [ ] Masuk ke dalam folder `public/`, lalu buat file **`public.zip`** berisi file di dalamnya: `index.php`, `robots.txt`, dan folder `uploads`.
- [ ] **Langkah 4: Unggah ZIP via FTP Client**
  - [ ] Hubungkan FTP client (misal: FileZilla) ke akun hosting InfinityFree Anda.
  - [ ] Unggah **`core.zip`** ke direktori root luar server (sejajar dengan folder `htdocs/`).
  - [ ] Unggah **`public.zip`** ke dalam folder **`htdocs/`** di server.
- [ ] **Langkah 5: Ekstrak ZIP via Online File Manager**
  - [ ] Masuk ke dashboard akun InfinityFree di browser Anda, lalu klik **File Manager** (atau Online File Manager).
  - [ ] Masuk ke dalam folder `htdocs/`, klik kanan file `public.zip`, lalu pilih **Unzip** atau *Extract*.
  - [ ] Kembali ke luar folder `htdocs/`, klik kanan file `core.zip`, lalu pilih **Unzip** atau *Extract*.
  - [ ] Hapus file `core.zip` dan `public.zip` di server setelah ekstraksi berhasil diselesaikan.
- [ ] **Langkah 6: Konfigurasi Produksi `.env` di Server**
  - [ ] Edit file `.env` di server hosting (di luar htdocs).
  - [ ] Ubah `APP_ENV` menjadi `production`.
  - [ ] Ubah `APP_URL` ke domain InfinityFree Anda (contoh: `https://username.rf.gd`).
  - [ ] Masukkan detail kredensial database InfinityFree (`DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASS`).
- [ ] **Langkah 7: Atur Hak Akses Folder Uploads**
  - [ ] Ubah hak akses (*permissions*) folder `htdocs/uploads/` di server menjadi `775` atau `777` menggunakan FTP client (agar foto & galeri proyek bisa diunggah di server).
- [ ] **Langkah 8: Verifikasi & Uji Coba**
  - [ ] Buka domain website publik dan pastikan halaman utama, peta Google Maps, dan footer tampil tanpa error.
  - [ ] Masuk ke halaman `/admin/login` menggunakan kredensial admin dan pastikan fitur CMS bekerja normal.
