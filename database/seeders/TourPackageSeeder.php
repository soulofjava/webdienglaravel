<?php

namespace Database\Seeders;

use App\Models\TourPackage;
use Illuminate\Database\Seeder;

class TourPackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            // ==========================================
            // A. PAKET JEEP 1 HARI TUR DIENG (KAPASITAS 4 ORANG)
            // ==========================================
            [
                'slug' => 'paket-jeep-1-candi-sikidang-telaga-warna',
                'title' => 'Paket Jeep 1: Komplek Candi, Sikidang & Telaga Warna',
                'category' => 'Jeep Safari',
                'duration' => '06.30 – 11.00 WIB',
                'pickup_location' => 'Area Kota Wonosobo / Penginapan',
                'price' => 850000,
                'price_note' => 'per 1 Jeep (kapasitas 4 dewasa + driver)',
                'badge' => 'JEEP FAVORIT ★',
                'image_url' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Jelajah spot ikonik Dieng menggunakan Jeep 4x4 Feroza/Katana. Mengunjungi Komplek Candi Dieng, Kawah Sikidang, Batu Ratapan Angin, dan Telaga Warna.',
                'itinerary_options' => [
                    [
                        'name' => 'Rute Paket 1',
                        'destinations' => 'Komplek Candi Dieng — Kawah Sikidang — Batu Ratapan Angin — Telaga Warna',
                        'description' => 'Eksplorasi warung sejarah candi tertua, danau vulkanik dua warna, serta kawah belerang purba.',
                    ],
                ],
                'inclusions' => [
                    'Unit Jeep Feroza / Katana (Kapasitas 4 orang dewasa + 1 driver)',
                    'BBM, Parkir, dan Driver Berpengalaman',
                    'Dokumentasi oleh Driver (Foto & Video via HP)',
                ],
                'exclusions' => [
                    'Tiket Masuk Wisata Rp 100.000/orang',
                    'Paket Makan & Wahana/Permainan di Area Wisata',
                    'Dokumentasi Kamera Pro Rp 500.000 / Drone Rp 750.000 / Bundling Rp 1.000.000',
                ],
                'preparations' => [
                    'Jaket tebal hangat',
                    'Kacamata & masker penutup debu',
                    'Sepatu yang nyaman untuk jalan',
                ],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'slug' => 'paket-jeep-2-taman-langit-pintu-langit-sikoter',
                'title' => 'Paket Jeep 2: Taman Langit, Sikapuk Hills & Bukit Sikoter',
                'category' => 'Jeep Safari',
                'duration' => '06.30 – 11.00 WIB',
                'pickup_location' => 'Area Kota Wonosobo / Penginapan',
                'price' => 800000,
                'price_note' => 'per 1 Jeep (kapasitas 4 dewasa + driver)',
                'badge' => 'NEGERI DI ATAS AWAN',
                'image_url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Sensasi wisata langit pegunungan Dieng. Menikmati pemandangan awan dari Taman Langit / Pintu Langit, Sikapuk Hills, Batu Ratapan Angin, dan Bukit Sikoter.',
                'itinerary_options' => [
                    [
                        'name' => 'Rute Paket 2',
                        'destinations' => 'Taman Langit / Pintu Langit — Sikapuk Hills — Batu Ratapan Angin — Bukit Sikoter',
                        'description' => 'Spot foto instagramable dengan lanskap perbukitan hijau dan lautan awan Dieng.',
                    ],
                ],
                'inclusions' => [
                    'Unit Jeep Feroza / Katana Kapasitas 4 Orang Dewasa + 1 Driver',
                    'BBM, Tiket Parkir Seluruh Lokasi, & Driver Ramah',
                    'Bantuan Dokumentasi oleh Driver (HP)',
                ],
                'exclusions' => [
                    'Tiket Masuk Wisata Rp 100.000/orang',
                    'Paket Makan & Wahana di Area Wisata',
                    'Add-on Kamera / Drone Profesional',
                ],
                'preparations' => [
                    'Pakaian hangat dan kamera/smartphone dengan memori lega',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'slug' => 'paket-jeep-3-telaga-menjer-kahyangan-skyline-kebun-teh',
                'title' => 'Paket Jeep 3: Telaga Menjer, Kahyangan Skyline & Kebun Teh',
                'category' => 'Jeep Safari',
                'duration' => '06.30 – 11.00 WIB',
                'pickup_location' => 'Area Kota Wonosobo / Penginapan',
                'price' => 850000,
                'price_note' => 'per 1 Jeep (kapasitas 4 dewasa + driver)',
                'badge' => 'PANORAMA ALAM',
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Jelajah sisi keindahan air dan perkebunan teh Dieng. Mengunjungi Telaga Menjer, Kahyangan Skyline, dan Kebun Teh Tambi Sikatok.',
                'itinerary_options' => [
                    [
                        'name' => 'Rute Paket 3',
                        'destinations' => 'Telaga Menjer — Kahyangan Skyline — Kebun Teh Tambi Sikatok',
                        'description' => 'Kombinasi menyejukkan antara danau alami di kaki gunung dan hamparan teh peninggalan era kolonial.',
                    ],
                ],
                'inclusions' => [
                    'Unit Jeep Feroza / Katana Kapasitas 4 Dewasa + 1 Driver',
                    'BBM, Parkir, dan Driver',
                    'Dokumentasi oleh Driver (Hp)',
                ],
                'exclusions' => [
                    'Tiket Masuk Wisata Rp 100.000/orang',
                    'Sewa Perahu di Telaga Menjer Rp 20.000/orang',
                    'Makan dan Belanja Pribadi',
                ],
                'preparations' => [
                    'Jaket windbreaker & alas kaki anti-selip',
                ],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'slug' => 'paket-jeep-4-kebun-teh-panama-menjer-swiss-van-java',
                'title' => 'Paket Jeep 4: Kebun Teh Panama, Menjer & Swiss Van Java',
                'category' => 'Jeep Safari',
                'duration' => '06.30 – 11.00 WIB',
                'pickup_location' => 'Area Kota Wonosobo',
                'price' => 700000,
                'price_note' => 'per 1 Jeep (kapasitas 4 dewasa + driver)',
                'badge' => 'BEST VALUE ★',
                'image_url' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Rute hemat paling asri dan fotogenik. Menikmati panorama Swiss Van Java (Tieng), Kebun Teh Panama, dan Telaga Menjer.',
                'itinerary_options' => [
                    [
                        'name' => 'Rute Paket 4',
                        'destinations' => 'Kebun Teh Panama — Telaga Menjer — Swiss Van Java',
                        'description' => 'Menyusuri perbukitan terasering indah khas Eropa tropis di lereng gunung Wonosobo.',
                    ],
                ],
                'inclusions' => [
                    'Unit Jeep Feroza / Katana (4 orang)',
                    'BBM, Parkir, Driver',
                    'Dokumentasi Driver (HP)',
                ],
                'exclusions' => [
                    'Tiket Wisata Rp 100.000/orang',
                    'Makan & Wahana Pribadi',
                ],
                'preparations' => ['Jaket hangat dan outfit santai'],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 4,
            ],
            [
                'slug' => 'paket-jeep-5-telaga-bedakah-damarkasian-gunung-cilik',
                'title' => 'Paket Jeep 5: Telaga Bedakah, Damarkasian & Gunung Cilik',
                'category' => 'Jeep Safari',
                'duration' => '06.30 – 11.00 WIB',
                'pickup_location' => 'Area Kota Wonosobo',
                'price' => 900000,
                'price_note' => 'per 1 Jeep (kapasitas 4 dewasa + driver)',
                'badge' => 'HIDDEN GEM',
                'image_url' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Rute hidden gem lereng Sindoro yang memukau. Kunjungi Telaga Bedakah berlatar Gunung Kembang, Kebun Teh Damarkasian, dan bukit eksotis Gunung Cilik Kaliurip.',
                'itinerary_options' => [
                    [
                        'name' => 'Rute Paket 5',
                        'destinations' => 'Telaga Bedakah — Kebun Teh Damarkasian — Gunung Cilik Kaliurip',
                        'description' => 'Eksplorasi panorama 360 derajat pegunungan Sindoro-Sumbing dengan suasana tenang.',
                    ],
                ],
                'inclusions' => [
                    'Unit Jeep Feroza / Katana 4x4 (4 pax)',
                    'BBM, Parkir, Driver',
                    'Dokumentasi Driver (HP)',
                ],
                'exclusions' => ['Tiket Wisata Rp 100.000/orang', 'Makan & Wahana'],
                'preparations' => ['Sepatu kets & jaket tebal'],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 5,
            ],

            // ==========================================
            // B. PAKET SUNRISE JEEP DIENG (03.00 - 11.00 WIB)
            // ==========================================
            [
                'slug' => 'paket-sunrise-jeep-1-sikunir-sikidang-candi',
                'title' => 'Paket Sunrise Jeep 1: Golden Sunrise, Sikidang & Candi',
                'category' => 'Sunrise Safari',
                'duration' => '03.00 – 11.00 WIB',
                'pickup_location' => 'Area Kota Wonosobo / Penginapan',
                'price' => 900000,
                'price_note' => 'per 1 Jeep (kapasitas 4 dewasa + driver)',
                'badge' => 'SUNRISE FAVORIT ★',
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Berangkat dini hari menyongsong fajar emas Golden Sunrise terbaik se-Asia Tenggara, dilanjutkan ke Kawah Sikidang, Batu Ratapan Angin, dan Kompleks Candi Dieng.',
                'itinerary_options' => [
                    [
                        'name' => 'Rute Sunrise 1',
                        'destinations' => 'Golden Sunrise Sikunir / Batu Angkruk — Kawah Sikidang — Batu Ratapan Angin — Komplek Candi Dieng',
                        'description' => 'Pengalaman magis menyaksikan matahari terbit menembus kabut samudra awan.',
                    ],
                ],
                'inclusions' => [
                    'Unit Jeep Feroza / Katana Kapasitas 4 Orang Dewasa + 1 Driver',
                    'BBM, Parkir, Driver Spesialis Sunrise',
                    'Dokumentasi oleh Driver (HP)',
                ],
                'exclusions' => [
                    'Tiket Masuk Wisata Rp 100.000/orang',
                    'Ojek Sikunir Rp 15.000/orang PP',
                    'Paket Makan & Wahana',
                    'Add-on Kamera/Drone Pro',
                ],
                'preparations' => ['Jaket gunung / kupluk / sarung tangan tebal', 'Senter kecil'],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'slug' => 'paket-sunrise-jeep-5-full-day-ultimate',
                'title' => 'Paket Sunrise Jeep 5: Full Day 8 Destinasi Ultimate',
                'category' => 'Sunrise Safari',
                'duration' => '03.00 – Selesai (1 Hari Full)',
                'pickup_location' => 'Area Kota Wonosobo',
                'price' => 1500000,
                'price_note' => 'per 1 Jeep (kapasitas 4 dewasa + driver)',
                'badge' => 'ALL-IN ADVENTURE',
                'image_url' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Ekspedisi seharian penuh terlengkap! Dari Sunrise, Sikidang, Candi Dieng, Air Terjun Sikarim, Swiss Van Java, Telaga Menjer / Pandangan Pertama, Kebun Teh Panama, hingga Kahyangan Skyline.',
                'itinerary_options' => [
                    [
                        'name' => 'Rute Sunrise 5 (1 Hari Penuh)',
                        'destinations' => 'Sunrise Sikunir — Kawah Sikidang — Candi Dieng — Air Terjun Sikarim — Swiss Van Java — Telaga Menjer / Pandangan Pertama — Kebun Teh Panama — Kahyangan Skyline',
                        'description' => 'Rute terlengkap mencakup semua pesona ikonik dan lanskap tersembunyi Dataran Tinggi Dieng.',
                    ],
                ],
                'inclusions' => [
                    'Unit Jeep Feroza / Katana Kapasitas 4 Orang Dewasa + 1 Driver Seharian',
                    'BBM, Parkir Seluruh Objek, dan Driver Profesional',
                    'Dokumentasi Driver (HP)',
                ],
                'exclusions' => [
                    'Tiket Masuk Wisata Rp 100.000/orang',
                    'Perahu Telaga Menjer & Ojek Sikunir',
                    'Makan dan Belanja Oleh-oleh',
                ],
                'preparations' => ['Pakaian ganti, jaket hangat, power bank cadangan'],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 7,
            ],

            // ==========================================
            // C. PAKET SHUTTLE DIENG (KAPASITAS 15 SEAT)
            // ==========================================
            [
                'slug' => 'paket-shuttle-1-sunrise-5-destinasi-oleh-oleh',
                'title' => 'Paket Shuttle 1: Sunrise, 5 Destinasi & Sentra Oleh-oleh',
                'category' => 'Shuttle Bus',
                'duration' => '1 Hari (Sunrise – Sore)',
                'pickup_location' => 'Wonosobo / Meeting Point Rombongan',
                'price' => 1000000,
                'price_note' => 'per 1 Unit Microbus Shuttle (kapasitas s.d 15 orang)',
                'badge' => 'ROMBONGAN HEMAT ★',
                'image_url' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Pilihan praktis & nyaman untuk rombongan keluarga atau kantor hingga 15 orang. Menikmati Sunrise, Kawah Sikidang, Candi Dieng, Ratapan Angin, Kebun Teh Panama, Telaga Menjer, dan pusat oleh-oleh khas.',
                'itinerary_options' => [
                    [
                        'name' => 'Rute Shuttle 1',
                        'destinations' => 'Sunrise Sikunir — Kawah Sikidang — Batu Ratapan Angin — Candi Dieng — Kebun Teh Panama — Telaga Menjer — Pusat Oleh-oleh Carica & Tempe Kemul',
                        'description' => 'Keliling Dieng tanpa repot berdesakan dengan armada mikrobus wisata ber-AC yang nyaman.',
                    ],
                ],
                'inclusions' => [
                    'Unit Bis Wisata Dieng Kapasitas 15 Orang Dewasa',
                    'BBM, Parkir, dan Driver Wisata Berpengalaman',
                    'Diantar Langsung ke Pusat Oleh-oleh dan Rumah Makan Khas',
                ],
                'exclusions' => [
                    'Tiket Masuk Wisata Rp 100.000/orang',
                    'Paket Makan & Wahana Wisata',
                    'Ojek Sikunir Rp 15.000/orang PP',
                    'Sewa Perahu Menjer Rp 20.000/orang',
                ],
                'preparations' => ['Jaket hangat dan alas kaki yang nyaman'],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'slug' => 'paket-shuttle-5-ultimate-10-destinasi',
                'title' => 'Paket Shuttle 5: Ultimate 10 Destinasi & Pemandian Air Panas',
                'category' => 'Shuttle Bus',
                'duration' => '1 Hari Penuh Eksplorasi',
                'pickup_location' => 'Wonosobo / Meeting Point',
                'price' => 1700000,
                'price_note' => 'per 1 Unit Shuttle (kapasitas s.d 15 orang)',
                'badge' => 'SUPER LENGKAP',
                'image_url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Paket rombongan akbar terlengkap! Mengunjungi Sunrise, Sikidang, Ratapan Angin, Telaga Warna, Candi, Pintu Langit, Pemandian Air Panas Alami, Kebun Teh Panama, Telaga Menjer, dan Belanja Oleh-oleh.',
                'itinerary_options' => [
                    [
                        'name' => 'Rute Shuttle 5',
                        'destinations' => 'Sunrise Dieng — Kawah Sikidang — Batu Ratapan Angin — Telaga Warna — Candi Dieng — Taman/Pintu Langit — Pemandian Air Panas — Kebun Teh Panama — Telaga Menjer — Pusat Oleh-oleh',
                        'description' => 'Paket relaksasi dan petualangan terlengkap untuk instansi, keluarga besar, atau komunitas.',
                    ],
                ],
                'inclusions' => [
                    'Unit Bis Wisata Kapasitas 15 Seat',
                    'BBM, Parkir, dan Driver',
                    'Antar ke Rumah Makan & Belanja Oleh-oleh',
                ],
                'exclusions' => ['Tiket Wisata Rp 100.000/orang', 'Makan dan Wahana'],
                'preparations' => ['Baju ganti untuk pemandian air panas dan jaket hangat'],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 9,
            ],

            // ==========================================
            // D. JASA DOKUMENTASI DIENG (DSLR/MIRRORLESS & DRONE)
            // ==========================================
            [
                'slug' => 'jasa-dokumentasi-sinematik-drone-dieng',
                'title' => 'Jasa Dokumentasi Profesional: Kamera Mirrorless & Drone 4K',
                'category' => 'Dokumentasi',
                'duration' => 'Mengikuti Durasi Trip',
                'pickup_location' => 'Lokasi Trip Dieng',
                'price' => 2500000,
                'price_note' => 'per paket trip (semua spot destinasi)',
                'badge' => 'HASIL SINEMATIK ★',
                'image_url' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Abadikan liburan Anda dengan standar visual profesional. Dikerjakan tim kreatif dengan kamera DSLR/mirrorless, lensa wide/tele, lighting pendukung, dan video udara Drone 4K.',
                'itinerary_options' => [
                    [
                        'name' => 'Cakupan Destinasi Lengkap',
                        'destinations' => 'Sunrise — Sikidang — Ratapan Angin — Telaga Warna — Candi Dieng — Pintu Langit — Kebun Teh — Telaga Menjer — Sikarim — Swiss Van Java',
                        'description' => 'Dokumentasi foto dan video cinematic yang siap tayang di Instagram Reels / TikTok.',
                    ],
                ],
                'inclusions' => [
                    'Tim Profesional: 1–2 Orang Fotografer & Videografer',
                    'Peralatan Standar Industri (Kamera Mirrorless, Lensa Variatif, Flash/Lighting)',
                    'Pengambilan Video Udara Drone 4K (Aerial Footage)',
                    'Seluruh File Mentah (RAW / Footage Foto & Video Tanpa Batas)',
                    'Hasil Edit: Foto Color-Graded & Video Cinematic / Reels Musik Tren',
                    'Media Penyimpanan via Google Drive Cloud atau Flashdisk Khusus',
                ],
                'exclusions' => [
                    'Tiket Masuk Wisata Kru',
                    'Konsumsi Kru Dokumentasi',
                ],
                'preparations' => ['Pilihlah outfit dengan warna kontras alam (putih, mustard, earth-tone)'],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 10,
            ],

            // ==========================================
            // E. JASA TOUR GUIDE RESMI LOKAL & MANCA
            // ==========================================
            [
                'slug' => 'jasa-tour-guide-dieng-hpi',
                'title' => 'Jasa Tour Guide Berlisensi Resmi HPI (Lokal & Mancanegara)',
                'category' => 'Pemandu Wisata',
                'duration' => '1 Hari Kunjungan',
                'pickup_location' => 'Meeting Point Dieng / Wonosobo',
                'price' => 500000,
                'price_note' => 'per hari per grup (kapasitas 1 - 20 orang)',
                'badge' => 'LISENSI RESMI HPI',
                'image_url' => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Ditemani pemandu lokal asli Dieng berlisensi resmi HPI (Himpunan Pramuwisata Indonesia). Ramah, menguasai sejarah geologi candi, serta siap membantu dokumentasi foto smartphone Anda.',
                'itinerary_options' => [
                    [
                        'name' => 'Pilihan Layanan Guide',
                        'destinations' => 'Guide Bahasa Lokal Indonesia (Rp 400.000 - Rp 600.000) / Guide Bahasa Asing Inggris, Arab, Mandarin, India (Rp 1.000.000 - Rp 1.800.000)',
                        'description' => 'Penjelasan mendalam mengenai sejarah peradaban candi Hindu Dieng abad ke-7, geologi vulkanik, hingga kearifan lokal.',
                    ],
                ],
                'inclusions' => [
                    'Tour Guide Lokal Berpengalaman & Berlisensi Resmi',
                    'Kemampuan Berbahasa Komunikatif & Ramah',
                    'Bantuan Pengambilan Dokumentasi Foto/Video Sepanjang Perjalanan',
                    'Private Service Khusus Rombongan Anda (1–20 orang)',
                ],
                'exclusions' => ['Tiket Masuk Wisata', 'Makan Guide'],
                'preparations' => ['Siapkan rasa ingin tahu dan pertanyaan seputar Dieng'],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 11,
            ],

            // ==========================================
            // F. PAKET OUTBOUND & GATHERING PERUSAHAAN (GAME CURRICULUM)
            // ==========================================
            [
                'slug' => 'paket-outbound-gathering-dieng',
                'title' => 'Paket Outbound & Gathering Dieng (Fun Games & Team Building)',
                'category' => 'Outbound',
                'duration' => 'Setengah Hari / 1 Hari Penuh',
                'pickup_location' => 'Area Candi Dieng / Kebun Teh / Telaga Menjer / Hotel',
                'price' => 60000,
                'price_note' => 'per orang (20–50 pax: Rp 60rb | 50–100 pax: Rp 45rb | >100 pax: Rp 40rb)',
                'badge' => 'TEAM BUILDING ★',
                'image_url' => 'https://images.unsplash.com/photo-1528605248644-14dd04022da1?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Program outbound edukatif dan menyenangkan untuk instansi, perusahaan, sekolah, atau komunitas. Didukung kurikulum games Ice Breaking dan Team Building berstandar profesional.',
                'itinerary_options' => [
                    [
                        'name' => 'Kurikulum Ice Breaking Seru',
                        'destinations' => 'Tepuk Heboh — Buka Tutup Konsentrasi — Sambung Kata Cepat — Badai Berembus',
                        'description' => 'Mencairkan kebekuan suasana dan membangun energi positif di tengah udara sejuk Dieng.',
                    ],
                    [
                        'name' => 'Kurikulum Team Building Populer',
                        'destinations' => 'Human Knot (Ikatan Manusia) — Marshmallow Strategy Challenge — Estafet Air Bocor — Charades Tebak Kata — Scavenger Hunt Petualangan',
                        'description' => 'Mengasah komunikasi non-verbal, kepemimpinan, strategi kolaboratif, dan soliditas tim.',
                    ],
                ],
                'inclusions' => [
                    'Instruktur & Fasilitator Outbound Berpengalaman',
                    'Izin Penggunaan Lokasi / Venue Outbound',
                    'Sound System Lapangan & Sound Crew',
                    'Seluruh Properti & Peralatan Games',
                    'Air Mineral untuk Seluruh Peserta',
                    'Dokumentasi Foto Kegiatan',
                    'Spanduk / Banner Kegiatan Eksklusif',
                    'Hadiah Spesial untuk Juara Game Tim',
                ],
                'exclusions' => [
                    'Transport Shuttle Dieng (Opsional Rp 100.000/orang)',
                    'Paket Makan Siang Prasmanan',
                ],
                'preparations' => ['Pakaian olahraga / kaos seragam & sepatu kets'],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 12,
            ],

            // ==========================================
            // G. PAKET KOMPLIT 2H1M & 3H2M (POPULAR PACKAGES)
            // ==========================================
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
                'summary' => 'Paket menginap komplit terfavorit! Fajar emas Golden Sunrise Bukit Sikunir di atas samudra awan, bermalam di penginapan VIP water heater, dan jelajah 7 destinasi Dieng.',
                'itinerary_options' => [
                    [
                        'name' => 'Hari Pertama: Jelajah Vulkanik & Danau',
                        'destinations' => 'Penjemputan — Candi Arjuna — Kawah Sikidang — Makan Siang — Batu Ratapan Angin — Telaga Warna — Check-in Penginapan — Makan Malam Khas Dieng',
                        'description' => 'Mulai perjalanan menikmati hawa sejuk Dieng, kawah belerang, danau toska dan kuliner lokal.',
                    ],
                    [
                        'name' => 'Hari Kedua: Samudra Awan Sikunir & Oleh-oleh',
                        'destinations' => '03.30 Pagi Menuju Sikunir — Golden Sunrise — Telaga Cebong — Sarapan Pagi — Pintu Langit / Kahyangan Skyline — Sentra Carica & Tempe Kemul — Pengantaran Pulang',
                        'description' => 'Menyaksikan fenomena fajar keemasan terbaik dan membawa buah tangan khas Dieng.',
                    ],
                ],
                'inclusions' => [
                    'Mobil Wisata Eksekutif AC Selama 2 Hari',
                    'Homestay / Villa dengan Pemanas Air (Water Heater)',
                    'Paket Makan 4 Kali Hidangan Khas',
                    'Tiket Masuk Terusan Destinasi Wisata',
                    'Tour Guide Lokal Berlisensi HPI',
                    'Dokumentasi Foto & Video',
                    'BBM, Parkir, Air Mineral',
                ],
                'exclusions' => ['Kebutuhan pribadi di luar fasilitas'],
                'preparations' => ['Jaket tebal hangat untuk malam dan subuh di Sikunir'],
                'is_popular' => true,
                'is_active' => true,
                'sort_order' => 13,
            ],
            [
                'slug' => 'paket-tour-dieng-3-hari-2-malam',
                'title' => 'Paket Tour Dieng 3 Hari 2 Malam (Ultimate Cultural Odyssey)',
                'category' => 'Tour Reguler',
                'duration' => '3 Hari 2 Malam',
                'pickup_location' => 'Wonosobo / Purwokerto / Jogja / Semarang',
                'price' => 1150000,
                'price_note' => 'per orang (min. 4 orang)',
                'badge' => 'EKSKLUSIF & LENGKAP',
                'image_url' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?auto=format&fit=crop&w=1200&q=80',
                'summary' => 'Jelajah mendalam tanpa terburu-buru. Menggabungkan keelokan alam, sejarah mistis Candi Dieng, petualangan offroad jip, dan kehangatan malam bersama warga lokal.',
                'itinerary_options' => [
                    [
                        'name' => 'Hari 1: Welcoming & Pesona Danau',
                        'destinations' => 'Penjemputan — Welcome Drink Kuliner Mie Ongklok — Kompleks Candi Dieng — Check-in Penginapan — Menikmati Sore di Desa Wisata',
                        'description' => 'Aklimatisasi hawa sejuk Dieng dan bersantai menikmati suasana desa tertinggi di pulau Jawa.',
                    ],
                    [
                        'name' => 'Hari 2: Fajar Sikunir & Eksplorasi Danau Alami',
                        'destinations' => 'Golden Sunrise Sikunir — Telaga Cebong — Sarapan Pagi — Telaga Warna & Pengilon — Batu Pandang Ratapan Angin — Telaga Dringo — Kawah Candradimuka — Sesi BBQ Jagung Hangat Malam Hari',
                        'description' => 'Hari penuh petualangan ke spot alam tersembunyi berlanjut sesi santai malam api unggun.',
                    ],
                    [
                        'name' => 'Hari 3: Wisata Belanja & Perpisahan Hangat',
                        'destinations' => 'Sarapan Pagi — Belanja Oleh-Oleh Carica, Purwaceng, Keripik Jamur & Tempe Kemul — Drop Off Stasiun/Bandara',
                        'description' => 'Waktu santai belanja cendera mata autentik sebelum diantar kembali ke kota kepulangan.',
                    ],
                ],
                'inclusions' => [
                    'Mobil Wisata Eksekutif AC 3 Hari Penuh',
                    'Penginapan Villa 2 Malam (Kamar Mandi Air Panas)',
                    'Paket Makan 7 Kali Prasmanan & Restoran Pilihan',
                    'Tiket Masuk Seluruh Objek Wisata',
                    'Sesi Barbeque Jagung Bakar Malam Hari',
                    'Dokumentasi Foto & Video',
                    'Tour Guide HPI, Air Mineral, BBM, Parkir',
                ],
                'exclusions' => ['Tiket kereta/pesawat dari kota asal'],
                'preparations' => ['Pakaian hangat tebal untuk 3 hari 2 malam'],
                'is_popular' => false,
                'is_active' => true,
                'sort_order' => 14,
            ],
        ];

        foreach ($packages as $data) {
            TourPackage::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
