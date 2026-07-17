<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::table('reviews', function (Blueprint $table) {
        if (!Schema::hasColumn('reviews', 'is_flagged')) {
            $table->boolean('is_flagged')->default(false);
        }
        if (!Schema::hasColumn('reviews', 'remarks')) {
            $table->text('remarks')->nullable();
        }
        if (!Schema::hasColumn('reviews', 'seller_reply')) {
            $table->text('seller_reply')->nullable();
        }
    });
}

public function down(): void
{
    Schema::table('reviews', function (Blueprint $table) {
        $table->dropColumn(['is_flagged', 'remarks', 'seller_reply']);
    });
}
};
