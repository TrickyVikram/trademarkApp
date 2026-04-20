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
            // Add these fields if they don't exist
            if (!Schema::hasColumn('applications', 'nationality')) {
                $table->string('nationality')->nullable()->after('applicant_name');
            }
            if (!Schema::hasColumn('applications', 'address')) {
                $table->text('address')->nullable()->after('nationality');
            }
            if (!Schema::hasColumn('applications', 'gender')) {
                $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('address');
            }
            if (!Schema::hasColumn('applications', 'members_details')) {
                $table->json('members_details')->nullable()->after('gender');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropColumn(['nationality', 'address', 'gender', 'members_details']);
        });
    }
};
