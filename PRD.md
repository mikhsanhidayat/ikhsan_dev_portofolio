# Product Requirements Document (PRD)
## Aplikasi Portofolio Mahasiswa Manajemen Informatika

| Informasi | Detail |
|---|---|
| **Jenis produk** | Website portofolio pribadi dan sistem manajemen konten |
| **Target pengguna** | Mahasiswa Manajemen Informatika yang mencari tempat magang |
| **Pengunjung utama** | Rekruter, HR, calon pembimbing, dosen, dan calon klien |
| **Teknologi utama** | Native PHP, MySQL, Tailwind CSS, dan JavaScript |
| **Panel pengelola** | Satu akun Admin |
| **Status dokumen** | Versi awal (MVP) |

---

### 1. Latar Belakang
Pemilik portofolio adalah mahasiswa D3 Manajemen Informatika yang sedang mempersiapkan diri untuk melamar magang, terutama pada bidang pengembangan web/backend. Pemilik sudah memiliki beberapa proyek, termasuk proyek digitalisasi saat KKN dan tugas kuliah, tetapi membutuhkan satu media terpusat untuk menampilkan profil, keahlian, dokumentasi proyek, pendidikan, CV, serta informasi kontak.

Website harus dapat dikelola secara mandiri melalui dashboard admin. Dengan demikian, penambahan proyek, foto dokumentasi, teknologi, CV, dan informasi lain tidak memerlukan perubahan kode secara langsung.

---

### 2. Tujuan Produk
- Menampilkan identitas dan kemampuan pemilik secara rapi dan meyakinkan.
- Mengumpulkan seluruh dokumentasi proyek dalam satu website.
- Menjelaskan kontribusi, proses, teknologi, serta hasil dari setiap proyek.
- Memudahkan rekruter melihat CV, GitHub, demo proyek, dan kontak pemilik.
- Memungkinkan seluruh konten utama dikelola melalui dashboard admin.
- Menyediakan saluran pesan bagi pengunjung yang ingin menghubungi pemilik.

---

### 3. Sasaran Pengguna
#### 3.1 Pengunjung
- Rekruter atau HR perusahaan tempat magang.
- Tim teknis yang ingin menilai kemampuan kandidat.
- Dosen, pembimbing, calon klien, atau pengunjung umum.
- Tidak perlu membuat akun atau login.

#### 3.2 Admin
- Hanya satu akun admin, yaitu pemilik portofolio.
- Memiliki akses penuh untuk mengelola seluruh konten.
- Login melalui halaman khusus yang tidak ditampilkan sebagai menu utama publik.

---

### 4. Ruang Lingkup MVP
Versi awal mencakup:
- Landing page portofolio.
- Profil dan keahlian.
- Daftar serta detail proyek.
- Galeri beberapa foto pada setiap proyek.
- Judul dan deskripsi khusus pada setiap foto proyek.
- Informasi pendidikan.
- Bagian pengalaman yang bersifat opsional.
- CV yang dapat dilihat atau diunduh.
- Informasi kontak dan tautan media profesional.
- Formulir pesan pengunjung.
- Dashboard admin untuk mengelola seluruh konten.
- Autentikasi satu akun admin.

---

### 5. Konsep Tampilan
Tampilan menggunakan gaya semi-profesional: tetap formal dan meyakinkan untuk rekruter, tetapi tidak terasa kaku.

Prinsip desain:
- Bersih, modern, rapi, dan mudah dipahami.
- Responsif pada desktop, tablet, dan ponsel.
- Hierarki informasi jelas dan tidak terlalu padat.
- Warna utama netral seperti putih, slate, dan abu-abu terang, dengan satu warna aksen profesional seperti biru atau indigo.
- Animasi masuk yang halus ketika section terlihat.
- Hover dan micro-interaction pada kartu proyek, tombol, tautan, dan galeri.
- Animasi tidak boleh mengganggu kecepatan maupun keterbacaan.
- Mendukung `prefers-reduced-motion` untuk pengunjung yang mengurangi animasi.
- Tipografi modern dan mudah dibaca, misalnya Inter atau Plus Jakarta Sans.

