<?php

namespace Database\Seeders;

use App\Models\DestinationStory;
use Illuminate\Database\Seeder;

class DestinationStorySeeder extends Seeder
{
    public function run(): void
    {
        $stories = [
            [
                'site_scope' => 'tiketdieng',
                'chapter_badge' => 'BAB 01 • 2.463 MDPL',
                'title' => 'Matahari Pertama di Puncak Sikunir',
                'quote' => '“Ketika fajar menyingsing di Sikunir, samudra awan di bawah Anda menjelma emas murni.”',
                'description' => 'Dari bibir puncak Bukit Sikunir di Desa Sembungan (desa tertinggi di Pulau Jawa), Anda akan menyaksikan fajar keemasan perlahan menembus lautan awan dengan latar belakang siluet megah delapan puncak gunung legendaris Jawa Tengah.',
                'highlights' => [
                    'Pendakian santai 30–40 menit dengan anak tangga rapi',
                    'Panorama 360° Gunung Sindoro, Sumbing, Merbabu, Merapi',
                    'Hangatnya teh purwaceng khas desa tertinggi',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=75',
                'accent_color' => 'amber',
                'icon' => 'sunrise',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'site_scope' => 'tiketdieng',
                'chapter_badge' => 'BAB 02 • 2.050 MDPL',
                'title' => 'Napas Hangat Sang Hyang di Kawah Sikidang',
                'quote' => '“Di sini, Anda dapat mendengar gemuruh magma bumi yang hidup dan kepulan uap belerang.”',
                'description' => "Dinamakan 'Sikidang' karena letak kawah utamanya yang kerap berpindah tempat menyerupai lompatan kijang. Berjalan di atas jembatan kayu estetik sepanjang satu kilometer membelah kepulan kabut sulfur putih menghadirkan lanskap megah layaknya dataran purba.",
                'highlights' => [
                    'Jembatan kayu ikonik yang membelah tanah vulkanik',
                    'Pengalaman merebus telur di dalam kawah alami',
                    'Wahana ATV & spot foto eksotis di dataran belerang',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=75',
                'accent_color' => 'amber',
                'icon' => 'flame',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'site_scope' => 'tiketdieng',
                'chapter_badge' => 'BAB 03 • 2.000 MDPL',
                'title' => 'Simfoni Zamrud di Telaga Warna & Pengilon',
                'quote' => '“Dua danau berdampingan dengan warna air toska berkilau dan cermin jernih alami.”',
                'description' => 'Kandungan mineral sulfur yang tinggi membiaskan spektrum warna hijau toska, toska pekat, hingga keemasan saat terkena sinar matahari. Dikelilingi rimbunnya hutan cemara gunung dan gua-gua pertapaan bersejarah.',
                'highlights' => [
                    'Panorama dua danau dari Batu Pandang Ratapan Angin',
                    'Gua Semar, Gua Jaran, dan Gua Sumur penuh sejarah mistis',
                    'Jalur trekking rindang di bawah kanopi cemara gunung',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=75',
                'accent_color' => 'emerald',
                'icon' => 'droplets',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'site_scope' => 'tiketdieng',
                'chapter_badge' => 'BAB 04 • 2.093 MDPL',
                'title' => 'Jejak Peradaban Suci di Lembah Arjuna',
                'quote' => '“Percandian Hindu tertua di Jawa dari abad ke-7 yang berdiri kokoh berpagar kabut.”',
                'description' => 'Lima mahakarya batu candi (Arjuna, Semar, Srikandi, Puntadewa, dan Sembadra) menjadi saksi bisu ritual sakral pemotongan rambut gimbal anak-anak Dieng dalam tradisi Dieng Culture Festival.',
                'highlights' => [
                    "Fenomena kristal es 'Embun Upas' saat musim dingin (Juli–Agustus)",
                    'Arsitektur batu andesit purba dengan relief relief Dewa Siwa',
                    'Padang rumput hijau menyejukkan di pelataran percandian',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?auto=format&fit=crop&w=800&q=75',
                'accent_color' => 'indigo',
                'icon' => 'landmark',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'site_scope' => 'tiketdieng',
                'chapter_badge' => 'BAB 05 • ADRENALIN 4X4',
                'title' => 'Safari Jip 4x4 Melintasi Hutan & Savana',
                'quote' => '“Rasakan denyut petualangan melewati jalur bebatuan, kebun teh, hingga danau tersembunyi.”',
                'description' => 'Armada Jeep 4x4 tangguh siap membawa Anda ke destinasi yang tak terjangkau kendaraan biasa: Telaga Dringo (Ranu Kumbolo-nya Jawa Tengah), perkebunan teh Bedakah, dan Savana Lembah Pangonan.',
                'highlights' => [
                    'Unit Jeep 4x4 berspesifikasi offroad dengan driver terlatih',
                    'Rute fleksibel (Short, Medium, & Long Safari Trip)',
                    'Sesi pemotretan estetik di atas kap mesin berlatar pegunungan',
                ],
                'image_url' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=800&q=75',
                'accent_color' => 'blue',
                'icon' => 'compass',
                'sort_order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($stories as $story) {
            DestinationStory::updateOrCreate(
                [
                    'site_scope' => $story['site_scope'],
                    'chapter_badge' => $story['chapter_badge'],
                ],
                $story
            );
        }
    }
}
