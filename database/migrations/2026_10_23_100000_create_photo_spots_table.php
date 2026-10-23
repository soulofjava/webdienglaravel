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
        Schema::create('photo_spots', function (Blueprint $table) {
            $table->id();
            $table->string('site_scope', 50)->default('lotus');
            $table->string('name');
            $table->string('best_time_tag', 50)->nullable()->comment('Contoh: 05.00 WIB, Heritage, Geothermal');
            $table->text('description');
            $table->string('image_url', 2000);
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['site_scope', 'is_active', 'sort_order']);
        });

        // Seed 4 spot foto favorit Dieng bawaan Lotus Creative
        $now = now();
        $initialSpots = [
            [
                'site_scope' => 'lotus',
                'name' => 'Bukit Sikunir Golden Sunrise',
                'best_time_tag' => '05.00 WIB',
                'description' => 'Matahari terbit keemasan berlatar 8 gunung Jawa Tengah. Momen siluet dan kabut awan yang dramatis.',
                'image_url' => 'https://images.unsplash.com/photo-1542038784456-1ea8e935640e?q=80&w=600&auto=format&fit=crop',
                'sort_order' => 1,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'site_scope' => 'lotus',
                'name' => 'Telaga Warna & Batu Pandang',
                'best_time_tag' => '09.00 WIB',
                'description' => 'Gradasi warna danau vulkanik toska zamrud dari ketinggian tebing Ratapan Angin. Spot wajib drone 4K.',
                'image_url' => 'https://images.unsplash.com/photo-1579783900882-c0d3dad7b119?q=80&w=600&auto=format&fit=crop',
                'sort_order' => 2,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'site_scope' => 'lotus',
                'name' => 'Kompleks Candi Arjuna',
                'best_time_tag' => 'Heritage',
                'description' => 'Candi tertua di Pulau Jawa bernuansa mistis berselimut kabut tipis dan taman cemara yang estetik.',
                'image_url' => 'https://images.unsplash.com/photo-1509316975850-ff9c5deb0cd9?q=80&w=600&auto=format&fit=crop',
                'sort_order' => 3,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'site_scope' => 'lotus',
                'name' => 'Kawah Sikidang & Jembatan Kayu',
                'best_time_tag' => 'Geothermal',
                'description' => 'Jembatan kayu panjang melayang di atas asap kawah vulkanik aktif. Vibe edgy, modern, dan sangat sinematik.',
                'image_url' => 'https://images.unsplash.com/photo-1533473359331-0135ef1b58bf?q=80&w=600&auto=format&fit=crop',
                'sort_order' => 4,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('photo_spots')->insert($initialSpots);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photo_spots');
    }
};
