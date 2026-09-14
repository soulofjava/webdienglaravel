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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('company_name')->default('PT. GOTRIP ASIA TRAVELINDO')->after('site_tagline');
            $table->string('bank_name')->default('BNI Cabang Wonosobo')->after('address');
            $table->string('bank_account_number')->default('8166754042')->after('bank_name');
            $table->string('bank_account_name')->default('PT. GOTRIP ASIA TRAVELINDO')->after('bank_account_number');
            $table->string('instagram_url')->default('https://www.instagram.com/tiketwisatadieng')->after('og_image_url');
            $table->string('tiktok_url')->default('https://tiktok.com/@tiketdieng.com')->after('instagram_url');
            $table->string('facebook_url')->default('https://www.facebook.com/share/1Hj4SzNUzH/')->after('tiktok_url');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'company_name',
                'bank_name',
                'bank_account_number',
                'bank_account_name',
                'instagram_url',
                'tiktok_url',
                'facebook_url',
            ]);
        });
    }
};