---

### 6. Struktur Halaman Publik
#### 6.1 Header dan Navigasi
Menu utama:
- Beranda
- Tentang Saya
- Keahlian
- Proyek
- Pendidikan
- Pengalaman, hanya tampil jika memiliki data aktif
- Kontak
- Tombol Lihat/Unduh CV

Ketentuan:
- Header bersifat sticky ketika halaman digulir.
- Navigasi mobile menggunakan hamburger menu.
- Menu aktif mengikuti section yang sedang dilihat.
- Logo dapat berupa inisial, nama, atau logo pribadi yang dikelola admin.

#### 6.2 Hero Section
Menampilkan:
- Foto profil.
- Nama lengkap.
- Gelar/status singkat, misalnya “Mahasiswa D3 Manajemen Informatika”.
- Posisi yang dituju, misalnya “Backend Developer Intern”.
- Ringkasan singkat dan menarik.
- Tombol “Lihat Proyek”.
- Tombol “Unduh CV”.
- Tautan GitHub dan kontak profesional.
- Seluruh informasi dapat diubah dari dashboard admin.

#### 6.3 Tentang Saya
Menampilkan profil ringkas yang menjelaskan latar belakang, minat, fokus karier, dan nilai yang dapat diberikan. Teks dibuat singkat agar mudah dibaca rekruter.

Data yang dikelola:
- Judul section.
- Deskripsi singkat.
- Foto pendukung opsional.
- Lokasi atau domisili opsional.
- Status ketersediaan magang.

#### 6.4 Keahlian
Keahlian dikelompokkan agar mudah dipindai, misalnya:
- Backend: PHP dan Laravel.
- Database: MySQL.
- Frontend: HTML, Tailwind CSS, dan JavaScript.
- Tools: Git dan GitHub.
- Soft skill atau kemampuan lain.

Setiap keahlian dapat memiliki:
- Nama.
- Kategori.
- Ikon opsional.
- Level pemahaman opsional.
- Urutan tampilan.
- Status aktif/nonaktif.

*Catatan: jika level kemampuan digunakan, label seperti “Dasar”, “Menengah”, dan “Mahir” lebih disarankan daripada persentase yang sulit dibuktikan.*

#### 6.5 Daftar Proyek
Menampilkan proyek dalam bentuk kartu yang rapi. Proyek dapat berasal dari:
- Proyek KKN.
- Tugas kuliah.
- Proyek pribadi.
- Proyek freelance atau pekerjaan pada masa mendatang.

Kartu proyek memuat:
- Thumbnail.
- Nama proyek.
- Kategori.
- Ringkasan.
- Teknologi utama.
- Tahun atau periode pengerjaan.
- Tombol “Lihat Detail”.
- Status proyek unggulan bila dipilih admin.

Fitur daftar:
- Filter berdasarkan kategori atau teknologi.
- Proyek unggulan dapat ditempatkan paling atas.
- Pagination atau tombol “Muat Lebih Banyak” jika jumlah proyek bertambah.
- Empty state jika belum ada proyek pada suatu kategori.

#### 6.6 Detail Proyek
Setiap proyek memiliki halaman detail dengan URL berbasis slug, misalnya `/project/pengelolaan-keuangan-bumdes`.

Informasi proyek:
- Nama dan kategori proyek.
- Thumbnail atau cover.
- Ringkasan proyek.
- Latar belakang atau masalah.
- Tujuan proyek.
- Solusi yang dibuat.
- Peran dan tanggung jawab pemilik portofolio.
- Proses atau tahapan pengerjaan.
- Teknologi yang digunakan.
- Fitur utama.
- Hasil atau dampak proyek.
- Tantangan dan pembelajaran opsional.
- Periode pengerjaan.
- Status proyek, misalnya selesai atau dalam pengembangan.
- Tautan demo/website jika tersedia.
- Tautan repository GitHub jika tersedia.
- Tombol kembali ke daftar proyek.

