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
        Schema::table('comcodes', function (Blueprint $table) {
            $table->string('site_scope', 50)->nullable()->default('global')->after('code_group')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comcodes', function (Blueprint $table) {
            $table->dropIndex(['site_scope']);
            $table->dropColumn('site_scope');
        });
    }
};
