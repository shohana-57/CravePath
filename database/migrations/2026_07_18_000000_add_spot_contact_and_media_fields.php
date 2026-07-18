<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('food_spots', function (Blueprint $table) {
            $table->string('contact_number')->nullable()->after('address');
            $table->string('contact_email')->nullable()->after('contact_number');
            $table->string('map_link')->nullable()->after('contact_email');
            $table->string('video_url')->nullable()->after('map_link');
            $table->string('opening_hours')->nullable()->after('video_url');
        });
    }

    public function down(): void
    {
        Schema::table('food_spots', function (Blueprint $table) {
            $table->dropColumn(['contact_number', 'contact_email', 'map_link', 'video_url', 'opening_hours']);
        });
    }
};