##### Galeri Dokumentasi Proyek
Satu proyek dapat mempunyai banyak foto. Setiap foto merupakan data tersendiri dan memiliki:
- File foto.
- Judul foto.
- Deskripsi detail foto.
- Teks alternatif untuk aksesibilitas.
- Urutan tampilan.
- Status aktif/nonaktif.

*Contoh penggunaan:*
- *Foto 1: halaman dashboard — menjelaskan fungsi statistik dan informasi yang tampil.*
- *Foto 2: halaman transaksi — menjelaskan alur pengguna memasukkan data.*
- *Foto 3: dokumentasi implementasi — menjelaskan konteks penggunaan proyek.*

Ketentuan galeri:
- Ditampilkan sebagai grid yang responsif.
- Foto dapat dibuka melalui modal/lightbox.
- Judul dan deskripsi tampil dengan jelas, tidak hanya sebagai tooltip.
- Mendukung format JPG, JPEG, PNG, dan WebP.
- Video bersifat opsional untuk pengembangan berikutnya; pada MVP dapat menggunakan URL YouTube agar penyimpanan server tetap ringan.
- Admin dapat menambah, mengubah, menghapus, dan mengurutkan foto.

#### 6.7 Pendidikan
Menampilkan:
- Nama institusi.
- Program studi.
- Jenjang pendidikan.
- Tahun mulai dan tahun selesai/perkiraan lulus.
- Deskripsi atau kegiatan akademik opsional.
- Logo institusi opsional.
- Data dapat diurutkan berdasarkan periode.

#### 6.8 Pengalaman (Opsional)
Bagian pengalaman disiapkan untuk kebutuhan masa depan. Data dapat berupa pengalaman kerja, magang, organisasi, kepanitiaan, atau pengalaman relevan lainnya.

Aturan:
- Section otomatis disembunyikan jika tidak ada data aktif.
- Admin dapat mengaktifkan section setelah memiliki pengalaman.
- Proyek KKN tidak wajib dimasukkan sebagai pengalaman kerja; proyek tersebut dapat lebih dahulu ditonjolkan pada bagian proyek.

Data pengalaman:
- Nama organisasi/perusahaan.
- Posisi atau peran.
- Jenis pengalaman.
- Periode.
- Deskripsi dan tanggung jawab.
- Status aktif/nonaktif.

#### 6.9 CV
Fitur CV meliputi:
- Tombol melihat CV pada tab baru.
- Tombol mengunduh file CV.
- File PDF dikelola melalui dashboard admin.
- Admin dapat mengganti CV tanpa mengubah kode.
- Sistem hanya menampilkan tombol jika file CV tersedia.

#### 6.10 Kontak
Menampilkan:
- Email.
- Nomor WhatsApp opsional.
- Lokasi/domisi opsional.
- GitHub.
- LinkedIn opsional.
- Media sosial profesional lainnya.

Tersedia formulir pesan dengan field:
- Nama.
- Email.
- Subjek.
- Isi pesan.
- Persetujuan sederhana bahwa data digunakan untuk membalas pesan, jika diperlukan.

Setelah berhasil dikirim, sistem menampilkan notifikasi yang jelas tanpa memuat ulang halaman jika implementasi AJAX digunakan.

---

### 7. Dashboard Admin
#### 7.1 Login Admin
- Login menggunakan email/username dan password.
- Tidak tersedia registrasi publik.
- Password disimpan menggunakan `password_hash()` dan diverifikasi dengan `password_verify()`.
- Session ID diperbarui setelah login.
- Admin dapat logout.
- Pembatasan percobaan login diterapkan untuk mengurangi brute-force.

#### 7.2 Ringkasan Dashboard
Menampilkan kartu statistik:
- Jumlah proyek.
- Jumlah foto dokumentasi.
- Jumlah pesan masuk.
- Jumlah pesan belum dibaca.
- Waktu pembaruan konten terakhir.
- Dashboard juga menampilkan pesan terbaru dan shortcut untuk menambah proyek.

