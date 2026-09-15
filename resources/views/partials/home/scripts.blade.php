<script>
    // 1. Scroll Navbar Effect
    const navContainer = document.getElementById('navContainer');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 40) {
            navContainer.classList.add('glass-panel', 'shadow-2xl', 'shadow-black/80', 'py-3');
            navContainer.classList.remove('bg-black/30', 'py-4');
        } else {
            navContainer.classList.remove('glass-panel', 'shadow-2xl', 'shadow-black/80', 'py-3');
            navContainer.classList.add('bg-black/30', 'py-4');
        }
    });

    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    mobileMenuBtn?.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // 2. Fetch Live Weather Dieng (Open-Meteo)
    async function initDiengWeather() {
        const cacheKey = 'dieng_weather_cache';
        const cacheTimeKey = 'dieng_weather_time';
        const cacheDuration = 15 * 60 * 1000;

        const tempEl = document.getElementById('diengTemp');
        const condEl = document.getElementById('diengCondition');
        if (!tempEl || !condEl) return;

        try {
            const cached = sessionStorage.getItem(cacheKey);
            const cachedTime = sessionStorage.getItem(cacheTimeKey);
            if (cached && cachedTime && (Date.now() - parseInt(cachedTime)) < cacheDuration) {
                const w = JSON.parse(cached);
                tempEl.innerText = w.temp + '°C';
                condEl.innerText = w.condition;
                return;
            }

            const res = await fetch('https://api.open-meteo.com/v1/forecast?latitude=-7.2062&longitude=109.9015&current=temperature_2m,relative_humidity_2m,weather_code&timezone=Asia%2FJakarta');
            if (res.ok) {
                const data = await res.json();
                const temp = Math.round(data.current?.temperature_2m ?? 18);
                const code = data.current?.weather_code ?? 0;
                let condition = "Sejuk Berawan";
                if (code === 0) condition = "Cerah Sejuk";
                else if (code <= 2) condition = "Cerah Berawan";
                else if (code <= 3) condition = "Mendung Sejuk";
                else if (code <= 48) condition = "Kabut Dingin";
                else if (code <= 65) condition = "Hujan Dingin";

                tempEl.innerText = temp + '°C';
                condEl.innerText = condition;

                sessionStorage.setItem(cacheKey, JSON.stringify({ temp, condition }));
                sessionStorage.setItem(cacheTimeKey, Date.now().toString());
            }
        } catch (e) {
            // Biarkan fallback
        }
    }
    initDiengWeather();

    // 3. Smart Booking Calculator
    const calcPkg = document.getElementById('calcPkg');
    const calcPax = document.getElementById('calcPax');
    const paxDisplay = document.getElementById('paxDisplay');
    const calcMeeting = document.getElementById('calcMeeting');
    const calcDate = document.getElementById('calcDate');
    const calcName = document.getElementById('calcName');
    const calcNotes = document.getElementById('calcNotes');
    const totalPriceDisplay = document.getElementById('totalPriceDisplay');
    const calcNoteText = document.getElementById('calcNoteText');
    const summaryPkgName = document.getElementById('summaryPkgName');
    const summaryPax = document.getElementById('summaryPax');
    const summaryMeeting = document.getElementById('summaryMeeting');
    const discountRow = document.getElementById('discountRow');
    const summaryDiscount = document.getElementById('summaryDiscount');
    const btnSendWa = document.getElementById('btnSendWa');

    // Inisialisasi Flatpickr (Tanggal Perjalanan)
    if (window.flatpickr && calcDate) {
        flatpickr(calcDate, {
            locale: "id",
            minDate: "today",
            dateFormat: "d F Y",
            altInput: false,
            defaultDate: new Date(Date.now() + 86400000), // Default keberangkatan besok
            disableMobile: "true", // Memaksa tema gelap Dieng tampil di semua perangkat
        });
    }

    function calculatePrice() {
        const selectedOption = calcPkg.options[calcPkg.selectedIndex];
        const basePrice = parseInt(selectedOption.getAttribute('data-price')) || 0;
        const isJeep = selectedOption.getAttribute('data-jeep') === '1';
        const pax = parseInt(calcPax.value) || 1;
        const meetingOption = calcMeeting.options[calcMeeting.selectedIndex];
        const surcharge = parseInt(meetingOption.getAttribute('data-surcharge')) || 0;

        paxDisplay.innerText = pax + ' Orang';
        summaryPax.innerText = pax + ' Orang';
        summaryPkgName.innerText = selectedOption.text.split('—')[0].trim();
        summaryMeeting.innerText = meetingOption.text.split('(')[0].trim();

        let total = 0;
        if (isJeep) {
            const unitsNeeded = Math.ceil(pax / 4);
            total = (unitsNeeded * basePrice) + (surcharge * pax);
            calcNoteText.innerText = `Membutuhkan ${unitsNeeded} Unit Jeep untuk ${pax} orang`;
            discountRow.classList.add('hidden');
        } else {
            let discountPercent = 0;
            if (pax >= 6 && pax < 10) discountPercent = 0.05;
            if (pax >= 10) discountPercent = 0.1;

            const basePerPax = (basePrice * (1 - discountPercent)) + surcharge;
            total = Math.round(basePerPax * pax);
            calcNoteText.innerText = `Estimasi Rp ${Math.round(basePerPax).toLocaleString('id-ID')}/orang`;

            if (discountPercent > 0) {
                discountRow.classList.remove('hidden');
                discountRow.classList.add('flex');
                summaryDiscount.innerText = (discountPercent * 100) + '% Potongan Rombongan';
            } else {
                discountRow.classList.add('hidden');
            }
        }

        totalPriceDisplay.innerText = 'Rp ' + total.toLocaleString('id-ID');
    }

    calcPkg.addEventListener('change', calculatePrice);
    calcPax.addEventListener('input', calculatePrice);
    calcMeeting.addEventListener('change', calculatePrice);
    calculatePrice();

    window.selectPackageInCalculator = function(slug) {
        if (calcPkg) {
            calcPkg.value = slug;
            calculatePrice();
        }
    };

    // 4. Send WhatsApp Handler
    btnSendWa.addEventListener('click', () => {
        const selectedOption = calcPkg.options[calcPkg.selectedIndex];
        const pkgTitle = selectedOption.text.split('—')[0].trim();
        const duration = selectedOption.getAttribute('data-duration');
        const isJeep = selectedOption.getAttribute('data-jeep') === '1';
        const pax = calcPax.value;
        const unitsNeeded = Math.ceil(pax / 4);
        const meeting = calcMeeting.options[calcMeeting.selectedIndex].text.split('(')[0].trim();
        const dateVal = calcDate.value ? calcDate.value : "Fleksibel / Menyesuaikan";
        const nameVal = calcName.value ? calcName.value : "Tamu {{ $settings->site_name }}";
        const notesVal = calcNotes.value.trim();
        const total = totalPriceDisplay.innerText;

        const waTarget = "{{ preg_replace('/\D/', '', $settings->whatsapp_number) }}";

        const text = `*HALO ADMIN {{ $settings->site_name }} - KONSULTASI PAKET DIENG*
----------------------------------------
👤 *Nama:* ${nameVal}
📦 *Paket:* ${pkgTitle} (${duration})
👥 *Peserta:* ${pax} Orang ${isJeep ? `(${unitsNeeded} Unit Jeep)` : ""}
📍 *Titik Jemput:* ${meeting}
📅 *Rencana Tanggal:* ${dateVal}
💰 *Estimasi di Web:* Mulai dari ${total}
${notesVal ? `📝 *Catatan / Homestay:* ${notesVal}\n` : ""}----------------------------------------
Saya ingin menanyakan ketersediaan slot armada dan kamar homestay untuk tanggal tersebut. Mohon dibantu informasinya, terima kasih! 🙏`;

        window.open(`https://wa.me/${waTarget}?text=${encodeURIComponent(text)}`, '_blank');
    });
</script>
