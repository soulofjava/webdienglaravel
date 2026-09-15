@auth
<div
    id="inactivityModal"
    class="fixed inset-0 z-[9999] bg-black/85 backdrop-blur-md flex items-center justify-center p-4 hidden select-none transition-all duration-300"
    role="dialog"
    aria-modal="true"
    aria-labelledby="inactivityModalTitle"
>
    <div class="glass-panel bg-[#0b101c] border border-amber-500/40 rounded-3xl max-w-md w-full p-6 sm:p-7 space-y-5 shadow-2xl shadow-amber-500/10 text-center relative animate-in fade-in zoom-in-95 duration-200">
        <!-- Ikon Peringatan Animasi Denyut -->
        <div class="w-16 h-16 rounded-2xl bg-amber-500/15 border border-amber-500/40 flex items-center justify-center text-amber-400 mx-auto shadow-lg shadow-amber-500/20 relative">
            <span class="absolute inset-0 rounded-2xl bg-amber-400/20 animate-ping opacity-75"></span>
            <i data-lucide="shield-alert" class="w-8 h-8 relative z-10"></i>
        </div>

        <!-- Teks Informasi -->
        <div class="space-y-2">
            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-amber-500/20 text-amber-300 border border-amber-500/40">
                Security Timeout Guard
            </span>
            <h3 id="inactivityModalTitle" class="font-serif text-lg sm:text-xl font-bold text-white tracking-wide">
                Sesi Anda Segera Berakhir
            </h3>
            <p class="text-xs text-slate-300 leading-relaxed max-w-xs mx-auto">
                Tidak ada aktivitas terdeteksi dalam 13 menit terakhir. Demi menjaga keamanan akun Anda, sistem akan menutup sesi ini dalam:
            </p>
        </div>

        <!-- Countdown Timer Digital -->
        <div class="py-3 px-4 rounded-2xl bg-black/40 border border-white/10 max-w-[200px] mx-auto">
            <div id="inactivityCountdown" class="font-mono text-3xl sm:text-4xl font-black text-amber-400 tracking-wider">
                02:00
            </div>
            <span class="text-[10px] text-slate-400 uppercase tracking-widest font-semibold block mt-0.5">
                Menit : Detik
            </span>
        </div>

        <!-- Tombol Aksi -->
        <div class="grid grid-cols-2 gap-3 pt-2">
            <!-- Form Logout Saat Ini -->
            <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                @csrf
                <button
                    type="submit"
                    class="w-full py-2.5 px-4 rounded-xl text-xs font-semibold text-rose-300 hover:text-white bg-rose-500/10 hover:bg-rose-500/25 border border-rose-500/30 transition-all cursor-pointer"
                >
                    Keluar Sekarang
                </button>
            </form>

            <!-- Tombol Perpanjang Sesi -->
            <button
                type="button"
                id="btnExtendSession"
                class="w-full py-2.5 px-4 rounded-xl text-xs font-bold text-black bg-gradient-to-r from-amber-400 via-amber-300 to-amber-500 hover:from-amber-300 hover:to-amber-400 shadow-md shadow-amber-500/25 transition-all cursor-pointer flex items-center justify-center gap-1.5"
            >
                <i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i>
                <span>Tetap Masuk</span>
            </button>
        </div>
    </div>
</div>

<!-- Form Logout Tersembunyi Otomatis -->
<form id="autoLogoutForm" action="{{ route('logout') }}" method="POST" class="hidden">
    @csrf
</form>