#### 7.3 Manajemen Profil
Admin dapat mengubah:
- Nama dan headline.
- Deskripsi singkat.
- Tentang saya.
- Foto profil.
- Logo atau favicon.
- Posisi magang yang dituju.
- Status ketersediaan magang.
- Data kontak dan tautan sosial.

#### 7.4 Manajemen Keahlian
- Tambah, lihat, edit, dan hapus keahlian.
- Atur kategori dan urutan.
- Aktifkan atau nonaktifkan data.
- Validasi agar nama keahlian tidak kosong.

#### 7.5 Manajemen Proyek
- Tambah, lihat, edit, dan hapus proyek.
- Simpan proyek sebagai draft atau terbitkan.
- Tentukan proyek unggulan.
- Kelola slug yang unik.
- Tambahkan beberapa teknologi pada proyek.
- Kelola tautan demo dan GitHub.
- Kelola seluruh konten detail proyek.
- Preview proyek sebelum diterbitkan.

#### 7.6 Manajemen Galeri Proyek
- Unggah beberapa foto ke satu proyek.
- Isi judul dan deskripsi berbeda untuk setiap foto.
- Edit metadata foto tanpa perlu mengunggah ulang gambarnya.
- Ganti file foto jika diperlukan.
- Atur urutan menggunakan tombol naik/turun atau drag-and-drop.
- Hapus foto dengan dialog konfirmasi.
- Buat thumbnail otomatis atau versi gambar terkompresi.

#### 7.7 Manajemen Pendidikan dan Pengalaman
- CRUD data pendidikan.
- CRUD data pengalaman.
- Atur urutan dan status aktif.
- Pengalaman tidak ditampilkan jika tidak memiliki data aktif.

#### 7.8 Manajemen CV
- Unggah atau ganti CV berformat PDF.
- Tampilkan nama file dan tanggal pembaruan.
- Validasi jenis dan ukuran file.
- File lama dapat dihapus setelah penggantian berhasil.

#### 7.9 Manajemen Pesan
- Melihat daftar pesan.
- Melihat detail pesan.
- Status belum dibaca dan sudah dibaca.
- Tandai pesan sebagai dibaca/belum dibaca.
- Arsipkan atau hapus pesan.
- Tombol balas melalui aplikasi email (`mailto:`).
- Pencarian berdasarkan nama, email, subjek, atau isi pesan.

#### 7.10 Pengaturan Website
- Nama dan deskripsi website.
- Meta title dan meta description bawaan.
- Logo dan favicon.
- Warna aksen utama dalam pilihan yang dibatasi.
- Tautan media sosial.
- Pengaturan tampil/sembunyi section.
- Informasi footer.

---

### 8. Alur Utama Pengguna
#### 8.1 Pengunjung Menilai Portofolio
1. Pengunjung membuka landing page.
2. Pengunjung melihat profil singkat dan keahlian utama.
3. Pengunjung membuka daftar proyek.
4. Pengunjung memilih salah satu proyek.
5. Pengunjung membaca peran, proses, teknologi, dan hasil proyek.
6. Pengunjung melihat beberapa foto beserta penjelasan masing-masing.
7. Pengunjung membuka GitHub/demo atau mengunduh CV.
8. Pengunjung menghubungi pemilik melalui formulir kontak.

#### 8.2 Admin Menerbitkan Proyek
1. Admin login.
2. Admin memilih menu Proyek dan menekan “Tambah Proyek”.
3. Admin mengisi informasi utama serta detail proyek.
4. Admin memilih teknologi yang digunakan.
5. Admin mengunggah cover dan beberapa foto dokumentasi.
6. Admin mengisi judul dan deskripsi pada setiap foto.
7. Admin mengatur urutan foto.
8. Admin melakukan preview.
9. Admin menyimpan sebagai draft atau menerbitkan proyek.

---

### 9. Kebutuhan Fungsional

