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
        Schema::table('applications', function (Blueprint $table) {
            // Add new columns for trademark classes and goods/services
            if (!Schema::hasColumn('applications', 'classes')) {
                $table->json('classes')->nullable()->after('description');
            }
            if (!Schema::hasColumn('applications', 'goods_services')) {
                $table->text('goods_services')->nullable()->after('classes');
            }
            if (!Schema::hasColumn('applications', 'usage')) {
                $table->enum('usage', ['used', 'proposed'])->nullable()->after('goods_services');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            if (Schema::hasColumn('applications', 'classes')) {
                $table->dropColumn('classes');
            }
            if (Schema::hasColumn('applications', 'goods_services')) {
                $table->dropColumn('goods_services');
            }
            if (Schema::hasColumn('applications', 'usage')) {
                $table->dropColumn('usage');
            }
        });
    }
};
