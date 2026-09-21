# Guidelines for TiketDieng Laravel (webdienglaravel)

## ⚠️ DATABASE SAFETY RULE (CRITICAL & WAJIB)
- **Database berada di Aiven Cloud MySQL (`defaultdb`).**
- **ANGGAP DATABASE INI SEBAGAI DATABASE PRODUKSI!**
- **DILARANG KERAS** menjalankan `php artisan migrate:fresh` atau `migrate:reset`.
- Database ini berisi data riil/aktif: 29 paket tur Dieng, pengaturan situs (`site_settings`), tabel `visitor_stats`, master `comcodes`, tabel roles/permissions, dan akun pengguna.
- Backup database tersimpan lokal di `backup_aiven_amsterdam.sql` (di-ignore oleh git).
- Jika ada penambahan tabel atau kolom baru, **WAJIB** gunakan migrasi inkremental biasa (`php artisan migrate`).

## 🌐 INFRASTRUKTUR & DEPLOYMENT
- **Database Server:** Aiven Cloud MySQL
  - **Host:** `mysql-2c7456c1-isamaulanatantra-d020.c.aivencloud.com`
  - **Port:** `12339` | **DB:** `defaultdb` | **User:** `avnadmin`
  - **Region:** **Asia Pacific** (IP: `168.144.93.27`, Ping latency ~62ms).
- **Deployment Platform:** Vercel (`https://webdieng.vercel.app`)
  - **Live Domains:**
    - Induk: `https://webdieng.vercel.app`
    - Lotus: `https://lotusfotografi.vercel.app`
    - Jeep: `https://jeepdieng.vercel.app`
  - Runtime: Serverless Laravel via `vercel.json` (`vercel-php@0.7.3`).
  - Vercel CLI Token: Tersimpan aman di `~/.config/codex-private/vercel-token.txt` (User: `soulofjava`, Team: `isa-s-projects16`).
  - Vercel mendukung multi-project / preview URL untuk simulasi web anak menggunakan database Aiven yang sama.
- **Optimasi Caching & Latensi:**
  - `SESSION_DRIVER=file` (lokal) / `cookie` (Vercel).
  - `CACHE_STORE=file` (lokal) / `array` (Vercel).
  - `serializable_classes` di `config/cache.php` di-whitelist untuk Model `TourPackage`, `SiteSetting`, dan `Collection` agar tidak terblokir oleh Laravel 11.
  - Query paket beranda di-cache 10 menit via `Cache::remember`, otomatis ter-invalidasi saat `TourPackage` di-save atau di-delete.
  - `recordVisitor()` di-bypass untuk session/IP hash yang sama dalam satu hari agar tidak melakukan query blocking bolak-balik ke cloud.

## 👥 ROLE & PERMISSION (SPATIE)
- Menggunakan package `spatie/laravel-permission`.
- **Dua Tingkatan Role:**
  1. 👑 **`superadmin`** (User: `isamaulanatantra@gmail.com`):
     - Memiliki seluruh permissions: `manage_themes`, `manage_settings`, `manage_users`, `manage_packages`, `manage_comcodes`.
     - Berhak mengubah tema/mode aktif, nomor rekening bank resmi, legalitas PT, dan manajemen user admin.
  2. 👤 **`admin`** (Operasional Unit Bisnis Ter-scoped):
     - `admin@tiketdieng.com` (TiketDieng): Operasional paket tour wisata reguler Dieng.
     - `admin@lotuscreative.id` (Lotus Creative): Operasional paket foto, video reels & drone 4K.
     - `admin@jeepdieng.com` (Ready Jeep Dieng): Operasional paket safari Jeep 4x4 All In.
     - *(Pending)* `admin@shuttledieng.com`: Disiapkan jika web shuttle mulai dikerjakan.
     - Memiliki permissions: `manage_packages`, `manage_comcodes` yang di-scoped per unit. Dilarang ganti tema atau rekening global.
- Middleware Spatie terdaftar di `bootstrap/app.php`: `role`, `permission`, `role_or_permission`.

## 🎨 MULTI-TEMA & MULTI-SITUS (1 DATABASE, MULTI-VIEWS)
- Seluruh unit usaha bernaung di bawah **PT. GOTRIP ASIA TRAVELINDO**:
  1. ✅ **`tiketdieng`** (`tiketdieng.com`) — **SELESAI**: Portal Wisata All-in-One, Homestay, Kalkulator biaya, itinerary sinematik.
  2. ✅ **`lotus`** (`lotuscreative.id`) — **SELESAI**: Lotus Creative — Travel Photography & Aerial Drone 4K (Tieng Kejajar, WA: `08164211196`, BNI: `8166754042`, favicon dinamis).
  3. ✅ **`jeep`** (`jeepdieng.com`) — **SELESAI**: Ready Jeep Dieng — Sewa Jeep Wisata 4x4 Offroad Safari All In (WA: `081325631952`, tema merah rubi/chrome, favicon RD dinamis, paket 1D & Sunrise All In).
  4. ⏳ **`shuttle`** (`shuttledieng.com`) — **BELUM DIBUAT (PENDING / TO DO)**: Layanan Transportasi Mikrobus 15 Seat. **Belum ada data resmi paket/rute/tarif dan tampilan publik Blade belum dibuat**.
- **Konsep Tampilan Beranda (`/`):**
  - Saat dibuka di `/`, halaman berwujud 100% sebagai website yang berbeda sesuai tema aktif (bukan sekadar sub-halaman).
  - Views diisolasi per tema di `resources/views/themes/{tiketdieng,lotus,jeep,shuttle}/`.
  - **Status Blade View Saat Ini:**
    - `themes/tiketdieng/`: Lengkap (`home.blade.php`, `package-detail.blade.php`, partials).
    - `themes/lotus/`: Lengkap (`home.blade.php`, `package-detail.blade.php`, partials).
    - `themes/jeep/`: Lengkap (`home.blade.php`, `package-detail.blade.php`).
    - `themes/shuttle/`: ❌ **Belum dibuat** (hanya placeholder).
  - **Mode Resolver:**
    - Live / Produksi: Otomatis mendeteksi domain (`$request->getHost()`).
    - Lokal / Staging: Dapat diubah langsung dari **Database** oleh `superadmin` di panel CMS, atau via parameter query `?theme={code}`.

## 🚀 GIT WORKFLOW
- **Git Repo:** `https://github.com/soulofjava/webdienglaravel.git`
- **Branch:**
  - Local dev: `dev` (selalu kembangkan fitur di sini).
  - Production: `main` (hanya merge ke main atas instruksi eksplisit user).
- **Aset Frontend:** Selalu jalankan `npm run build` setelah mengubah tampilan Blade baru agar Tailwind utility terkompilasi.
