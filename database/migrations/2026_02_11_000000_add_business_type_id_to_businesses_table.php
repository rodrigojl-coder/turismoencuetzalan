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
        Schema::table('businesses', function (Blueprint $table) {
            if (!Schema::hasColumn('businesses', 'business_type_id')) {
                $table->foreignId('business_type_id')->nullable()->after('slug')->constrained('business_types')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('businesses', function (Blueprint $table) {
            if (Schema::hasColumn('businesses', 'business_type_id')) {
                $table->dropConstrainedForeignId('business_type_id');
            }
        });
    }
};
