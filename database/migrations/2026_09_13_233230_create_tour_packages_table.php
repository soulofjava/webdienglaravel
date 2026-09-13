<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tour_packages', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('category')->default('Tour Reguler'); // Tour Reguler, Jeep Safari, Petualangan, Edukasi, Festival, Outbound
            $table->string('duration')->default('1 Hari');
            $table->string('pickup_location')->default('Kota Wonosobo / By Request');
            $table->unsignedBigInteger('price')->default(0);
            $table->string('price_note')->default('per orang (min. 4 orang)');
            $table->string('badge')->nullable(); // Paling Diminati, Best Seller, Petualangan Adrenalin, dsb
            $table->string('image_url')->nullable();
            $table->text('summary')->nullable();
            $table->json('itinerary_options')->nullable(); // Menyimpan opsi-opsi kunjungan (Opsi 1, Opsi 2, dll)
            $table->json('inclusions')->nullable(); // Fasilitas termasuk
            $table->json('exclusions')->nullable(); // Fasilitas tidak termasuk
            $table->json('preparations')->nullable(); // Persiapan ke Dieng
            $table->boolean('is_popular')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tour_packages');
    }
};
