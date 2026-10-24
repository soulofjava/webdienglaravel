<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('hero_title')->nullable()->after('site_tagline');
            $table->string('hero_title_accent')->nullable()->after('hero_title');
            $table->text('hero_subtitle')->nullable()->after('hero_title_accent');
            $table->string('hero_badge_text')->nullable()->after('hero_subtitle');
            $table->string('hero_feature_1')->nullable()->after('hero_badge_text');
            $table->string('hero_feature_2')->nullable()->after('hero_feature_1');
            $table->string('hero_feature_3')->nullable()->after('hero_feature_2');
            $table->string('hero_feature_4')->nullable()->after('hero_feature_3');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'hero_title',
                'hero_title_accent',
                'hero_subtitle',
                'hero_badge_text',
                'hero_feature_1',
                'hero_feature_2',
                'hero_feature_3',
                'hero_feature_4',
            ]);
        });
    }
};
