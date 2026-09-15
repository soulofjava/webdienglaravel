# Guidelines for TiketDieng Laravel (webdienglaravel)

## ⚠️ DATABASE SAFETY RULE (CRITICAL)
- **Database saat ini berada di Aiven Cloud MySQL (`defaultdb`).**
- **ANGGAP DATABASE INI SEBAGAI DATABASE PRODUKSI!**
- **DILARANG KERAS** menjalankan `php artisan migrate:fresh` atau `migrate:reset`. Data riil sudah ada di dalam database (29 paket tour, site settings, dll.).
- Jika ada penambahan kolom / tabel baru, **WAJIB** gunakan migrasi inkremental (`ALTER TABLE`) tanpa menghapus data.

## 📌 PROJECT ARCHITECTURE & MULTI-SITE
- **Arsitektur Lengkap:** Baca rincian di file [`CATATAN_ARSITEKTUR.md`](./CATATAN_ARSITEKTUR.md).
- **Proyek:** TiketDieng Multi-Site (1 Web Induk + 3 Sub-Web di bawah PT GOTRIP ASIA TRAVELINDO):
  1. `tiketdieng.com` (Induk - All-inclusive tour, homestay, kalkulator)
  2. Shuttle Dieng (Mikrobus rombongan 15 pax)
  3. Jeep Dieng / Dieng Travelbuddies (Jeep 4x4 offroad safari)
  4. Dokumentasi Dieng / Lotus Creative (Fotografi, video reels, drone 4K)
- **Pola Multi-Tenant:**
  - 1 Codebase, 1 branch `main` untuk deploy ke Vercel.
  - Deteksi web berdasarkan domain via Middleware.
  - Tabel `sites` dan kolom `site_id` pada tabel data (`tour_packages`, `visitor_logs`).
  - Dinamisasi tema Blade via `View::prependLocation(resource_path("views/themes/{$site->theme}"))`.
  - 1 Panel Admin bersama (`/admin`) dengan dropdown switcher situs.

## 🚀 DEPLOYMENT & GIT WORKFLOW
- **Git Repo:** `https://github.com/soulofjava/webdienglaravel.git`
- **Branch:**
  - Local dev: `dev`
  - Production: `main` (hanya merge ke main atas instruksi eksplisit user)
- **Deployment Platform:** Vercel (Serverless Laravel via `vercel.json` runtime `vercel-php@0.7.3`).
- **Aset Frontend:** Vite (`npm run build` sebelum deploy).
