<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            if (!Schema::hasColumn('photos', 'food_spot_id')) {
                $table->foreignId('food_spot_id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('photos', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            }
            if (!Schema::hasColumn('photos', 'path')) {
                $table->string('path');
            }
        });
    }

    public function down(): void
    {
        Schema::table('photos', function (Blueprint $table) {
            $table->dropColumn(['food_spot_id', 'user_id', 'path']);
        });
    }
};