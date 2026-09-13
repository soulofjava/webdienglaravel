<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->string('id')->primary()->default('default');
            $table->string('site_name')->default('TIKETDIENG.COM');
            $table->string('site_tagline')->default('Biro Wisata Dataran Tinggi Dieng');
            $table->string('whatsapp_number')->default('62816675404');
            $table->string('phone_number')->default('+62 816-675-404');
            $table->string('email')->default('halo@tiketdieng.com');
            $table->text('address')->nullable();
            $table->string('legal_nib')->nullable();
            $table->string('hpi_badge')->nullable();
            $table->string('favicon_url')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->text('seo_keywords')->nullable();
            $table->string('og_image_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
