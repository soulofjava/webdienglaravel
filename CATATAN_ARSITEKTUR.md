# 🏔️ CATATAN ARSITEKTUR & PANDUAN PROYEK (TIKETDIENG MULTI-SITE)

> **Dokumen ini adalah referensi resmi arsitektur sistem, koneksi database, platform deployment, dan alur multi-site untuk pengembang dan agen AI di semua sesi.**

---

## 📌 1. INFORMASI DASAR PROYEK & DEPLOYMENT

* **Repositori Git:** `https://github.com/soulofjava/webdienglaravel.git`
* **Branch Workflow:**
  * `dev` : Branch aktif untuk pengembangan lokal (*local development*).
  * `main` : Branch produksi tunggal (*single production branch*) yang dideploy ke hosting.
* **Platform Hosting / Deployment:**
  * **Vercel** (Serverless Laravel via runtime `vercel-php@0.7.3` & file konfigurasi `vercel.json`).
  * Aset frontend dibuild menggunakan **Vite** (`npm run build` -> `public/build/`).
  * Caching di Vercel diarahkan ke `/tmp/` (`APP_CONFIG_CACHE`, `VIEW_COMPILED_PATH`, dll.).
* **Database Server:**
  * **Aiven Cloud MySQL**
  * **Host:** `mysql-2c7456c1-isamaulanatantra-d020.c.aivencloud.com`
  * **Port:** `12339`
  * **Database:** `defaultdb`
  * **User:** `avnadmin`
  * **SSL Mode:** `REQUIRED`

---

## ⚠️ 2. ATURAN KESELAMATAN DATABASE (PENTING & WAJIB DIPATUHI)

> ### 🛑 JANGAN PERNAH MENJALANKAN `php artisan migrate:fresh` ATAU `migrate:reset`!
> 
> * Database di **Aiven Cloud** saat ini **DIANGGAP SEBAGAI DATABASE PRODUKSI**.
> * Database ini **SUDAH BERISI DATA RIIL/AKTIF** (puluhan paket wisata `tour_packages`, data `site_settings`, akun pengguna, dan log).
> * Jika ada perubahan skema database di masa mendatang:
>   * **HANYA gunakan migrasi inkremental** (`ALTER TABLE` / tambah kolom baru melalui migrasi baru).
>   * **DILARANG KERAS** melakukan tindakan yang menghapus (*drop*) tabel atau mereset data yang sudah ada.

---

## 🏢 3. ENTIKAS BISNIS & PEMETAAN 4 SITUS (MULTI-SITE)

Seluruh unit bisnis bernaung di bawah legalitas perusahaan induk **PT. GOTRIP ASIA TRAVELINDO** (Wonosobo). Sistem ini menggunakan **1 Codebase & 1 Database** untuk melayani **1 Web Induk + 3 Sub-Web**:

```
                  ┌─────────────────────────────────────────┐
                  │    PT. GOTRIP ASIA TRAVELINDO (Induk)   │
                  └────────────────────┬────────────────────┘
                                       │
         ┌─────────────────────────────┼─────────────────────────────┐
         ▼                             ▼                             ▼
┌──────────────────┐          ┌──────────────────┐          ┌──────────────────┐
│  Shuttle Dieng   │          │    Jeep Dieng    │          │Dokumentasi Dieng │
│ (Transportasi 15)│          │ (Travelbuddies)  │          │ (Lotus Creative) │
└──────────────────┘          └──────────────────┘          └──────────────────┘
```

### Rincian Profil Setiap Web:

