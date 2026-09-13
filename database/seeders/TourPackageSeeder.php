<?php

namespace Database\Seeders;

use App\Models\TourPackage;
use Illuminate\Database\Seeder;

class TourPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            // 1. URL TARGET UTAMA: Itinerary Tour Dieng 1 Hari Regular
            [
                'slug' => 'itinerary-tour-dieng-1-hari',
                'title' => 'Itinerary Tour Dieng 1 Hari Regular',
                'category' => 'Tour Reguler',
                'duration' => '1 Hari Penuh',
                'pickup_location' => 'Kota Wonosobo (atau by request)',
                'price' => 325000,
                'price_note' => 'per orang (min. 4 orang)',
                'badge' => 'POPULER & HEMAT',
                'image_url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Program paket tour Dieng 1 hari dengan 3 pilihan rute fleksibel, penjemputan praktis dari Wonosobo, fasilitas makan 2x, tiket masuk lengkap, dan pemandu lokal profesional.',
                'itinerary_options' => [
                    [
                        'name' => 'Optional Kunjungan 1 (Destinasi Ikonik Inti)',
                        'destinations' => 'Kawah Sikidang — Batu Pandang Ratapan Angin — Komplek Candi Arjuna Dieng — Pintu Langit Sky View / Batu Angkruk',
                        'description' => 'Rute favorit untuk melihat kawah belerang purba, panorama dua danau warna-warni dari ketinggian, dan percandian Hindu tertua di Jawa.',
                    ],
                    [
                        'name' => 'Optional Kunjungan 2 (Jalur Panorama Alam & Air Terjun)',
                        'destinations' => 'Air Terjun Sikarim — Swiss Van Java (Desa Tieng) — Telaga Menjer — Kahyangan Skyline — Kebun Teh Panama',
                        'description' => 'Menikmati keasrian alam pegunungan, air terjun eksotis lembah Dieng, serta perairan tenang danau vulkanik Menjer.',
                    ],
                    [
                        'name' => 'Optional Kunjungan 3 (Kombinasi Sejarah, Danau & Langit)',
                        'destinations' => 'Komplek Candi Dieng — Kawah Sikidang — Telaga Warna & Pengilon — Telaga Menjer — Pintu Langit / Taman Langit Sky View',
                        'description' => 'Paket komprehensif memadukan keindahan danau vulkanik, uap belerang, dan spot foto awan modern.',
                    ],
                ],
                'inclusions' => [
                    'Transportasi Wisata AC Antar-Jemput (Wonosobo)',
                    'Paket Makan 2 Kali (termasuk Mie Ongklok Khas Dieng)',
                    'Air Mineral Selama Perjalanan',
                    'Tiket Masuk Seluruh Objek Wisata Sesuai Pilihan Rute',
                    'Bonus Tiket Masuk: Tuk Bimo Lukar dan Dieng Plateau Theater',
                    'Pemandu Wisata Resmi / Tour Guide (Group)',
                    'Dokumentasi Foto dan Spanduk/Banner Kegiatan (Group)',
                    'BBM, Parkir Seluruh Lokasi, & Retribusi Wilayah',
                ],
                'exclusions' => [
                    'Biaya jemput dan antar dari luar titik lokasi Wonosobo (bisa request dengan surcharge)',
                    'Upgrade rute kunjungan wisata tambahan',
                    'Biaya sewa perahu tradisional di Telaga Menjer',
                    'Pengeluaran belanja pribadi dan oleh-oleh',
                ],
                'preparations' => [
                    'Jaket parasit / water proof tebal penghangat tubuh',
                    'Sepatu running / sneaker yang nyaman untuk trekking',
                    'Obat-obatan pribadi yang rutin dikonsumsi',
                    'Jas hujan / payung lipat untuk antisipasi cuaca pegunungan',
                ],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],

            // 2. Paket Tour Dieng 2 Hari 1 Malam
            [
                'slug' => 'paket-tour-dieng-2-hari-1-malam',
                'title' => 'Paket Tour Dieng 2 Hari 1 Malam (Golden Sunrise Sikunir)',
                'category' => 'Tour Reguler',
                'duration' => '2 Hari 1 Malam',
                'pickup_location' => 'Wonosobo / Purwokerto / Jogja / Semarang',
                'price' => 695000,
                'price_note' => 'per orang (min. 4 orang)',
                'badge' => 'PALING DIMINATI ★',
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Paket best seller terfavorit! Saksikan fajar emas Golden Sunrise Bukit Sikunir di atas samudra awan, bermalam di penginapan VIP dengan pemanas air, dan jelajah lengkap 7 destinasi Dieng.',
                'itinerary_options' => [
                    [
                        'name' => 'Hari Pertama: Jelajah Pusaka Vulkanik & Danau',
                        'destinations' => 'Penjemputan di Titik Kumpul — Candi Arjuna — Kawah Sikidang — Makan Siang — Batu Ratapan Angin — Telaga Warna — Check-in Penginapan — Makan Malam Kuliner Khas Dieng',
                        'description' => 'Mulai perjalanan santai menikmati hawa sejuk Dieng, menjelajahi kawah belerang, dan pemandangan danau toska.',
                    ],
                    [
                        'name' => 'Hari Kedua: Samudra Awan Sikunir & Belanja Oleh-oleh',
                        'destinations' => '03.30 Pagi Menuju Bukit Sikunir — Golden Sunrise Sikunir — Telaga Cebong — Sarapan Pagi — Pintu Langit / Kahyangan Skyline — Wisata Belanja Carica & Tempe Kemul — Pengantaran Pulang',
                        'description' => 'Menyaksikan fenomena fajar keemasan terbaik se-Asia Tenggara dan kembali dengan kenangan manis.',
                    ],
                ],
                'inclusions' => [
                    'Mobil Pariwisata Eksekutif AC Selama 2 Hari',
                    'Homestay / Villa VIP dengan Fasilitas Air Hangat (Water Heater)',
                    'Paket Makan 4 Kali Lengkap Hidangan Prasmanan & Restoran Pilihan',
                    'Tiket Masuk VIP Terusan ke Seluruh Destinasi Wisata',
                    'Tour Guide Lokal Berlisensi HPI Asli Dieng',
                    'Dokumentasi Foto Mirrorless & Rekaman Udara Drone 4K',
                    'Air Mineral, Banner Wisata, BBM, dan Parkir',
                ],
                'exclusions' => [
                    'Tiket transportasi dari kota asal menuju meeting point',
                    'Pengeluaran pribadi di luar fasilitas paket',
                    'Tips sukarela pengemudi dan pemandu',
                ],
                'preparations' => [
                    'Jaket gunung tebal / windbreaker (suhu dini hari 8°C - 12°C)',
                    'Sarung tangan wol, kupluk/beanie, dan syal leher',
                    'Sepatu trekking/kets dengan sol anti-selip',
                    'Pakaian ganti secukupnya & perlengkapan mandi pribadi',
                ],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 2,
            ],

            // 3. Paket Tour Dieng 3 Hari 2 Malam
            [
                'slug' => 'paket-tour-dieng-3-hari-2-malam',
                'title' => 'Paket Tour Dieng 3 Hari 2 Malam (Ultimate Cultural Odyssey)',
                'category' => 'Tour Reguler',
                'duration' => '3 Hari 2 Malam',
                'pickup_location' => 'Yogyakarta / Semarang / Purwokerto / Wonosobo',
                'price' => 1150000,
                'price_note' => 'per orang (min. 4 orang)',
                'badge' => 'EKSKLUSIF & LENGKAP',
                'image_url' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Penjelajahan menyeluruh dan santai ke seluruh pelosok dataran tinggi Dieng. Termasuk wisata perkebunan teh bersejarah Tambi, Telaga Dringo, kawah purba tersembunyi, dan sesi barbeque malam.',
                'itinerary_options' => [
                    [
                        'name' => 'Hari 1: Perjalanan Budaya Lembah Candi & Kawah Purba',
                        'destinations' => 'Penjemputan — Komplek Percandian Arjuna — Candi Gatotkaca — Kawah Sikidang — Wisata Kuliner Mie Ongklok — Check-in Hotel',
                        'description' => 'Mengenal peradaban wangsa Sanjaya di Dieng dan keunikan fenomena geologi magma bumi.',
                    ],
                    [
                        'name' => 'Hari 2: Fajar Sikunir & Eksplorasi Danau Alami',
                        'destinations' => 'Golden Sunrise Sikunir — Telaga Cebong — Sarapan Pagi — Telaga Warna & Pengilon — Batu Pandang Ratapan Angin — Telaga Dringo — Kawah Candradimuka — Sesi BBQ Jagung Hangat Malam Hari',
                        'description' => 'Hari penuh pesona lanskap danau alami Dieng dan kehangatan api unggun pegunungan.',
                    ],
                    [
                        'name' => 'Hari 3: Wisata Kolonial Pabrik Teh & Wisata Belanja',
                        'destinations' => 'Agrowisata Perkebunan Teh Tambi — Factory Tour Pabrik Teh Zaman Belanda — Air Terjun Sikarim — Pusat Carica Wonosobo — Pengantaran Pulang',
                        'description' => 'Menikmati udara sejuk kebun teh dan membawa pulang cinderamata khas Wonosobo.',
                    ],
                ],
                'inclusions' => [
                    'Transportasi Eksekutif AC Penuh Selama 3 Hari',
                    'Hotel Berbintang / Villa Eksklusif Dieng 2 Malam',
                    'Paket Makan 7 Kali Prasmanan & Restoran Pilihan',
                    'Tiket Masuk Seluruh Objek Wisata Tanpa Terkecuali',
                    'Sesi Spesial Barbeque Jagung Bakar Malam Hari',
                    'Dokumentasi Kamera Mirrorless & Drone Video 4K',
                    'Pemandu Wisata Profesional HPI & Air Mineral Tanpa Batas',
                ],
                'exclusions' => [
                    'Tiket kereta / pesawat dari kota asal',
                    'Pengeluaran belanja pribadi dan laundry hotel',
                ],
                'preparations' => [
                    'Pakaian hangat tebal untuk 3 hari 2 malam',
                    'Sepatu santai dan sepatu jalan luar ruangan',
                    'Powerbank & kamera pribadi untuk mengabadikan momen',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],

            // 4. Paket Jeep Wisata Dieng 2026
            [
                'slug' => 'paket-jeep-wisata-dieng',
                'title' => 'Paket Jeep Wisata Dieng 2026 (Safari 4x4 Off-Road)',
                'category' => 'Jeep Safari',
                'duration' => 'Setengah Hari / 1 Hari Penuh',
                'pickup_location' => 'Basecamp Jeep Dieng / Titik Penginapan',
                'price' => 850000,
                'price_note' => 'per unit Jeep (maks. 4 orang)',
                'badge' => 'PETUALANGAN ADRENALIN',
                'image_url' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Pacu adrenalin Anda melintasi jalur bebatuan terjal, tanah lumpur perkebunan teh, dan spot foto eksotis pegunungan yang tidak bisa dijangkau kendaraan biasa.',
                'itinerary_options' => [
                    [
                        'name' => 'Rute Short Trip (Durasi 2-3 Jam)',
                        'destinations' => 'Bukit Scooter — Candi Setyaki — Kawah Sikidang — Lembah Sembrani',
                        'description' => 'Pilihan cepat dan mengasyikkan menyusuri bukit-bukit cantik di sekitar desa Dieng.',
                    ],
                    [
                        'name' => 'Rute Medium Trip (Durasi 4-5 Jam)',
                        'destinations' => 'Perkebunan Teh Bedakah — Jembatan Kayu Purba — Telaga Dringo — Kawah Sileri',
                        'description' => 'Melintasi hamparan perkebunan teh hijau luas dan kawah aktif terbesar di dataran tinggi Dieng.',
                    ],
                    [
                        'name' => 'Rute Long Trip Off-Road (Durasi 6-8 Jam)',
                        'destinations' => 'Jalur Ekstrem Hutan Pinus — Savana Pangonan — Telaga Dringo — Air Terjun Sikarim — Curug Winong',
                        'description' => 'Sensasi ekspedisi petualangan offroad sesungguhnya menembus alam liar lereng Dieng.',
                    ],
                ],
                'inclusions' => [
                    '1 Unit Mobil Jeep 4x4 Offroad (Kapasitas maksimal 4 penumpang)',
                    'Pengemudi (Driver) Offroad Lokal Berpengalaman & Ramah',
                    'Bahan Bakar Minyak (BBM) & Retribusi Jalur Wisata',
                    'Tiket Masuk Kawasan Wisata Jalur Jip',
                    'Sesi Pemotretan Estetik di Atas Kap Mesin Jeep Berlatar Gunung',
                    'Air Mineral untuk Seluruh Penumpang',
                ],
                'exclusions' => [
                    'Makanan & minuman pribadi di warung lokal',
                    'Perlengkapan hujan pribadi',
                ],
                'preparations' => [
                    'Jaket windbreaker & kacamata hitam (sunglasses)',
                    'Masker penutup hidung untuk antisipasi debu/asap belerang',
                    'Pakaian yang siap sedikit kotor terkena cipratan tanah/air',
                ],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 4,
            ],

            // 5. Paket Outbound Dieng
            [
                'slug' => 'paket-outbound-dieng',
                'title' => 'Paket Outbound Dieng & Fun Gathering Perusahaan',
                'category' => 'Outbound',
                'duration' => '1 Hari Penuh',
                'pickup_location' => 'Wonosobo / Telaga Menjer / Area Dieng',
                'price' => 450000,
                'price_note' => 'per orang (min. 20 orang rombongan)',
                'badge' => 'TEAM BUILDING',
                'image_url' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Program penguatan kerjasama tim, kepemimpinan, dan penyegaran suasana kerja di tengah sejuknya alam Dieng. Dilengkapi fasilitas sound system, fasilitator berpengalaman, dan wahana seru.',
                'itinerary_options' => [
                    [
                        'name' => 'Sesi Pagi: Energizing & Ice Breaking',
                        'destinations' => 'Opening Ceremony — Dinamika Kelompok — Game Membangun Kepercayaan — Group Strategy Challenge',
                        'description' => 'Mencairkan suasana dan membangun antusiasme seluruh peserta di area lapangan berhawa sejuk.',
                    ],
                    [
                        'name' => 'Sesi Siang: Adventure & Wahana Petualangan',
                        'destinations' => 'Makan Siang Bersama — Flying Fox Kawah Sikidang — Susur Jejak Alam — Komitmen Kebersamaan Tim',
                        'description' => 'Menguji keberanian individu dan kekompakan kelompok di destinasi alam Dieng.',
                    ],
                ],
                'inclusions' => [
                    'Master Game & Fasilitator Outbound Profesional Bersertifikat',
                    'Peralatan Lengkap Seluruh Permainan (Games Equipment)',
                    'Sound System Lapangan & P3K Medis Lapangan',
                    'Sewa Lokasi / Venue Lapangan Outbound Eksklusif',
                    'Paket Makan Siang Prasmanan Khas Wonosobo',
                    'Coffeebreak & Snack Tradisional Rebusan',
                    'Spanduk / Banner Selamat Datang Rombongan Kegiatan',
                    'Dokumentasi Foto & Video Highlight Kegiatan',
                ],
                'exclusions' => [
                    'Armada bus pariwisata luar kota (tersedia opsional)',
                    'Seragam kaos outbound (bisa dipesan terpisah)',
                ],
                'preparations' => [
                    'Pakaian olahraga / kaos kasual yang nyaman bergerak',
                    'Sepatu olahraga bertali (sneakers/running shoes)',
                    'Topi penutup kepala dan handuk kecil',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 5,
            ],

            // 6. Paket Rafting Sungai Serayu Dieng
            [
                'slug' => 'paket-rafting-serayu-dieng',
                'title' => 'Paket Rafting Arung Jeram Sungai Serayu',
                'category' => 'Petualangan',
                'duration' => '1 Hari (4-5 Jam Kegiatan)',
                'pickup_location' => 'Basecamp Rafting Serayu / Wonosobo',
                'price' => 375000,
                'price_note' => 'per orang (min. 5 orang)',
                'badge' => 'ARUNG JERAM SERU',
                'image_url' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Taklukkan derasnya jeram Sungai Serayu sejauh 14-16 kilometer dengan tingkat kesulitan Grade 3+. Menikmati kesegaran air pegunungan Dieng, diselingi jamuan kelapa muda dan mendoan hangat.',
                'itinerary_options' => [
                    [
                        'name' => 'Alur Kegiatan Rafting Serayu',
                        'destinations' => 'Tiba di Basecamp — Safety Briefing & Pemasangan Alat — Menuju Titik Start — Pengarungan Jeram Bidadari & Jeram Flipper — Break Kelapa Muda di Tepi Sungai — Finish Point & Makan Siang',
                        'description' => 'Pengalaman arung jeram aman didampingi river guide dan tim penyelamat bersertifikat.',
                    ],
                ],
                'inclusions' => [
                    'Perahu Karet Standar Internasional & Dayung Khusus',
                    'Pelampung (Life Jacket) & Helm Pengaman Standar SNI',
                    'Skipper / Pemandu Arung Jeram Berpengalaman Tiap Perahu',
                    'Tim Penyelamat (Rescue Team) di Titik Jeram Kritis',
                    'Transportasi Lokal dari Basecamp ke Start Point dan Penjemputan Finish',
                    'Sajian Kelapa Muda Segar & Tempe Mendoan Hangat di Pos Istirahat',
                    'Makan Siang Prasmanan Khas Serayu Setelah Pengarungan',
                    'Fasilitas Kamar Mandi Bilas & Asuransi Kecelakaan Diri',
                ],
                'exclusions' => [
                    'Transportasi antar-jemput dari luar kawasan Wonosobo',
                    'Dokumentasi waterproof action camera (bisa request)',
                ],
                'preparations' => [
                    'Pakaian renang / pakaian sintetis cepat kering (quick dry)',
                    'Sandal gunung bertali atau sepatu air yang melekat kuat',
                    'Pakaian ganti lengkap dan kantong plastik untuk pakaian basah',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 6,
            ],

            // 7. Paket Paralayang Dieng Wonosobo
            [
                'slug' => 'paket-paralayang-dieng',
                'title' => 'Paket Paralayang Tandem Bukit Kekep Wonosobo',
                'category' => 'Petualangan',
                'duration' => 'Setengah Hari',
                'pickup_location' => 'Basecamp Paralayang / Pintu Langit Tieng',
                'price' => 550000,
                'price_note' => 'per orang / tandem flight',
                'badge' => 'TERBANG DI ATAS AWAN',
                'image_url' => 'https://images.unsplash.com/photo-1510312305653-8ed496efae75?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Rasakan sensasi melayang bebas layaknya burung elang di atas perbukitan teh Tieng dan lembah Dieng dengan latar belakang megah Gunung Sindoro.',
                'itinerary_options' => [
                    [
                        'name' => 'Sesi Terbang Tandem Paralayang',
                        'destinations' => 'Registrasi & Cek Kondisi Angin — Briefing Lepas Landas — Take-off Bukit Kekep — Melayang 15-20 Menit di Udara — Pendaratan Halus di Area Landing Lapangan',
                        'description' => 'Didampingi langsung oleh pilot tandem profesional berlisensi FASI nasional.',
                    ],
                ],
                'inclusions' => [
                    'Instruktur / Pilot Tandem Master Berlisensi Resmi FASI',
                    'Peralatan Terbang Parasut & Helm Pengaman Lengkap',
                    'Video Rekaman Aksi Udara Menggunakan Tongkat Kamera GoPro 4K',
                    'Tiket Masuk Area Take-Off Bukit Kekep',
                    'Transportasi Pengantaran Kembali dari Lapangan Landing ke Titik Kumpul',
                    'Sertifikat Pengalaman Terbang Tandem',
                ],
                'exclusions' => [
                    'Biaya transportasi dari kota asal menuju lokasi',
                    'Makanan & minuman pribadi',
                ],
                'preparations' => [
                    'Sepatu olahraga yang nyaman untuk berlari saat take-off',
                    'Jaket windproof tipis dan celana panjang lentur',
                    'Kondisi fisik prima (tidak memiliki riwayat sakit jantung akut)',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 7,
            ],

            // 8. Paket Pendakian Gunung Prau Dieng
            [
                'slug' => 'paket-pendakian-gunung-prau',
                'title' => 'Paket Pendakian Gunung Prau 2.565 MDPL (Sunrise Terbaik)',
                'category' => 'Petualangan',
                'duration' => '2 Hari 1 Malam',
                'pickup_location' => 'Basecamp Patakbanteng / Dieng Kulon',
                'price' => 580000,
                'price_note' => 'per orang (min. 4 orang)',
                'badge' => 'ATAP KAHYANGAN',
                'image_url' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Pendakian ramah pemula menuju puncak Gunung Prau 2.565 mdpl yang dinobatkan memiliki pemandangan matahari terbit terindah di Asia Tenggara dengan panorama deretan gunung Jawa Tengah.',
                'itinerary_options' => [
                    [
                        'name' => 'Hari 1: Trekking Santai & Sunset di Puncak',
                        'destinations' => 'Pemeriksaan Kesehatan di Basecamp — Pendakian 2,5 - 3 Jam Jalur Patakbanteng — Pemasangan Tenda di Sunrise Camp — Menikmati Matahari Terbenam — Makan Malam Hangat',
                        'description' => 'Mendaki jalur anak tangga alami yang tertata rapi didampingi porter dan guide berpengalaman.',
                    ],
                    [
                        'name' => 'Hari 2: Fajar Emas & Bunga Daisy Bukit Teletubbies',
                        'destinations' => '05.00 Bangun Menyaksikan Golden Sunrise — Foto Berlatar Gunung Sindoro Sumbing — Sarapan & Seduh Kopi di Puncak — Eksplorasi Padang Rumput Teletubbies — Perjalanan Turun ke Basecamp',
                        'description' => 'Pagi spektakuler menatap siluet gunung kembar bermandikan cahaya mentari pagi.',
                    ],
                ],
                'inclusions' => [
                    'Tiket Registrasi Resmi Pendakian (Simaksi) & Asuransi Perhutani',
                    'Pemandu Gunung (Mountain Guide) & Porter Tim Logistik',
                    'Tenda Dome Double Layer Kapasitas 4 Orang (Tahan Badai & Hujan)',
                    'Matras Busa & Sleeping Bag Bersih untuk Tiap Peserta',
                    'Logistik Makanan di Puncak (2x Makan Hangat Dimasak di Tempat)',
                    'Alat Masak Camping & Kompor Portable',
                    'Minuman Hangat (Kopi Dieng, Teh Manis, & Jahe Susu)',
                ],
                'exclusions' => [
                    'Porter pribadi untuk barang bawaan ransel pribadi (bisa disewa terpisah)',
                    'Perlengkapan pakaian pribadi pendaki',
                ],
                'preparations' => [
                    'Jaket tebal polar/bulu angsa & pakaian dalam termal (suhu puncak bisa mencapai 5°C)',
                    'Sepatu gunung atau sandal gunung anti-selip',
                    'Senter kepala (headlamp) dan baterai cadangan',
                    'Jas hujan ponco & botol air minum pribadi',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 8,
            ],

            // 9. Paket Camping & Glamping Dieng
            [
                'slug' => 'paket-camping-glamping-dieng',
                'title' => 'Paket Glamping & Camping Mewah di Tepi Danau Dieng',
                'category' => 'Petualangan',
                'duration' => '2 Hari 1 Malam',
                'pickup_location' => 'Telaga Cebong / Kahyangan Skyline Menjer',
                'price' => 490000,
                'price_note' => 'per orang (min. 4 orang)',
                'badge' => 'CAMPING ESTETIK',
                'image_url' => 'https://images.unsplash.com/photo-1510312305653-8ed496efae75?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Nikmati sensasi bermalam di alam terbuka Dieng tanpa repot mendirikan tenda. Tenda safari modern dilengkapi kasur empuk, selimut tebal, api unggun, dan pemandangan danau berkabut.',
                'itinerary_options' => [
                    [
                        'name' => 'Pengalaman Glamping 2D1N',
                        'destinations' => 'Check-in Tenda Safari Glamping — Sesi Sore Menatap Kabut Danau — Api Unggun Bersama — Pesta Barbeque Jagung & Sosis Bakar — Suasana Malam Bertabur Bintang — Fajar Pagi Hangat',
                        'description' => 'Bermalam nyaman dengan akses listrik, toilet air bersih, dan pemandangan magis.',
                    ],
                ],
                'inclusions' => [
                    'Tenda Glamping Safari Waterproof Ukuran Besar',
                    'Kasur Busa Tebal, Bantal, & Selimut Hangat',
                    'Lampu Tenda & Terminal Colokan Listrik Tiap Unit',
                    'Fasilitas Api Unggun Bersama & Kayu Bakar',
                    'Paket Barbeque Malam Hari (Jagung, Sosis, & Marshmallow)',
                    'Sarapan Pagi Hangat & Minuman Kopi/Teh Tanpa Batas',
                    'Tiket Masuk Lokasi Camping Ground & Akses Toilet Bersih',
                ],
                'exclusions' => [
                    'Transportasi menuju camping ground',
                    'Keperluan konsumsi tambahan di luar paket',
                ],
                'preparations' => [
                    'Jaket tebal & kaos kaki tidur hangat',
                    'Perlengkapan mandi pribadi & handuk',
                    'Baju ganti santai untuk berfoto di alam terbuka',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 9,
            ],

            // 10. Paket Dieng Culture Festival 2026
            [
                'slug' => 'paket-dieng-culture-festival-2026',
                'title' => 'Paket Wisata Dieng Culture Festival (DCF) 2026',
                'category' => 'Festival',
                'duration' => '3 Hari 2 Malam',
                'pickup_location' => 'Yogyakarta / Purwokerto / Semarang / Wonosobo',
                'price' => 1450000,
                'price_note' => 'per orang (kuota terbatas)',
                'badge' => 'FESTIVAL TAHUNAN ★',
                'image_url' => 'https://images.unsplash.com/photo-1514525253161-7a46d19cd819?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Paket terlengkap menghadiri perhelatan akbar budaya Dieng: Konser Jazz di Atas Awan, pelepasan ribuan lampion malam, dan prosesi sakral jamasan serta ruwatan anak rambut gimbal.',
                'itinerary_options' => [
                    [
                        'name' => 'Hari 1: Pembukaan & Jazz Atas Awan',
                        'destinations' => 'Penjemputan — Check-in Homestay — Pembukaan Pameran Seni & Kuliner — Konser Musik Akustik & Jazz di Atas Awan Sesi Pertama',
                        'description' => 'Merasakan gegap gempita pesta musik di tengah dinginnya kabut malam Dieng.',
                    ],
                    [
                        'name' => 'Hari 2: Malam Lampion & Sendratari',
                        'destinations' => 'Wisata Kawah Sikidang — Karnaval Budaya Tradisional — Kongres Anak Gimbal — Panggung Utama Musik Artis Nasional — Pesta Pelepasan 5.000 Lampion Terbang',
                        'description' => 'Malam puncak paling magis saat ribuan lampion menerangi angkasa dataran tinggi Dieng.',
                    ],
                    [
                        'name' => 'Hari 3: Ruwatan Rambut Gimbal & Pelarungan',
                        'destinations' => 'Kirab Budaya Menuju Kompleks Candi Arjuna — Prosesi Pemotongan Rambut Gimbal — Pelarungan Rambut ke Telaga Warna — Penutupan Acara & Belanja Oleh-oleh',
                        'description' => 'Menyaksikan ritual kebudayaan paling unik dan sakral warisan leluhur Dieng.',
                    ],
                ],
                'inclusions' => [
                    'Tiket Resmi ID Card VIP Peserta Dieng Culture Festival (All-Access Pass)',
                    'Souvenir Resmi DCF (Kain Batik Tradisional & Kaos Eksklusif DCF)',
                    'Tiket Masuk Panggung Jazz Atas Awan & 1 Buah Lampion Terbang',
                    'Penginapan Homestay Bersih Selama 2 Malam di Kawasan Inti Dieng',
                    'Transportasi Pariwisata AC Selama 3 Hari Penuh',
                    'Paket Makan 6 Kali & Snack Tradisional',
                    'Pemandu Wisata Pendamping Khusus Selama Acara Berlangsung',
                ],
                'exclusions' => [
                    'Tiket perjalanan dari kota domisili ke meeting point',
                    'Pengeluaran belanja pernak-pernik festival',
                ],
                'preparations' => [
                    'Pakaian hangat tebal ekstra (acara malam hari di lapangan terbuka)',
                    'Tikar lipat kecil & mantel tebal untuk menonton konser musik',
                    'Kamera ponsel dengan memori besar untuk merekam momen langka',
                ],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 10,
            ],

            // 11. Paket Tour Edukasi Kopi Dieng
            [
                'slug' => 'paket-edukasi-kopi-dieng',
                'title' => 'Paket Tour Edukasi Budidaya & Pengolahan Kopi Dieng Wonosobo',
                'category' => 'Edukasi',
                'duration' => '1 Hari Penuh',
                'pickup_location' => 'Wonosobo / Desa Wisata Bowongso',
                'price' => 275000,
                'price_note' => 'per orang (min. 10 orang)',
                'badge' => 'FIELD TRIP EDUKASI',
                'image_url' => 'https://images.unsplash.com/photo-1514432324607-a09d9b4aefdd?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Program field trip edukatif mempelajari perjalanan kopi dari biji hingga ke cangkir. Praktek langsung memetik ceri kopi merah, teknik fermentasi, roasting sangrai tradisional, hingga seni seduh manual.',
                'itinerary_options' => [
                    [
                        'name' => 'Rangkaian Kelas Edukasi Kopi Dari Hulu ke Hilir',
                        'destinations' => 'Penyambutan & Welcome Drink Kopi Dieng — Jelajah Kebun Kopi Lereng Gunung — Praktek Petik Ceri Merah — Edukasi Pasca Panen (Honey & Natural Process) — Praktek Roasting Sangrai Tanah Liat — Sesi Cupping & Sensori Kopi — Pembagian Bingkisan Kopi',
                        'description' => 'Dipandu langsung oleh petani pemulia kopi dan roaster profesional daerah Wonosobo.',
                    ],
                ],
                'inclusions' => [
                    'Pemateri Pakar & Petani Kopi Berpengalaman',
                    'Peralatan Praktek Petik, Wadah, & Mesin Pengupas Ceri Kopi',
                    'Bahan Baku Biji Kopi untuk Praktek Sangrai Sendiri',
                    'Makan Siang Nasi Liwet Gurih Khas Pedesaan',
                    'Bingkisan Kopi Arabica Dieng (Kemasan 200 gram untuk tiap peserta)',
                    'Sertifikat Pelatihan Edukasi Kopi & Ruang Pertemuan Sejuk',
                ],
                'exclusions' => [
                    'Transportasi dari luar kota Wonosobo',
                    'Pembelian biji kopi sangrai tambahan',
                ],
                'preparations' => [
                    'Pakaian kasual lengan panjang & topi caping',
                    'Sepatu kets yang nyaman untuk berjalan di kebun',
                    'Buku catatan / buku saku untuk mencatat materi',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 11,
            ],

            // 12. Paket Tour Edukasi Kentang Dieng
            [
                'slug' => 'paket-edukasi-kentang-dieng',
                'title' => 'Paket Tour Edukasi Pembibitan & Penanaman Kentang Dieng',
                'category' => 'Edukasi',
                'duration' => '1 Hari Penuh',
                'pickup_location' => 'Wonosobo / Balai Benih Pertanian Dieng',
                'price' => 260000,
                'price_note' => 'per orang (min. 10 orang)',
                'badge' => 'AGRO EDUKASI',
                'image_url' => 'https://images.unsplash.com/photo-1518977676601-b53f82aba655?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Menyingkap rahasia komoditas emas Dieng! Kunjungan laboratorium kultur jaringan benih bebas virus (G0-G2), praktek menanam di lahan terasering, memanen kentang langsung, dan edukasi pertanian berkelanjutan.',
                'itinerary_options' => [
                    [
                        'name' => 'Rute Agro-Edukasi Kentang Unggulan',
                        'destinations' => 'Kunjungan Screen House Kultur Jaringan — Pengenalan Varietas Kentang Granola — Praktek Pemindahan Bibit ke Lahan — Tur Ladang Kentang Berundak — Panen Kentang Bersama Petani — Olahan Kuliner Kentang Goreng Hangat',
                        'description' => 'Sangat cocok untuk rombongan sekolah, mahasiswa pertanian, dan keluarga yang ingin belajar ilmu botani praktis.',
                    ],
                ],
                'inclusions' => [
                    'Pemandu Ahli Agronomi & Instruktur Pertanian Lokal',
                    'Akses Masuk Rumah Kaca (Greenhouse) Kultur Jaringan Bibit Kentang',
                    'Perlengkapan Sarung Tangan & Alat Tani Edukasi',
                    'Makan Siang Nasi Jagung Sayur Asem Khas Petani Dieng',
                    'Oleh-Oleh Kentang Dieng Super Segar (2 Kg per peserta)',
                    'Sertifikat Peserta Field Trip Pertanian',
                ],
                'exclusions' => [
                    'Transportasi luar kota',
                    'Pengeluaran belanja pribadi',
                ],
                'preparations' => [
                    'Pakaian yang nyaman dan siap terkena tanah ladang',
                    'Sepatu boot karet atau sepatu santai yang mudah dibersihkan',
                    'Jas hujan lipat untuk antisipasi hujan',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 12,
            ],
        ];

        foreach ($packages as $pkg) {
            TourPackage::updateOrCreate(
                ['slug' => $pkg['slug']],
                $pkg
            );
        }
    }
}