<script>
(function() {
    // Konfigurasi Batas Waktu (Standar Industri: 15 Menit = 900 Detik)
    const TOTAL_TIMEOUT_SEC = 15 * 60; // 900 detik
    const WARNING_BEFORE_SEC = 2 * 60; // Peringatan 2 menit (120 detik) sebelum logout
    const WARNING_TRIGGER_SEC = TOTAL_TIMEOUT_SEC - WARNING_BEFORE_SEC; // Muncul di detik 780 (menit ke-13)

    let lastActivityTime = Date.now();
    let isWarningOpen = false;
    let countdownRemaining = WARNING_BEFORE_SEC;
    let countdownInterval = null;
    let keepaliveThrottleTime = 0;

    const modal = document.getElementById('inactivityModal');
    const countdownEl = document.getElementById('inactivityCountdown');
    const btnExtend = document.getElementById('btnExtendSession');
    const autoLogoutForm = document.getElementById('autoLogoutForm');

    // Update aktivitas pengguna jika modal BELUM terbuka
    function recordUserActivity() {
        if (isWarningOpen) return;

        lastActivityTime = Date.now();

        // Ping keepalive ke server tiap 5 menit saat ada aktivitas untuk mencegah session server timeout di tengah kerja aktif
        const now = Date.now();
        if (now - keepaliveThrottleTime > 5 * 60 * 1000) {
            keepaliveThrottleTime = now;
            sendKeepalivePing();
        }
    }

    // Dengarkan event interaksi fisik pengguna
    const trackedEvents = ['mousemove', 'mousedown', 'keydown', 'scroll', 'touchstart'];
    trackedEvents.forEach(evtName => {
        window.addEventListener(evtName, recordUserActivity, { passive: true });
    });

    // Kirim sinyal AJAX keepalive ke backend Laravel
    async function sendKeepalivePing() {
        try {
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrf) return;

            await fetch('{{ route("admin.session.keepalive") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json'
                }
            });
        } catch (e) {
            // Abaikan kesalahan jaringan sekunder
        }
    }

    // Tampilkan modal peringatan
    function showInactivityWarning() {
        isWarningOpen = true;
        countdownRemaining = WARNING_BEFORE_SEC;
        updateCountdownDisplay(countdownRemaining);
        modal.classList.remove('hidden');

        // Pastikan Lucide Icon di modal dirender
        if (window.lucide && typeof window.lucide.createIcons === 'function') {
            window.lucide.createIcons();
        }

        countdownInterval = setInterval(function() {
            countdownRemaining--;
            updateCountdownDisplay(countdownRemaining);

            if (countdownRemaining <= 0) {
                clearInterval(countdownInterval);
                performAutoLogout();
            }
        }, 1000);
    }

    // Format tampilan hitung mundur (MM:SS)
    function updateCountdownDisplay(seconds) {
        if (!countdownEl) return;
        const mins = Math.floor(seconds / 60);
        const secs = seconds % 60;
        countdownEl.textContent = 
            String(mins).padStart(2, '0') + ':' + String(secs).padStart(2, '0');
    }

    // Eksekusi auto-logout saat waktu habis
    function performAutoLogout() {
        if (countdownEl) {
            countdownEl.textContent = '00:00';
        }
        if (btnExtend) {
            btnExtend.disabled = true;
            btnExtend.textContent = 'Menutup sesi...';
        }
        if (autoLogoutForm) {
            autoLogoutForm.submit();
        } else {
            window.location.href = '{{ route("login") }}';
        }
    }

    // Event tombol "Tetap Masuk"
    if (btnExtend) {
        btnExtend.addEventListener('click', async function() {
            btnExtend.disabled = true;
            btnExtend.innerHTML = '<span class="inline-block animate-spin mr-1">↻</span> Memperpanjang...';

            await sendKeepalivePing();

            clearInterval(countdownInterval);
            isWarningOpen = false;
            lastActivityTime = Date.now();
            keepaliveThrottleTime = Date.now();

            modal.classList.add('hidden');
            btnExtend.disabled = false;
            btnExtend.innerHTML = '<i data-lucide="refresh-cw" class="w-3.5 h-3.5"></i><span>Tetap Masuk</span>';
            if (window.lucide && typeof window.lucide.createIcons === 'function') {
                window.lucide.createIcons();
            }
        });
    }

    // Timer Utama: cek selisih waktu setiap 2 detik
    setInterval(function() {
        if (isWarningOpen) return;

        const idleTimeSec = Math.floor((Date.now() - lastActivityTime) / 1000);

        if (idleTimeSec >= WARNING_TRIGGER_SEC) {
            showInactivityWarning();
        }
    }, 2000);
})();
</script>
@endauth
