<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Only run if the old `type` column exists
        if (!Schema::hasColumn('businesses', 'type')) {
            return;
        }

        // 1) Ensure business_types has entries for all existing type values
        $types = DB::table('businesses')->select('type')->distinct()->pluck('type')->filter()->values();

        foreach ($types as $type) {
            $slug = Str::slug($type);
            DB::table('business_types')->updateOrInsert(
                ['slug' => $slug],
                ['name' => mb_convert_case($type, MB_CASE_TITLE, 'UTF-8'), 'updated_at' => now(), 'created_at' => now()]
            );
        }

        // 2) Build mapping slug => id
        $mapping = DB::table('business_types')->pluck('id', 'slug')->toArray();

        // 3) Update each business to set business_type_id based on slug
        $businesses = DB::table('businesses')->select('id', 'type')->get();
        foreach ($businesses as $b) {
            if (!$b->type) {
                continue;
            }
            $slug = Str::slug($b->type);
            if (isset($mapping[$slug])) {
                DB::table('businesses')->where('id', $b->id)->update(['business_type_id' => $mapping[$slug]]);
            }
        }

        // 4) Drop the old `type` column
        Schema::table('businesses', function (Blueprint $table) {
            if (Schema::hasColumn('businesses', 'type')) {
                $table->dropColumn('type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate `type` column as string and populate from business_type relationship
        Schema::table('businesses', function (Blueprint $table) {
            if (!Schema::hasColumn('businesses', 'type')) {
                $table->string('type')->nullable()->after('slug');
            }
        });

        // Populate the `type` column from business_types.slug
        $types = DB::table('business_types')->pluck('slug', 'id')->toArray();
        $businesses = DB::table('businesses')->select('id', 'business_type_id')->get();
        foreach ($businesses as $b) {
            $typeSlug = isset($types[$b->business_type_id]) ? $types[$b->business_type_id] : null;
            DB::table('businesses')->where('id', $b->id)->update(['type' => $typeSlug]);
        }
    }
};
