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
        // 1. Optimasi Indexing pada Tabel tour_packages
        Schema::table('tour_packages', function (Blueprint $table) {
            // Index untuk list admin per kategori dan sort_order
            $table->index(['category', 'sort_order', 'id'], 'idx_tp_category_sort_id');

            // Index untuk list admin tanpa filter kategori
            $table->index(['sort_order', 'id'], 'idx_tp_sort_id');

            // Index untuk Usage Guard dan filter atribut (badge, duration, pickup_location)
            $table->index('badge', 'idx_tp_badge');
            $table->index('duration', 'idx_tp_duration');
            $table->index('pickup_location', 'idx_tp_pickup_location');

            // Index komposit untuk query publik beranda & pencarian cepat
            $table->index(['is_active', 'is_popular', 'sort_order'], 'idx_tp_active_popular_sort');
            $table->index(['is_active', 'category', 'sort_order'], 'idx_tp_active_category_sort');
        });

        // 2. Optimasi Indexing pada Tabel comcodes
        Schema::table('comcodes', function (Blueprint $table) {
            // Index komposit untuk query getGroup publik & form dropdown (0 filesort)
            $table->index(['code_group', 'is_active', 'sort_order', 'code_name'], 'idx_comcodes_group_active_sort_name');

            // Index untuk query multi-tenant admin comcodes
            $table->index(['site_scope', 'code_group', 'sort_order', 'code_name'], 'idx_comcodes_scope_group_sort');

            // Index untuk otorisasi cepat hak akses kategori per unit
            $table->index(['code_group', 'site_scope', 'is_active'], 'idx_comcodes_group_scope_active');

            // Index pencarian dan relasi nilai teknis
            $table->index('code_value', 'idx_comcodes_code_value');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->dropIndex('idx_tp_category_sort_id');
            $table->dropIndex('idx_tp_sort_id');
            $table->dropIndex('idx_tp_badge');
            $table->dropIndex('idx_tp_duration');
            $table->dropIndex('idx_tp_pickup_location');
            $table->dropIndex('idx_tp_active_popular_sort');
            $table->dropIndex('idx_tp_active_category_sort');
        });

        Schema::table('comcodes', function (Blueprint $table) {
            $table->dropIndex('idx_comcodes_group_active_sort_name');
            $table->dropIndex('idx_comcodes_scope_group_sort');
            $table->dropIndex('idx_comcodes_group_scope_active');
            $table->dropIndex('idx_comcodes_code_value');
        });
    }
};
