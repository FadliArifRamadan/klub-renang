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
        Schema::table('progress_reports', function (Blueprint $table) {
            $table->dropColumn(['strength', 'endurance', 'flexibility', 'speed', 'agility']);
            $table->json('metrics')->nullable()->after('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progress_reports', function (Blueprint $table) {
            $table->dropColumn('metrics');
            $table->integer('strength')->nullable();
            $table->integer('endurance')->nullable();
            $table->integer('flexibility')->nullable();
            $table->integer('speed')->nullable();
            $table->integer('agility')->nullable();
        });
    }
};
