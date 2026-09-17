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
        Schema::dropIfExists('visitor_logs');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
            $table->string('ip_hash', 64)->index();
            $table->date('visit_date')->index();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->unique(['ip_hash', 'visit_date']);
        });
    }
};
