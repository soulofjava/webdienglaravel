<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('primary_color')->default('#0064D2')->after('active_theme');
            $table->string('accent_color')->default('#FEDD00')->after('primary_color');
            $table->string('whatsapp_color')->default('#25D366')->after('accent_color');
            $table->string('font_family')->default('Plus Jakarta Sans')->after('whatsapp_color');
            $table->string('font_size_scale')->default('normal')->after('font_family');
            $table->string('border_radius_style')->default('rounded-3xl')->after('font_size_scale');
            $table->boolean('hero_widget_overlap')->default(true)->after('border_radius_style');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn([
                'primary_color',
                'accent_color',
                'whatsapp_color',
                'font_family',
                'font_size_scale',
                'border_radius_style',
                'hero_widget_overlap',
            ]);
        });
    }
};