| ID | Kebutuhan | Prioritas |
|---|---|---|
| **FR-01** | Sistem menampilkan landing page portofolio yang responsif | Wajib |
| **FR-02** | Sistem menampilkan profil, keahlian, pendidikan, CV, dan kontak | Wajib |
| **FR-03** | Sistem menampilkan daftar dan detail proyek | Wajib |
| **FR-04** | Satu proyek dapat mempunyai banyak teknologi | Wajib |
| **FR-05** | Satu proyek dapat mempunyai banyak foto dokumentasi | Wajib |
| **FR-06** | Setiap foto proyek mempunyai judul dan deskripsi tersendiri | Wajib |
| **FR-07** | Pengunjung dapat membuka demo, GitHub, dan CV jika tersedia | Wajib |
| **FR-08** | Pengunjung dapat mengirim pesan tanpa akun | Wajib |
| **FR-09** | Admin dapat login dan logout | Wajib |
| **FR-10** | Admin dapat mengelola seluruh konten utama | Wajib |
| **FR-11** | Admin dapat menyimpan proyek sebagai draft atau terbit | Wajib |
| **FR-12** | Admin dapat melihat dan mengelola pesan masuk | Wajib |
| **FR-13** | Section kosong atau nonaktif dapat disembunyikan | Wajib |
| **FR-14** | Admin dapat mengatur urutan proyek, keahlian, dan foto | Wajib |
| **FR-15** | Sistem menyediakan filter proyek berdasarkan kategori/teknologi | Disarankan |
| **FR-16** | Sistem menyediakan preview proyek sebelum publikasi | Disarankan |
| **FR-17** | Pengiriman form kontak menggunakan AJAX | Opsional |
| **FR-18** | Sistem mendukung URL YouTube pada detail proyek | Opsional |

---

### 10. Rancangan Data Utama

#### 10.1 admins
- `id` (INT, Primary Key, Auto Increment)
- `name` (VARCHAR)
- `email` (VARCHAR, Unique)
- `password` (VARCHAR)
- `last_login_at` (DATETIME)
- `created_at` (TIMESTAMP)
- `updated_at` (TIMESTAMP)

#### 10.2 profiles
- `id` (INT, Primary Key, Auto Increment)
- `full_name` (VARCHAR)
- `headline` (VARCHAR)
- `internship_target` (VARCHAR)
- `short_bio` (TEXT)
- `about_text` (TEXT)
- `profile_photo` (VARCHAR)
- `location` (VARCHAR)
- `availability_status` (TINYINT)
- `email` (VARCHAR)
- `whatsapp` (VARCHAR)
- `github_url` (VARCHAR)
- `linkedin_url` (VARCHAR)
- `created_at` (TIMESTAMP)
- `updated_at` (TIMESTAMP)

#### 10.3 skills
- `id` (INT, Primary Key, Auto Increment)
- `name` (VARCHAR)
- `category` (VARCHAR)
- `icon` (VARCHAR)
- `proficiency_level` (VARCHAR)
- `sort_order` (INT)
- `is_active` (TINYINT)
- `created_at` (TIMESTAMP)
- `updated_at` (TIMESTAMP)

#### 10.4 project_categories
- `id` (INT, Primary Key, Auto Increment)
- `name` (VARCHAR)
- `slug` (VARCHAR, Unique)
- `is_active` (TINYINT)

#### 10.5 projects
- `id` (INT, Primary Key, Auto Increment)
- `category_id` (INT, Foreign Key referencing project_categories)
- `title` (VARCHAR)
- `slug` (VARCHAR, Unique)
- `summary` (TEXT)
- `background` (TEXT)
- `objective` (TEXT)
- `solution` (TEXT)
- `role_description` (TEXT)
- `process_description` (TEXT)
- `feature_description` (TEXT)
- `result_description` (TEXT)
- `challenge_description` (TEXT)
- `cover_image` (VARCHAR)
- `start_date` (DATE)
- `end_date` (DATE)
- `project_status` (VARCHAR)
- `demo_url` (VARCHAR)
- `github_url` (VARCHAR)
- `video_url` (VARCHAR)
- `publication_status` (VARCHAR - draft/published)
- `is_featured` (TINYINT)
- `sort_order` (INT)
- `published_at` (DATETIME)
- `created_at` (TIMESTAMP)
- `updated_at` (TIMESTAMP)