| No | Web | Brand / Layanan | Karakteristik Produk & Target | Kontak & Identitas |
|:--:|---|---|---|---|
| **1** | **Web Induk** | **`tiketdieng.com`** *(Tiket Wisata Dieng)* | **Portal All-in-One**: Paket tour lengkap (1D, 2D1N, 3D2N), akomodasi homestay/villa, simulator biaya wisata (kalkulator), dan etalase induk seluruh sub-layanan. | WA: `0816675404`<br>Email: `tiket.wisatadieng@gmail.com`<br>Tema: *Cinematic Parallax Dark & Gold* |
| **2** | **Sub-Web 1** | **Shuttle Dieng** | **Transportasi Rombongan**: Sewa mikrobus (kapasitas 15 orang dewasa), antar-jemput stasiun/bandara, tour keliling Dieng untuk keluarga/instansi (Paket 1–5). | WA: `0816675404`<br>Tema: *Clean, Reliable & Professional Travel* |
| **3** | **Sub-Web 2** | **Jeep Dieng** *(Dieng Travelbuddies)* | **Safari 4x4 & Adrenalin**: Armada Jeep offroad Feroza/Katana (4 pax), rute Sunrise (Sikunir, Pintu Langit) dan rute ekstrem (Sikarim, Dringo, Bedakah). | WA: `0816675404`<br>Tema: *Adventurous, Bold & Earthy (Orange/Amber)* |
| **4** | **Sub-Web 3** | **Dokumentasi Dieng** *(Lotus Creative)* | **Fotografi & Videografi Wisata**: Fotografer pro DSLR/mirrorless, reels cinematic, dan drone 4K (Paket 1–5, mulai Rp 500rb s/d Rp 2.5jt). | WA: `08164211196`<br>Email: `lotuscreative465@gmail.com`<br>Tema: *Portfolio Visual, Modern Gallery (Cyan/Red)* |

---

## 🛠️ 4. ARSITEKTUR IMPLEMENTASI (SINGLE CODEBASE MULTI-TENANT)

### A. Database Design
1. **Tabel `sites` (Tenant Registry)**:
   * Menyimpan metadata per web: `id`, `slug`, `domain`, `name`, `tagline`, `theme`, `whatsapp_number`, `email`, `address`, `logo_url`, `seo_title`, `seo_description`.
2. **Kolom `site_id` pada Tabel Data**:
   * `tour_packages` : Memiliki kolom `site_id` (1: TiketDieng, 2: Shuttle, 3: Jeep, 4: Lotus).
   * `visitor_logs` / `visitor_stats` : Memiliki kolom `site_id` agar analitik per situs terisolasi rapi.
   * `site_settings` : Menggunakan relasi `site_id` atau terintegrasi ke tabel `sites`.

### B. Deteksi Domain & Dinamisasi Blade (View Prepend)
1. **Middleware `IdentifySiteMiddleware`**:
   * Membaca hostname request: `$host = $request->getHost();`.
   * Mencocokkan dengan data tabel `sites`:
     ```php
     $site = Site::where('domain', $host)->first() ?? Site::find(1); // fallback ke tiketdieng
     app()->instance('currentSite', $site);
     View::prependLocation(resource_path("views/themes/{$site->theme}"));
     ```
2. **Struktur Folder Views**:
   ```text
   resources/views/
   ├── themes/
   │   ├── tiketdieng/          <-- Tampilan khusus TiketDieng (Parallax, Scrollytelling)
   │   │   ├── layouts/app.blade.php
   │   │   ├── home.blade.php
   │   │   └── package-detail.blade.php
   │   ├── shuttle/             <-- Tampilan khusus Shuttle Dieng
   │   │   ├── layouts/app.blade.php
   │   │   └── home.blade.php
   │   ├── jeep/                <-- Tampilan khusus Jeep Dieng (Travelbuddies)
   │   │   ├── layouts/app.blade.php
   │   │   └── home.blade.php
   │   └── lotus/               <-- Tampilan khusus Lotus Creative (Portfolio foto & drone)
   │       ├── layouts/app.blade.php
   │       └── home.blade.php
   ├── shared/                  <-- Komponen bersama (modal WA, scripts, icons)
   └── admin/                   <-- Single unified admin panel untuk semua web
   ```
3. **Penyaringan Data Otomatis**:
   * Model `TourPackage` menggunakan Global Scope `site_id = app('currentSite')->id` saat diakses publik.
   * Di Web Induk (`tiketdieng.com`), paket dari sub-layanan lain dapat di-bundling atau ditampilkan sebagai rekomendasi mitra resmi.

### C. Panel Admin Terpadu (Single Dashboard)
* Admin hanya memiliki 1 URL login (`/admin/login`).
* Di header dashboard tersedia dropdown pemilih situs: `[ Kelola Web: TiketDieng.com ▾ ]`.
* Mengganti pilihan situs akan memfilter paket wisata, statistik pengunjung, dan pengaturan kontak sesuai web yang dipilih.

---

## 📋 5. KREDENSIAL PENGUJIAN LOKAL
* **Server Lokal:** `http://localhost:8000` (`php artisan serve`)
* **Admin Login:** `http://localhost:8000/admin/login`
* **Email:** `admin@tiketdieng.com`
* **Password:** `admin123`
