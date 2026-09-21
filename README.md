# TiketDieng.com — Multi-Site & Multi-Theme Portal (Laravel 13 & MySQL)

Proyek ini merupakan portal pariwisata multi-site, multi-tema, dan single database untuk seluruh unit usaha di bawah naungan **PT. GOTRIP ASIA TRAVELINDO** (Wonosobo).

---

## 🏢 Status 4 Unit Bisnis (Multi-Site)

| Unit Bisnis | Domain | Status Implementasi | Deskripsi & Konsep |
| :--- | :--- | :---: | :--- |
| **TiketDieng** | `tiketdieng.com` | ✅ **SELESAI** | Portal Induk: Paket tour lengkap all-inclusive, homestay, itinerary, dan simulator biaya. |
| **Lotus Creative** | `lotuscreative.id` | ✅ **SELESAI** | Studio Visual: Travel photography, cinematic video reels & aerial drone 4K Dieng. |
| **Ready Jeep Dieng** | `jeepdieng.com` | ✅ **SELESAI** | Petualangan Offroad 4x4 (All In): 5 Paket Tur 1 Hari & 5 Paket Sunrise Safari (Jeep, BBM, Driver, Tiket Masuk, Dokumentasi HP). |
| **Shuttle Dieng** | `shuttledieng.com` | ⏳ **BELUM DIBUAT**<br>*(Pending Data)* | Transportasi Mikrobus 15 Seat. **Status: Belum ada data resmi paket/rute/tarif & tampilan publik Blade belum dibuat.** |

---

## 🚀 Keunggulan Sistem Multi-Site

1. **Single Database, Multi-View:** Satu database MySQL melayani 4 domain/tema independen.
2. **Distinct Homepage:** Setiap tema memiliki desain, atmosfer warna, dan layout publik tersendiri di `resources/views/themes/{tiketdieng,lotus,jeep,shuttle}/`.
3. **Role Scoping (Spatie):** Admin operasional masing-masing unit hanya dapat mengelola paket dan profil situs unitnya sendiri.
4. **Favicon Dinamis:** Masing-masing web otomatis memuat favicon ikon resmi per tema (Tiket, Lotus, Ready Jeep Dieng).

---

## 🔑 Kredensial Login Administrator Panel (`/admin`)

* **URL Login:** `http://localhost:8000/admin/login`
* **Superadmin:** `isamaulanatantra@gmail.com` (Akses Penuh / Ganti Tema)
* **Admin TiketDieng:** `admin@tiketdieng.com` (Operasional Tour & Homestay)
* **Admin Lotus Creative:** `admin@lotuscreative.id` (Operasional Foto & Drone)
* **Admin Ready Jeep Dieng:** `admin@jeepdieng.com` (Operasional Safari Jeep 4x4 All In)
* **Admin Shuttle Dieng:** *(Pending - Menunggu implementasi web shuttle)*

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
