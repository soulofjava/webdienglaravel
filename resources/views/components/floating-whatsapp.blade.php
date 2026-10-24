@php
    $rawWa = preg_replace('/\D/', '', $settings->whatsapp_number ?? '62816675404');
    if (str_starts_with($rawWa, '0')) {
        $cleanWa = '62' . substr($rawWa, 1);
    } else {
        $cleanWa = $rawWa;
    }
    
    // Default chat text disesuaikan dengan tema / unit
    $currentTheme = $activeTheme ?? 'tiketdieng';
    $defaultMsg = match($currentTheme) {
        'lotus' => "Halo Lotus Creative, saya ingin tanya ketersediaan jasa foto & video di Dieng.",
        'jeep' => "Halo Ready Jeep Dieng, saya mau tanya ketersediaan armada Jeep 4x4 Dieng.",
        'shuttle' => "Halo Shuttle Dieng, saya ingin info rute dan jadwal antar-jemput Dieng.",
        default => "Halo TiketDieng, saya ingin konsultasi paket wisata dan tiket Dieng.",
    };
    $waUrl = "https://wa.me/{$cleanWa}?text=" . urlencode($defaultMsg);
@endphp

@if(!empty($cleanWa))
<div 
    x-data="{ showTooltip: false }"
    class="fixed bottom-6 right-6 z-50 flex items-center group print:hidden select-none"
>
    <!-- Label Tooltip Teks (Muncul saat hover di desktop / tetap rapi) -->
    <a 
        href="{{ $waUrl }}"
        target="_blank"
        rel="noopener noreferrer"
        aria-label="Hubungi Kami via WhatsApp"
        class="relative flex items-center gap-2.5 px-4 py-3 sm:px-5 sm:py-3.5 rounded-full bg-[#25D366] hover:bg-[#20ba5a] text-white font-extrabold text-xs sm:text-sm shadow-2xl shadow-emerald-600/40 hover:shadow-emerald-600/60 hover:scale-105 active:scale-95 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-emerald-400/50"
        style="background-color: var(--wa-color, #25D366);"
    >
        <!-- Pulse Glow Ring Effect di belakang tombol -->
        <span class="absolute -inset-1 rounded-full bg-[#25D366] opacity-30 animate-ping group-hover:opacity-0 pointer-events-none" style="background-color: var(--wa-color, #25D366);"></span>

        <!-- SVG Icon Asli WhatsApp (Lebih tajam & presisi daripada icon font) -->
        <svg class="w-6 h-6 sm:w-6 sm:h-6 fill-current shrink-0" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
        </svg>

        <span class="tracking-wide">Chat WhatsApp</span>

        <!-- Badge Online Hijau Mini -->
        <span class="w-2.5 h-2.5 rounded-full bg-white ring-2 ring-emerald-500 shrink-0 hidden sm:inline-block animate-pulse"></span>
    </a>
</div>
@endif
