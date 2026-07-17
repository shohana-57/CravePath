<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{public function up(): void
{
    Schema::table('menu_items', function (Blueprint $table) {
        if (!Schema::hasColumn('menu_items', 'food_spot_id')) {
            $table->foreignId('food_spot_id')->constrained()->onDelete('cascade');
        }
        if (!Schema::hasColumn('menu_items', 'name')) {
            $table->string('name');
        }
        if (!Schema::hasColumn('menu_items', 'price')) {
            $table->decimal('price', 8, 2);
        }
    });
}

public function down(): void
{
    Schema::table('menu_items', function (Blueprint $table) {
        $table->dropColumn(['food_spot_id', 'name', 'price']);
    });
}
};
