<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comcodes', function (Blueprint $table) {
            $table->id();
            $table->string('code_group', 50)->index()->comment('Kelompok kode: package_category, package_badge, pickup_area, package_duration');
            $table->string('code_value', 100)->comment('Nilai teknis / slug kode');
            $table->string('code_name', 150)->comment('Label nama yang tampil di antarmuka');
            $table->text('description')->nullable()->comment('Keterangan opsional');
            $table->integer('sort_order')->default(0)->comment('Urutan tampilan');
            $table->boolean('is_active')->default(true)->index()->comment('Status aktif');
            $table->timestamps();

            $table->index(['code_group', 'is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comcodes');
    }
};
