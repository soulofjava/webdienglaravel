<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('destination_stories', function (Blueprint $table) {
            $table->id();
            $table->string('site_scope', 50)->default('tiketdieng');
            $table->string('chapter_badge');
            $table->string('title');
            $table->text('quote')->nullable();
            $table->text('description');
            $table->json('highlights')->nullable();
            $table->string('image_url', 2000);
            $table->string('accent_color', 50)->default('amber');
            $table->string('icon', 50)->nullable()->default('compass');
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['site_scope', 'is_active', 'sort_order']);
        });

        // Seed 5 data awal bawaan Dieng (Sikunir, Kawah Sikidang, Telaga Warna, Candi Arjuna, Safari Jip 4x4)
        $now = now();
        $initialStories = [
            [
                'site_scope' => 'tiketdieng',
                'chapter_badge' => 'BAB 01 • 2.463 MDPL',
                'title' => 'Matahari Pertama di Puncak Sikunir',
                'quote' => '“Ketika fajar menyingsing di Sikunir, samudra awan di bawah Anda menjelma emas murni.”',
                'description' => 'Dari bibir puncak Bukit Sikunir di Desa Sembungan (desa tertinggi di Pulau Jawa), Anda akan menyaksikan fajar keemasan perlahan menembus lautan awan dengan latar belakang siluet megah delapan puncak gunung legendaris Jawa Tengah.',
                'highlights' => json_encode([
                    'Pendakian santai 30–40 menit dengan anak tangga rapi',
                    'Panorama 360° Gunung Sindoro, Sumbing, Merbabu, Merapi',
                    'Hangatnya teh purwaceng khas desa tertinggi',
                ]),
                'image_url' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=800&q=75',
                'accent_color' => 'amber',
                'icon' => 'sunrise',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'site_scope' => 'tiketdieng',
                'chapter_badge' => 'BAB 02 • 2.050 MDPL',
                'title' => 'Napas Hangat Sang Hyang di Kawah Sikidang',
                'quote' => '“Di sini, Anda dapat mendengar gemuruh magma bumi yang hidup dan kepulan uap belerang.”',
                'description' => "Dinamakan 'Sikidang' karena letak kawah utamanya yang kerap berpindah tempat menyerupai lompatan kijang. Berjalan di atas jembatan kayu estetik sepanjang satu kilometer membelah kepulan kabut sulfur putih menghadirkan lanskap megah layaknya dataran purba.",
                'highlights' => json_encode([
                    'Jembatan kayu ikonik yang membelah tanah vulkanik',
                    'Pengalaman merebus telur di dalam kawah alami',
                    'Wahana ATV & spot foto eksotis di dataran belerang',
                ]),
                'image_url' => 'https://images.unsplash.com/photo-1469854523086-cc02fe5d8800?auto=format&fit=crop&w=800&q=75',
                'accent_color' => 'amber',
                'icon' => 'flame',
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'site_scope' => 'tiketdieng',
                'chapter_badge' => 'BAB 03 • 2.000 MDPL',
                'title' => 'Simfoni Zamrud di Telaga Warna & Pengilon',
                'quote' => '“Dua danau berdampingan dengan warna air toska berkilau dan cermin jernih alami.”',
                'description' => 'Kandungan mineral sulfur yang tinggi membiaskan spektrum warna hijau toska, toska pekat, hingga keemasan saat terkena sinar matahari. Dikelilingi rimbunnya hutan cemara gunung dan gua-gua pertapaan bersejarah.',
                'highlights' => json_encode([
                    'Panorama dua danau dari Batu Pandang Ratapan Angin',
                    'Gua Semar, Gua Jaran, dan Gua Sumur penuh sejarah mistis',
                    'Jalur trekking rindang di bawah kanopi cemara gunung',
                ]),
                'image_url' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?auto=format&fit=crop&w=800&q=75',
                'accent_color' => 'emerald',
                'icon' => 'droplets',
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'site_scope' => 'tiketdieng',
                'chapter_badge' => 'BAB 04 • 2.093 MDPL',
                'title' => 'Jejak Peradaban Suci di Lembah Arjuna',
                'quote' => '“Percandian Hindu tertua di Jawa dari abad ke-7 yang berdiri kokoh berpagar kabut.”',
                'description' => 'Lima mahakarya batu candi (Arjuna, Semar, Srikandi, Puntadewa, dan Sembadra) menjadi saksi bisu ritual sakral pemotongan rambut gimbal anak-anak Dieng dalam tradisi Dieng Culture Festival.',
                'highlights' => json_encode([
                    "Fenomena kristal es 'Embun Upas' saat musim dingin (Juli–Agustus)",
                    'Arsitektur batu andesit purba dengan relief relief Dewa Siwa',
                    'Padang rumput hijau menyejukkan di pelataran percandian',
                ]),
                'image_url' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?auto=format&fit=crop&w=800&q=75',
                'accent_color' => 'indigo',
                'icon' => 'landmark',
                'sort_order' => 4,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'site_scope' => 'tiketdieng',
                'chapter_badge' => 'BAB 05 • ADRENALIN 4X4',
                'title' => 'Safari Jip 4x4 Melintasi Hutan & Savana',
                'quote' => '“Rasakan denyut petualangan melewati jalur bebatuan, kebun teh, hingga danau tersembunyi.”',
                'description' => 'Armada Jeep 4x4 tangguh siap membawa Anda ke destinasi yang tak terjangkau kendaraan biasa: Telaga Dringo (Ranu Kumbolo-nya Jawa Tengah), perkebunan teh Bedakah, dan Savana Lembah Pangonan.',
                'highlights' => json_encode([
                    'Unit Jeep 4x4 berspesifikasi offroad dengan driver terlatih',
                    'Rute fleksibel (Short, Medium, & Long Safari Trip)',
                    'Sesi pemotretan estetik di atas kap mesin berlatar pegunungan',
                ]),
                'image_url' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?auto=format&fit=crop&w=800&q=75',
                'accent_color' => 'blue',
                'icon' => 'compass',
                'sort_order' => 5,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('destination_stories')->insert($initialStories);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destination_stories');
    }
};
