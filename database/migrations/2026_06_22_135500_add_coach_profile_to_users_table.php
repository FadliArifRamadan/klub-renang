<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->json('licenses')->nullable()->after('image');
            $table->json('certifications')->nullable()->after('licenses');
            $table->text('experience')->nullable()->after('certifications');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['licenses', 'certifications', 'experience']);
        });
    }
};
