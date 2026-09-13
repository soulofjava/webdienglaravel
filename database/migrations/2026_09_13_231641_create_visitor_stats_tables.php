<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('visitor_stats', function (Blueprint $table) {
            $table->date('date')->primary();
            $table->unsignedBigInteger('total_visits')->default(0);
            $table->unsignedBigInteger('unique_visitors')->default(0);
            $table->timestamps();
        });

        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_hash', 64)->index();
            $table->date('visit_date')->index();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->unique(['ip_hash', 'visit_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
        Schema::dropIfExists('visitor_stats');
    }
};
