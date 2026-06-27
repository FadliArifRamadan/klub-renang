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
        Schema::table('swimming_classes', function (Blueprint $table) {
            $table->string('progress_form_type')->nullable()->after('name')->comment('batita, balita, anak-anak, dewasa, prestasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('swimming_classes', function (Blueprint $table) {
            $table->dropColumn('progress_form_type');
        });
    }
};