#### 10.6 technologies
- `id` (INT, Primary Key, Auto Increment)
- `name` (VARCHAR)
- `icon` (VARCHAR)
- `is_active` (TINYINT)

#### 10.7 project_technologies
- `project_id` (INT, Composite Primary Key, Foreign Key referencing projects)
- `technology_id` (INT, Composite Primary Key, Foreign Key referencing technologies)

#### 10.8 project_media
- `id` (INT, Primary Key, Auto Increment)
- `project_id` (INT, Foreign Key referencing projects)
- `media_type` (VARCHAR - image/video_url)
- `file_path` (VARCHAR)
- `external_url` (VARCHAR)
- `title` (VARCHAR)
- `description` (TEXT)
- `alt_text` (VARCHAR)
- `sort_order` (INT)
- `is_active` (TINYINT)
- `created_at` (TIMESTAMP)
- `updated_at` (TIMESTAMP)

#### 10.9 educations
- `id` (INT, Primary Key, Auto Increment)
- `institution_name` (VARCHAR)
- `study_program` (VARCHAR)
- `degree` (VARCHAR)
- `start_year` (INT)
- `end_year` (INT)
- `description` (TEXT)
- `logo` (VARCHAR)
- `sort_order` (INT)
- `is_active` (TINYINT)

#### 10.10 experiences
- `id` (INT, Primary Key, Auto Increment)
- `organization_name` (VARCHAR)
- `role` (VARCHAR)
- `experience_type` (VARCHAR)
- `start_date` (DATE)
- `end_date` (DATE)
- `is_current` (TINYINT)
- `description` (TEXT)
- `sort_order` (INT)
- `is_active` (TINYINT)

#### 10.11 messages
- `id` (INT, Primary Key, Auto Increment)
- `name` (VARCHAR)
- `email` (VARCHAR)
- `subject` (VARCHAR)
- `message` (TEXT)
- `status` (VARCHAR - unread/read/archived)
- `read_at` (DATETIME)
- `created_at` (TIMESTAMP)

#### 10.12 settings
- `id` (INT, Primary Key, Auto Increment)
- `key` (VARCHAR, Unique)
- `value` (TEXT)
- `type` (VARCHAR)
- `updated_at` (TIMESTAMP)

#### 10.13 documents
- `id` (INT, Primary Key, Auto Increment)
- `document_type` (VARCHAR - cv)
- `file_path` (VARCHAR)
- `original_name` (VARCHAR)
- `is_active` (TINYINT)
- `created_at` (TIMESTAMP)
- `updated_at` (TIMESTAMP)

---

### 11. Aturan Validasi
- Semua input wajib dibersihkan dan divalidasi di sisi server.
- Judul proyek wajib diisi dan slug harus unik.
- Email pesan harus memiliki format yang valid.
- URL demo, GitHub, LinkedIn, dan video harus divalidasi.
- Foto hanya menerima JPG, JPEG, PNG, atau WebP.
- File CV hanya menerima PDF.
- Ukuran maksimal awal yang disarankan: 5 MB per foto dan 10 MB untuk CV; dapat disesuaikan dengan kapasitas hosting.
- Deskripsi panjang perlu menggunakan editor yang aman atau textarea terstruktur.
- Field opsional tidak boleh menghasilkan elemen kosong pada halaman publik.

---

