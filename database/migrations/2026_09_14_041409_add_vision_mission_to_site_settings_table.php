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
            $table->text('about_us')->nullable()->after('company_name');
            $table->text('company_history')->nullable()->after('about_us');
            $table->text('company_vision')->nullable()->after('company_history');
            $table->text('company_mission')->nullable()->after('company_vision');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['about_us', 'company_history', 'company_vision', 'company_mission']);
        });
    }
};
