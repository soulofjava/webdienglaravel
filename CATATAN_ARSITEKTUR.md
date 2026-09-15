# 🏔️ CATATAN ARSITEKTUR & PANDUAN PROYEK (TIKETDIENG MULTI-SITE)

> **Dokumen ini adalah referensi resmi arsitektur sistem, infrastruktur database Aiven, integrasi Vercel, hak akses Role Spatie, dan alur Multi-Tema untuk pengembang serta agen AI di seluruh sesi.**

---

## 📌 1. INFORMASI DASAR PROYEK & INFRASTRUKTUR

* **Repositori Git:** `https://github.com/soulofjava/webdienglaravel.git`
* **Branch Workflow:**
  * `dev` : Branch aktif untuk pengembangan lokal (*local development*).
  * `main` : Branch produksi tunggal (*single production branch*) yang dideploy ke hosting.
* **Platform Hosting / Deployment:**
  * **Vercel** (Serverless Laravel via runtime `vercel-php@0.7.3` & file konfigurasi `vercel.json`).
  * Production URL: `https://webdieng.vercel.app`
  * Vercel Account: `soulofjava`, Active Team: `isa-s-projects16 (isa's projects)`.
  * Token Akses Vercel CLI tersimpan aman di `~/.config/codex-private/vercel-token.txt`.
  * Aset frontend dibuild menggunakan **Vite** (`npm run build` -> `public/build/`).
* **Database Server:**
  * **Aiven Cloud MySQL**
  * **Host:** `mysql-2c7456c1-isamaulanatantra-d020.c.aivencloud.com`
  * **Port:** `12339` | **DB:** `defaultdb` | **User:** `avnadmin`
  * **Region:** **Asia Pacific** (IP: `168.144.93.27`, Datacenter DigitalOcean Bengaluru / Asia).
  * **Latency Jaringan:** Turun dari ~193ms (eks-Amsterdam) menjadi **~62ms** dengan SSL Mode `REQUIRED`.

---

## ⚠️ 2. ATURAN KESELAMATAN DATABASE (PENTING & WAJIB DIPATUHI)

> ### 🛑 JANGAN PERNAH MENJALANKAN `php artisan migrate:fresh` ATAU `migrate:reset`!
> 
> * Database di **Aiven Cloud** saat ini **DIANGGAP SEBAGAI DATABASE PRODUKSI**.
> * Database ini **SUDAH BERISI DATA RIIL/AKTIF** (29 paket tur lengkap, itinerary, foto, data `site_settings`, akun user, dan tabel permission).
> * Backup database lokal tersimpan di file `backup_aiven_amsterdam.sql` (85.9 KB, gitignored).
> * Jika ada perubahan skema database di masa mendatang:
>   * **HANYA gunakan migrasi inkremental biasa** (`php artisan migrate` atau `ALTER TABLE` melalui file migrasi baru).
>   * **DILARANG KERAS** melakukan tindakan yang menghapus (*drop*) tabel atau mereset data yang sudah ada.

---

## 🏢 3. ENTIKAS BISNIS & PEMETAAN 4 SITUS (MULTI-SITE)

Seluruh unit bisnis bernaung di bawah legalitas resmi **PT. GOTRIP ASIA TRAVELINDO** (Wonosobo). Sistem ini menggunakan **1 Codebase & 1 Database Bersama** untuk melayani **1 Web Induk + 3 Sub-Web**:

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
| **4** | **Sub-Web 3** | **Dokumentasi Dieng** *(Lotus Creative)* | **Fotografi & Videografi Wisata**: Fotografer pro DSLR/mirrorless, reels cinematic, dan drone 4K (Paket 1–5, Rp 500rb s/d Rp 2.5jt). Studio: Tieng, Kejajar. | WA: `08164211196`<br>Email: `lotuscreative465@gmail.com`<br>Rekening: BNI 8166754042<br>Tema: *Visual Studio (Cyan & Rose)* |

---

## 🎨 4. ARSITEKTUR MULTI-TEMA (TOTAL DISTINCT HOMEPAGE)

### A. Konsep Beranda (`/`)
Ketika pengunjung mengakses URL beranda (`http://localhost:8000/` atau domain live), **tampilannya benar-benar website yang berbeda total**, bukan sekadar sub-halaman:
- Mode **TiketDieng**: Beranda adalah portal biro wisata all-inclusive.
- Mode **Lotus Creative**: Beranda adalah website studio dokumentasi & drone Lotus Creative seutuhnya.
- Mode **Jeep**: Beranda adalah website armada rental jeep wisata offroad.
- Mode **Shuttle**: Beranda adalah website sewa mikrobus 15 kursi.

### B. Struktur Folder Views (`resources/views/themes/`)
```text
resources/views/
├── themes/
│   ├── tiketdieng/               <-- Web Induk (TiketDieng)
│   │   ├── layouts/app.blade.php
│   │   ├── home.blade.php
│   │   ├── package-detail.blade.php
│   │   └── partials/
│   ├── lotus/                    <-- Web Lotus Creative
│   │   ├── layouts/app.blade.php
│   │   ├── home.blade.php
│   │   ├── package-detail.blade.php
│   │   └── partials/
│   ├── jeep/                     <-- Web Jeep Dieng
│   │   └── home.blade.php
│   └── shuttle/                  <-- Web Shuttle Dieng
│       └── home.blade.php
├── admin/                        <-- Single Master CMS Dashboard
└── shared/                       <-- Komponen bersama (modal WA, scripts)
```