### 12. Keamanan
- Gunakan PDO dengan prepared statements untuk seluruh query database.
- Gunakan CSRF token pada seluruh formulir yang mengubah data.
- Terapkan escaping output untuk mencegah XSS.
- Jika memakai rich text editor, lakukan sanitasi HTML dengan allowlist.
- Gunakan `password_hash()` dan `password_verify()` untuk password admin.
- Regenerasi session ID setelah login.
- Terapkan cookie session HttpOnly, Secure pada HTTPS, dan SameSite.
- Batasi percobaan login dan pengiriman form kontak.
- Tambahkan honeypot atau CAPTCHA pada form kontak bila spam meningkat.
- Ubah nama file upload menjadi nama acak; jangan mempercayai ekstensi dari pengguna.
- Simpan konfigurasi database dan data rahasia dalam file `.env` di luar folder publik.
- Tambahkan konfirmasi untuk aksi hapus.

---

### 13. Kebutuhan Nonfungsional
#### 13.1 Performa
- Halaman utama ditargetkan tampil cepat pada koneksi seluler.
- Terapkan lazy loading pada galeri.
- Konversi atau sediakan gambar WebP jika memungkinkan.
- Buat thumbnail agar halaman daftar tidak memuat gambar asli berukuran besar.
- Minify aset CSS dan JavaScript pada produksi.

#### 13.2 Responsivitas
- Tampilan berfungsi baik mulai lebar layar sekitar 320 px.
- Dashboard tetap dapat digunakan melalui ponsel, tetapi dioptimalkan untuk desktop/tablet.

#### 13.3 Aksesibilitas
- Kontras warna memenuhi standar yang baik.
- Setiap gambar memiliki alt text.
- Seluruh form memiliki label.
- Navigasi dan modal dapat digunakan dengan keyboard.
- Focus state terlihat jelas.

#### 13.4 SEO
- URL proyek menggunakan slug yang mudah dibaca.
- Tersedia meta title dan meta description.
- Gunakan semantic HTML.
- Tambahkan Open Graph untuk pratinjau saat tautan dibagikan.
- Sediakan `sitemap.xml` dan `robots.txt`.
- Structured data Person dan CreativeWork dapat ditambahkan.

#### 13.5 Kompatibilitas
- Mendukung versi terbaru Chrome, Edge, Firefox, dan Safari.
- Harus tetap dapat digunakan jika animasi JavaScript gagal dijalankan.

---

### 14. Rekomendasi Teknologi
- **Backend:** Native PHP 8.2 atau lebih baru
- **Database:** MySQL 8.x
- **Database access:** PDO + prepared statements
- **Frontend:** Tailwind CSS
- **Interaksi:** Vanilla JavaScript
- **Build frontend:** Node.js, npm, dan Tailwind CLI/Vite hanya pada proses pengembangan
- **Ikon:** Lucide Icons
- **Animasi:** CSS/Intersection Observer; AOS dapat digunakan jika benar-benar diperlukan
- **Galeri:** GLightbox atau PhotoSwipe
- **Editor konten:** Editor ringan dengan sanitasi, misalnya Tiptap/Quill, atau textarea jika ingin lebih sederhana
- **Email:** PHPMailer melalui SMTP, opsional untuk notifikasi pesan masuk
- **Environment:** `vlucas/phpdotenv`, disarankan
- **Dependency manager:** Composer

*Catatan: meskipun menggunakan native PHP, struktur kode tetap menggunakan pola MVC sederhana agar mudah dirawat. Routing, controller, model/repository, view, middleware autentikasi, validasi, dan service upload dipisahkan dengan jelas.*

---

### 15. Struktur Teknis yang Disarankan
```
app/
  Controllers/
  Models/
  Repositories/
  Services/
  Middleware/
  Helpers/
config/
database/
  migrations/
public/
  assets/
  uploads/
  index.php
resources/
  views/
routes/
storage/
  logs/
vendor/
```
*Folder upload perlu dibagi, misalnya projects/covers, projects/gallery, profile, documents, dan settings. Jika memungkinkan, file sensitif serta file asli disimpan di luar folder publik dan dilayani melalui controller yang aman.*

---

### 16. Notifikasi dan Empty State
- Setiap operasi admin menampilkan notifikasi berhasil atau gagal.
- Kesalahan validasi muncul dekat field terkait.
- Daftar kosong menampilkan penjelasan dan tombol tindakan, misalnya “Belum ada proyek—Tambah Proyek”.
- Tautan demo/GitHub yang belum diisi tidak ditampilkan.
- Jika pengalaman belum tersedia, menu dan section pengalaman disembunyikan otomatis.

