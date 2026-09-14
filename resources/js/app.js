import Alpine from 'alpinejs';
import Swal from 'sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

window.Alpine = Alpine;
window.Swal = Swal;

/**
 * Konfirmasi dialog SweetAlert2 kustom untuk Hapus Data
 */
window.confirmDelete = function(event, itemName = 'data ini', subtitle = 'Tindakan ini permanen dan tidak dapat dibatalkan.') {
    if (event) event.preventDefault();
    const form = event ? (event.target.tagName === 'FORM' ? event.target : event.target.closest('form')) : null;

    Swal.fire({
        title: 'Konfirmasi Hapus Data',
        html: `
            <div class="space-y-2 text-center">
                <p class="text-sm text-slate-300">Apakah Anda yakin ingin menghapus <span class="font-bold text-amber-300">${itemName}</span>?</p>
                <p class="text-xs text-slate-400 leading-relaxed">${subtitle}</p>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus Sekarang',
        cancelButtonText: 'Batal',
        reverseButtons: true,
        background: '#090d16',
        color: '#f8fafc',
        iconColor: '#f59e0b',
        buttonsStyling: false,
        customClass: {
            popup: 'border border-white/15 rounded-2xl shadow-2xl backdrop-blur-xl p-6 bg-[#090d16]',
            title: 'font-serif text-lg font-bold text-white mb-2',
            htmlContainer: 'text-sm text-slate-300 m-0',
            actions: 'flex items-center justify-center gap-3 mt-6',
            confirmButton: 'px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 transition-all shadow-lg shadow-red-600/30 cursor-pointer',
            cancelButton: 'px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:text-white bg-white/5 hover:bg-white/10 border border-white/10 transition-colors cursor-pointer'
        }
    }).then((result) => {
        if (result.isConfirmed && form) {
            form.submit();
        }
    });

    return false;
};

/**
 * Konfirmasi dialog SweetAlert2 kustom untuk Logout / Keluar
 */
window.confirmLogout = function(event) {
    if (event) event.preventDefault();
    const form = event ? (event.target.tagName === 'FORM' ? event.target : event.target.closest('form')) : null;

    Swal.fire({
        title: 'Konfirmasi Keluar?',
        html: `
            <div class="space-y-1 text-center">
                <p class="text-sm text-slate-300">Apakah Anda yakin ingin mengakhiri sesi pengelola?</p>
                <p class="text-xs text-slate-400">Anda perlu login kembali untuk mengakses panel pengelola.</p>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Keluar',
        cancelButtonText: 'Tetap di Sini',
        reverseButtons: true,
        background: '#090d16',
        color: '#f8fafc',
        iconColor: '#38bdf8',
        buttonsStyling: false,
        customClass: {
            popup: 'border border-white/15 rounded-2xl shadow-2xl backdrop-blur-xl p-6 bg-[#090d16]',
            title: 'font-serif text-lg font-bold text-white mb-2',
            htmlContainer: 'text-sm text-slate-300 m-0',
            actions: 'flex items-center justify-center gap-3 mt-6',
            confirmButton: 'px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider text-white bg-gradient-to-r from-rose-600 to-red-600 hover:from-rose-500 hover:to-red-500 transition-all shadow-lg shadow-rose-600/30 cursor-pointer',
            cancelButton: 'px-4 py-2.5 rounded-xl text-xs font-semibold text-slate-300 hover:text-white bg-white/5 hover:bg-white/10 border border-white/10 transition-colors cursor-pointer'
        }
    }).then((result) => {
        if (result.isConfirmed && form) {
            form.submit();
        }
    });

    return false;
};

Alpine.start();
