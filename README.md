# TiketDieng.com — Portal Biro Wisata Resmi (Laravel 13 & MySQL)

Proyek ini merupakan porting mandiri dari portal biro wisata sinematik TiketDieng ke dalam ekosistem **Laravel 13** dan **MySQL**, yang dirancang khusus agar dapat di-hosting dengan sangat mudah, stabil, dan terjangkau di **Hostinger Shared Hosting** atau cPanel manapun **tanpa memerlukan Vercel maupun Supabase**.

---

## 🚀 Keunggulan Versi Laravel

1. **Ukuran Sangat Ringan:** Hanya ~70 MB (bandingkan dengan Next.js yang mencapai 864 MB).
2. **Mandiri & Bebas Pihak Ketiga:**
   - Database MySQL lokal (`webdieng`).
   - Autentikasi Admin bawaan sesi Laravel.
   - Penyimpanan gambar di storage lokal (`public/uploads`).
   - Visitor tracking lokal dengan hashing IP unik harian.
3. **100% Ramah Shared Hosting:** Sekali upload ke cPanel/hPanel Hostinger, langsung jalan tanpa butuh Node.js SSR runtime daemon.

---

## 🔑 Kredensial Login Administrator

* **URL Login:** `http://localhost:8000/admin/login`
* **Email:** `admin@tiketdieng.com`
* **Password:** `admin123`

---

## 🛠️ Modul yang Diporting

### 1. Tampilan Publik Sinematik
* **Floating Navbar:** Brand logo, Dieng live weather HUD (Open-Meteo API), tombol WhatsApp.
* **Multi-layer Hero Parallax:** Fajar emas Sikunir, siluet pegunungan Sindoro & Sumbing, kabut mengambang.
* **Scrollytelling 5 Babak Dieng:**
  1. *BAB 01:* Matahari Pertama di Puncak Sikunir 2.463 mdpl.
  2. *BAB 02:* Napas Hangat Sang Hyang di Kawah Sikidang 2.050 mdpl.
  3. *BAB 03:* Simfoni Zamrud di Telaga Warna & Pengilon 2.000 mdpl.
  4. *BAB 04:* Jejak Peradaban Suci di Lembah Candi Arjuna 2.093 mdpl.
  5. *BAB 05:* Safari Jip 4x4 Offroad Menembus Jalur Perbukitan & Savana.
* **Paket Wisata Unggulan All-Inclusive:** One Day Express, 2D1N Golden Sunrise, 3D2N Ultimate Odyssey, Safari Jip 4x4.
* **Standar Layanan VIP (Why Us):** Pemandu lokal HPI, dokumentasi drone gratis, tiket VIP tanpa antre, kuliner khas.
* **Smart Booking Engine & Simulator Biaya:** Perhitungan otomatis peserta, surcharge titik jemput, diskon rombongan, dan format pesan instan ke WhatsApp resmi.
* **Testimoni Wisatawan:** Review asli wisatawan terverifikasi.
* **Visitor Counter Publik:** Statistik transparan pengunjung (hari ini, kemarin, minggu ini, bulan ini, total).
* **Footer Sinematik & Legalitas:** NIB, HPI Badge, dan peta lokasi kantor.

### 2. Panel Pengelola Admin (`/admin`)
* **Ringkasan Traffic MySQL:** Menampilkan total kunjungan, hits hari ini, dan pengunjung unik harian.
* **Kartu 1: Identitas Situs Web:** Nama jenama, tagline, dan upload favicon.
* **Kartu 2: Saluran Komunikasi & Reservasi:** WhatsApp reservasi, nomor telepon, dan email resmi.
* **Kartu 3: Alamat & Legalitas Usaha:** Alamat kantor, NIB perizinan usaha, dan lencana HPI.
* **Kartu 4: Optimasi SEO & Sosial Media:**
  - Google Meta Title & Meta Description dengan penghitung karakter ideal.
  - Target Keywords.
  - Upload Banner OG Image (media sosial / WhatsApp share card).
  - **Live Visual Preview:** Pratinjau tampilan di Google SERP dan Kartu Berbagi WhatsApp yang terupdate seketika saat diketik.
* **Fitur Kembalikan Pengaturan Awal (Reset to Default).**

---

## 💻 Cara Menjalankan di Lokal

```bash
cd /Users/isamaulana/Downloads/proyek/webdienglaravel
php artisan serve
```
Akses di browser: `http://localhost:8000`