---

### 17. Kriteria Penerimaan MVP
Produk dinyatakan siap digunakan jika:
- Landing page responsif dan seluruh section aktif dapat diakses.
- Pengunjung dapat melihat profil, keahlian, proyek, pendidikan, CV, dan kontak.
- Detail proyek menampilkan informasi lengkap dan galeri multi-foto.
- Setiap foto proyek dapat memiliki judul dan deskripsi berbeda.
- Admin dapat login dengan aman melalui satu akun.
- Admin dapat mengelola profil, keahlian, proyek, galeri, pendidikan, pengalaman, CV, kontak, dan pengaturan.
- Admin dapat menerbitkan atau menyimpan proyek sebagai draft.
- Pengunjung dapat mengirim pesan dan admin dapat membaca pesan tersebut.
- Section pengalaman tidak tampil ketika tidak memiliki data aktif.
- Upload gambar dan PDF memiliki validasi jenis serta ukuran file.
- Formulir terlindungi CSRF dan query database menggunakan prepared statements.
- Website dapat digunakan dengan baik di desktop dan ponsel.
- Tidak terdapat tautan kosong, gambar rusak, atau error PHP pada lingkungan produksi.

---

### 18. Tahapan Pengembangan
- **Fase 1 — Fondasi:** Menyiapkan struktur native PHP berbasis MVC sederhana. Konfigurasi environment dan koneksi MySQL. Membuat migration/schema database. Membuat sistem login satu admin. Membuat layout publik dan dashboard.
- **Fase 2 — Pengelolaan Konten:** CRUD profil dan pengaturan. CRUD keahlian. CRUD pendidikan dan pengalaman. Upload serta pengelolaan CV.
- **Fase 3 — Proyek dan Dokumentasi:** CRUD kategori, teknologi, dan proyek. Draft, publish, featured project, dan preview. Upload multi-foto. Judul serta deskripsi per foto. Pengurutan galeri dan lightbox.
- **Fase 4 — Kontak dan Penyempurnaan:** Form pesan dan inbox admin. Validasi keamanan dan anti-spam. Animasi serta micro-interaction. SEO, performa, aksesibilitas, dan responsivitas.
- **Fase 5 — Pengujian dan Deployment:** Pengujian fungsi publik dan admin. Pengujian upload, login, session, CSRF, dan validasi. Pengujian mobile dan browser. Backup database dan file upload. Deployment pada hosting PHP + MySQL dengan HTTPS.

---

### 19. Di Luar Ruang Lingkup MVP
- Registrasi pengguna publik.
- Beberapa role atau beberapa admin.
- Komentar publik pada proyek.
- Sistem blog yang kompleks.
- Analitik pengunjung buatan sendiri.
- Upload video berukuran besar ke server.
- Aplikasi mobile native.
- Fitur lowongan atau proses rekrutmen.
- Multi-bahasa; dapat ditambahkan pada versi selanjutnya.

---

### 20. Pengembangan Berikutnya
- Bahasa Indonesia dan Inggris.
- Blog atau catatan pembelajaran.
- Testimoni.
- Sertifikat dan pencapaian.
- Integrasi statistik pengunjung yang menjaga privasi.
- Export data pesan.
- Audit log aktivitas admin.
- Mode gelap.
- Progressive Web App.

---

### 21. Asumsi Versi Awal
- Website menggunakan Bahasa Indonesia terlebih dahulu.
- Hanya terdapat satu pemilik dan satu akun admin.
- Pengalaman belum wajib diisi dan otomatis disembunyikan jika kosong.
- Fokus utama portofolio adalah proyek KKN, tugas kuliah, dan proyek pribadi.
- Video pada MVP menggunakan tautan eksternal, bukan upload langsung.
- Pemilihan warna final dapat disesuaikan setelah identitas visual atau logo pribadi tersedia.
