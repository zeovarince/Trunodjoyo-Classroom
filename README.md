<p align="center">
  <img src="https://readme-typing-svg.demolab.com?font=Press+Start+2P&size=25&pause=1000&color=FBBF24&center=true&vCenter=true&width=1000&lines=Welcome+to+Trunodjoyo+Classroom+%F0%9F%8E%93;Interactive+Learning+Management+System;Teknik+Informatika+-+UTM" alt="TrunodjoyoClassroom Typing SVG" />
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
  <img src="https://img.shields.io/badge/License-MIT-gold?style=for-the-badge" alt="License MIT" />
</p>

<p align="center">
  <strong><i>Learning Management System (LMS) Modern, Terstruktur, dan Gamified.</i></strong>
  <br />
  Proyek Tugas Besar Mata Kuliah Pemrograman Berbasis Framework
  <br />
  Program Studi Teknik Informatika, Universitas Trunojoyo Madura.
</p>

<img align="right" width=50px height=50px alt="side_sticker" src="https://media4.giphy.com/media/v1.Y2lkPTc5MGI3NjExd2M0NDFsbzJpaWQ3OGhlZWJ1ODYydXQycThyc2hlZHIwM2dhNW9zMyZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/Ut9IfYd8U1C0CNQi76/giphy.gif" />


<a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ"><img src="https://user-images.githubusercontent.com/73097560/115834477-dbab4500-a447-11eb-908a-139a6edaec5c.gif"></a>


## 📖 Deskripsi Proyek

TrunodjoyoClassroom adalah platform e-learning responsif yang dirancang untuk mensimulasikan lingkungan kelas virtual dengan manajemen materi yang terstruktur dan interaktif. Dibangun menggunakan arsitektur MVC pada Laravel, aplikasi ini menawarkan pengalaman belajar yang rapi melalui sistem Lembar Persiapan Perkuliahan (LPP) dan fitur gamifikasi untuk memotivasi mahasiswa.

<a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ"><img src="https://user-images.githubusercontent.com/73097560/115834477-dbab4500-a447-11eb-908a-139a6edaec5c.gif"></a>

## ✨ Fitur Unggulan

- 📂 **Modul LPP (Lembar Persiapan Perkuliahan):** Materi dan tugas dikelompokkan secara terstruktur per pertemuan, bukan ditumpuk di satu beranda utama.
- 🎮 **Sistem Gamifikasi (EXP & Leveling):** Mahasiswa mendapatkan poin EXP saat mengumpulkan tugas tepat waktu. Poin ini secara dinamis mengubah desain *border* foto profil mereka menggunakan indikator level.
- 💬 **Forum Diskusi Terstruktur (Threads):** Ruang tanya jawab interaktif yang diikat secara spesifik pada masing-masing modul LPP/Materi.
- 🔔 **Notifikasi In-App Realtime:** Pemberitahuan internal (lonceng notifikasi) menggunakan *Database Notifications* Laravel untuk info tugas atau nilai baru.
- 🛡️ **Keamanan Data (Soft Deletes):** Mencegah kehilangan data vital (seperti kelas, materi, dan tugas) akibat ketidaksengajaan penghapusan.

<a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ"><img src="https://user-images.githubusercontent.com/73097560/115834477-dbab4500-a447-11eb-908a-139a6edaec5c.gif"></a>

## 🛠️ Teknologi & Tema UI

### Tech Stack
* **Framework:** Laravel
* **Database:** MySQL
* **Templating:** Laravel Blade
* **Styling:** CSS / Tailwind CSS

### Tema Visual: **Dark & Gold Premium**
* 🌑 *Background:* Midnight Navy (`#0F172A`) & Dark Slate (`#1E293B`)
* ⚪ *Text:* White (`#FFFFFF`) & Slate (`#94A3B8`)
* 🟡 *Accent:* Vibrant Gold (`#FBBF24`)

<a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ"><img src="https://user-images.githubusercontent.com/73097560/115834477-dbab4500-a447-11eb-908a-139a6edaec5c.gif"></a>

## 👨‍💻 Tim Pengembang & Pembagian Tugas

Proyek ini dikembangkan secara kolaboratif oleh tim yang terdiri dari 4 anggota:

1.  **Riel (Core System & Database)**
    * Merancang struktur Database, Migrations, Relasi, dan Soft Deletes.
    * Membangun logika kalkulasi Gamifikasi (EXP/Border Profil).
    * Mengelola sistem pengumpulan tugas (validasi *deadline*) dan *form* penilaian.
2.  **Zaki (UI/UX Layout & Dashboard)**
    * Merancang *layout* antarmuka utama (Navbar dinamis & Sidebar navigasi).
    * Menerapkan palet warna *Dark & Gold* pada seluruh sistem.
    * Membangun tampilan *Dashboard* Beranda dan rekap Daftar Tugas.
3.  **Idan (Autentikasi & Manajemen Kelas)**
    * Menyiapkan sistem Login/Register (Breeze) dan pembatasan hak akses (*Role*).
    * Membangun fitur Dosen membuat kelas (Generate Code) dan Mahasiswa bergabung ke kelas.
    * Mengelola CRUD untuk pembuatan struktur LPP/Pertemuan.
4.  **Ijul (Konten & Interaksi)**
    * Mengelola sistem *upload* materi PDF dan instruksi tugas oleh Dosen.
    * Merakit tampilan detail LPP (menggabungkan materi dan tugas dalam satu halaman).
    * Membangun sistem interaksi *Thread* Diskusi dan Notifikasi sistem.

<a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ"><img src="https://user-images.githubusercontent.com/73097560/115834477-dbab4500-a447-11eb-908a-139a6edaec5c.gif"></a>

## 🚀 Panduan Instalasi (Local Development)

Bagi anggota tim yang ingin menjalankan *project* ini di lokal masing-masing, ikuti langkah berikut:

### Prasyarat
* PHP (>= 8.1 direkomendasikan)
* Composer
* MySQL Server

### Langkah-langkah

1.  **Clone repository ini:**
    ```bash
    git clone [https://github.com/USERNAME_GITHUB/TrunodjoyoClassroom.git](https://github.com/USERNAME_GITHUB/TrunodjoyoClassroom.git)
    ```
2.  **Masuk ke direktori proyek:**
    ```bash
    cd TrunodjoyoClassroom
    ```
3.  **Install dependensi PHP (Composer):**
    ```bash
    composer install
    ```
4.  **Siapkan file environment:**
    Duplikat file `.env.example` dan ubah namanya menjadi `.env`.
    * `cp .env.example .env` (di Linux/Mac)
    * `copy .env.example .env` (di Windows)
    Lalu sesuaikan konfigurasi *database* (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
5.  **Generate App Key:**
    ```bash
    php artisan key:generate
    ```
6.  **Jalankan Migration (Pastikan database lokal sudah dibuat):**
    ```bash
    php artisan migrate
    ```
7.  **Jalankan server lokal:**
    ```bash
    php artisan serve
    ```
    Akses aplikasi di `http://localhost:8000`

---
<p align="center">
  Dibuat dengan ☕ dan 💻 oleh Mahasiswa Teknik Informatika UTM - 2026
</p>
