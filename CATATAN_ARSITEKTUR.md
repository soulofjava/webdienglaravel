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
3. **Fitur Impersonate / Login As (`AdminUserController.php`)**:
   - **Tujuan**: Memungkinkan Superadmin menguji atau mengelola sistem dari sudut pandang admin sub-web (`admin@tiketdieng.com`, `admin@lotuscreative.id`) di browser yang sama tanpa perlu logout atau membuka incognito/browser lain.
   - **Mekanisme**:
     - Route `POST /admin/users/{user}/impersonate` menyimpan `impersonator_id` di session dan mengotentikasi sebagai target admin.
     - Sticky Alert Banner mengambang di bagian paling atas seluruh halaman sistem (`layouts/app.blade.php`) memberi tahu identitas akun yang sedang diimpersonasi.
     - Tombol **"Kembali ke Superadmin"** (`POST /admin/leave-impersonate`) dapat diklik kapan saja untuk mengembalikan sesi login ke akun Superadmin asli dan membersihkan penanda session.
     - Dilengkapi proteksi berlapis: anti-impersonasi berantai, larangan impersonasi akun sendiri, dan verifikasi role Superadmin.
4. **Multi-Tenant Master Data (Comcodes) & Usage Guard (`AdminComcodeController.php`)**:
   - **Tujuan**: Membebaskan developer/superadmin dari kerepotan manual setiap kali klien/pengelola unit ingin membuat kategori atau badge baru, sekaligus mencegah admin antar-unit saling merusak atau menghapus data kategori satu sama lain.
   - **Multi-Tenant Scoping (`site_scope`)**:
     - Tabel `comcodes` dilengkapi kolom `site_scope` (`global`, `tiketdieng`, `lotus`, `jeep`, `shuttle`).
     - Admin Lotus (`admin@lotuscreative.id`) saat menambah kategori/badge baru otomatis terdaftar dengan `site_scope = 'lotus'` dan hanya berhak mengedit/menghapus master kodenya sendiri.
     - Admin TiketDieng (`admin@tiketdieng.com`) hanya berhak mengelola master kodenya sendiri (`site_scope = 'tiketdieng'`).
     - Master kode umum bertaraf `global` (misal titik jemput dan durasi bersama) berstatus **Terkunci** (read-only) bagi admin sub-web dan hanya dapat diubah/dihapus oleh Superadmin.
     - Kategori yang tersedia saat create/edit paket wisata (`getAllowedPackageCategories()`) ditarik dinamis dari `Comcode` berdasarkan `site_scope`.
   - **Usage Guard (Proteksi Anti-Hapus)**:
     - Method `Comcode::countUsedPackages()` menghitung secara riil referensi master kode pada kolom `category`, `badge`, `duration`, dan `pickup_location` di seluruh tabel paket wisata.
     - Jika sebuah master kode sedang digunakan oleh $\ge 1$ paket aktif, tombol Hapus digantikan oleh badge gembok proteksi dan controller menolak keras penghapusan demi menjaga integritas relasi data di portal.
5. **Fitur Logout Otomatis / Inactivity Timeout Guard (`EnforceInactivityTimeout.php`)**:
   - **Standar Keamanan**: Berbasis standar perbankan / OWASP (batas inaktivitas 15 menit = 900 detik).
   - **Mekanisme Berlapis (Defense in Depth)**:
     - **Client-Side Guard (`inactivity-guard.blade.php`)**: Memantau interaksi mouse, keyboard, touch, dan scroll. Pada menit ke-13 (2 menit sebelum timeout), modal peringatan keamanan interaktif muncul dengan hitung mundur digital (02:00 -> 00:00).
     - **Interaksi Pengguna**: Tombol "Tetap Masuk" mengirimkan ping keepalive AJAX (`POST /admin/session-keepalive`) untuk memperpanjang masa aktif sesi tanpa perlu me-reload halaman.
     - **Auto-Logout**: Jika waktu countdown habis (00:00), form logout dieksekusi otomatis dan diarahkan ke `/admin/login` dengan pesan flash status.
     - **Server-Side Middleware (`EnforceInactivityTimeout`)**: Memvalidasi selisih waktu `last_activity_time` pada setiap request rute admin. Jika sesi ditinggalkan tanpa koneksi atau browser ditutup, server otomatis memutus sesi dan menghancurkan token autentikasi.

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
6. **Strategi Database Indexing Komprehensif (Zero Filesort & Covering Indexes):**
   - **Tabel `tour_packages`**:
     - `idx_tp_category_sort_id` (`category`, `sort_order`, `id`): Menghilangkan full-table scan pada listing paket admin per kategori dan filter tenant.
     - `idx_tp_sort_id` (`sort_order`, `id`): Menjamin urutan sorting paket stabil dan cepat saat pagination.
     - `idx_tp_badge`, `idx_tp_duration`, `idx_tp_pickup_location`: Mengubah 30+ query `countUsedPackages()` (Usage Guard) menjadi *Covering Index Scans* tanpa menyentuh data tabel fisik.
     - `idx_tp_active_popular_sort` (`is_active`, `is_popular`, `sort_order`): Menghilangkan `filesort` pada query paket populer dan rekomendasi spotlight search publik.
     - `idx_tp_active_category_sort` (`is_active`, `category`, `sort_order`): Mengoptimalkan filter kategori di beranda publik.
   - **Tabel `comcodes`**:
     - `idx_comcodes_group_active_sort_name` (`code_group`, `is_active`, `sort_order`, `code_name`): Menghilangkan `filesort` pada pemuatan dropdown form paket dan helper `Comcode::getGroup()`.
     - `idx_comcodes_scope_group_sort` (`site_scope`, `code_group`, `sort_order`, `code_name`): Mempercepat dashboard master kode multi-tenant.
     - `idx_comcodes_group_scope_active` (`code_group`, `site_scope`, `is_active`): Mempercepat resolusi izin kategori di `User::getAllowedPackageCategories()`.
     - `idx_comcodes_code_value` (`code_value`): Menjamin lookup nilai teknis kode berlangsung seketika (*O(1)*).

---

## 📋 7. KREDENSIAL PENGUJIAN LOKAL

* **Server Lokal:** `http://localhost:8000` (`php artisan serve`)
* **Admin Login:** `http://localhost:8000/admin/login`
* **Akun Superadmin (Global Bypass & Developer):**
  * Email: `isamaulanatantra@gmail.com`
  * Role: `superadmin`
* **Akun Admin TiketDieng (Scope Paket Wisata):**
  * Email: `admin@tiketdieng.com`
  * Role: `admin` (Standard Enterprise Security Password)
* **Akun Admin Lotus Creative (Scope Dokumentasi/Fotografi):**
  * Email: `admin@lotuscreative.id`
  * Role: `admin` (Standard Enterprise Security Password)
