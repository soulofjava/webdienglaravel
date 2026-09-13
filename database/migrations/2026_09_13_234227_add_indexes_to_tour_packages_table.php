<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->index(['is_active', 'sort_order', 'id'], 'idx_active_sort_id');
            $table->index(['is_active', 'category'], 'idx_active_category');
            $table->index('is_popular', 'idx_popular');
        });
    }

    public function down(): void
    {
        Schema::table('tour_packages', function (Blueprint $table) {
            $table->dropIndex('idx_active_sort_id');
            $table->dropIndex('idx_active_category');
            $table->dropIndex('idx_popular');
        });
    }
};