### C. Mekanisme Penentuan Mode Aktif (Hierarki Resolusi)
1. **Prioritas 1 (Live / Production Domain)**:
   Membaca `$request->getHost()`. Domain `lotuscreative.id` otomatis merender tema `lotus`; `tiketdieng.com` merender tema `tiketdieng`.
2. **Prioritas 2 (Pengaturan Database / CMS)**:
   Superadmin dapat mengganti tema aktif untuk localhost/staging langsung dari panel admin tanpa menyentuh file konfigurasi/kode.
3. **Prioritas 3 (Parameter URL Pengujian Cepat)**:
   Akses `?theme=lotus` atau `?theme=tiketdieng` untuk preview instan.

---

## 👥 5. ROLE & PERMISSIONS (SPATIE PERMISSION + SUB-WEB SCOPING)

Aplikasi menerapkan kontrol hak akses bertingkat dengan pemisahan wewenang operasional antar unit bisnis (Multi-Tenant Scoping):

| Role | Scope Unit | Email Akun | Wewenang & Batasan Akses |
| :--- | :--- | :--- | :--- |
| 👑 **`superadmin`** | **Global (Semua Unit)** | `isamaulanatantra@gmail.com` | **Full Bypass & Master Access**:<br>• Akses seluruh 29 paket wisata & dokumentasi tanpa batasan.<br>• Mengatur mode multi-situs dan beralih tema aktif (tiketdieng, lotus, jeep, shuttle).<br>• Mengatur legalitas PT, rekening bank resmi, dan manajemen user pengelola.<br>• Mengakses seluruh tab pengaturan situs. |
| 👤 **`admin`** | **TiketDieng** (`tiketdieng`) | `admin@tiketdieng.com` | **Operasional Tur & Paket Wisata**:<br>• Hanya dapat mengelola paket tur wisata (kategori non-`Dokumentasi`).<br>• Hanya dapat mengakses tab Pengaturan Situs TiketDieng.<br>• Ditolak (`403 Forbidden`) jika mencoba mengedit atau memanipulasi paket Lotus Creative / pengaturan unit lain. |
| 👤 **`admin`** | **Lotus Creative** (`lotus`) | `admin@lotuscreative.id` | **Operasional Fotografi & Dokumentasi**:<br>• Hanya dapat mengelola paket foto/video/drone (kategori `Dokumentasi`).<br>• Hanya dapat mengakses tab Pengaturan Situs Lotus Creative.<br>• Ditolak (`403 Forbidden`) jika mencoba mengedit atau memanipulasi paket tur TiketDieng / pengaturan unit lain. |

### Mekanisme Keamanan Scoping:
1. **Model Scope Helper (`app/Models/User.php`)**:
   - `isSuperAdmin()`: Mengecek role `superadmin`.
   - `getSiteScope()`: Mengembalikan `'lotus'` untuk domain/akun Lotus, `'tiketdieng'` untuk TiketDieng, dan `null` (global) untuk Superadmin.
   - `canManagePackage(TourPackage $package)`: Memverifikasi kesesuaian kategori paket dengan scope akun.
   - `canManageSite(string $siteKey)`: Memverifikasi wewenang admin terhadap konfigurasi situs yang dituju.
2. **Controller Hardening (`AdminPackageController.php` & `AdminSettingController.php`)**:
   - Query `index()` otomatis memfilter daftar paket sesuai unit masing-masing.
   - Operasi `create`, `store`, `edit`, `update`, dan `destroy` memvalidasi kategori paket. Pelanggaran batas unit menghasilkan respons `403 Forbidden`.
   - Akses tab dan update setting situs diisolasi ketat sesuai unit masing-masing.

---

## ⚡ 6. OPTIMASI PERFORMA & CACHING

1. **Pengalihan Driver Database ke File / In-Memory:**
   - `.env` lokal: `SESSION_DRIVER=file` dan `CACHE_STORE=file`.
   - Vercel env: `SESSION_DRIVER=cookie` dan `CACHE_STORE=array`.
   - Menghindari 4–6 query serial bolak-balik ke cloud Aiven per request.
2. **Cache Whitelist:**
   - Di `config/cache.php`, parameter `serializable_classes` di-whitelist untuk class `TourPackage`, `SiteSetting`, dan `Collection` guna mencegah `__PHP_Incomplete_Class` pada Laravel 11+.
3. **Caching Paket Tur:**
   - Data paket beranda dan detail di-cache 10 menit via `Cache::remember`.
   - Di model `TourPackage::boot()`, event hook `saved` dan `deleted` otomatis menghapus cache saat data paket diubah di CMS.
4. **Optimasi Visitor Tracking:**
   - `recordVisitor()` di-bypass jika visitor telah memiliki cookie session aktif atau hash IP tercatat hari ini, sehingga menghemat 5 query blocking per reload.
5. **Hasil Benchmark:**
   - TTFB Beranda turun dari **~6.5 detik** menjadi **~0.047 detik (47 ms)** ⚡.

---

## 📋 7. KREDENSIAL PENGUJIAN LOKAL

* **Server Lokal:** `http://localhost:8000` (`php artisan serve`)
* **Admin Login:** `http://localhost:8000/admin/login`
* **Akun Superadmin (Global Bypass):**
  * Email: `isamaulanatantra@gmail.com`
  * Password: `superadmin123` *(Role: `superadmin`)*
* **Akun Admin TiketDieng (Scope Paket Wisata):**
  * Email: `admin@tiketdieng.com`
  * Password: `admin123` *(Role: `admin`)*
* **Akun Admin Lotus Creative (Scope Dokumentasi/Fotografi):**
  * Email: `admin@lotuscreative.id`
  * Password: `lotusadmin123` *(Role: `admin`)*
