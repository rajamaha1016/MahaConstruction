<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tables = [
            'projects',
            'testimonials',
            'package_details',
            'services',
            'gallery',
            'quote_requests',
            'contact_requests',
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                if (!Schema::hasColumn($tableName, 'business_type')) {
                    Schema::table($tableName, function (Blueprint $table) {
                        $table->string('business_type')->default('construction')->index();
                    });
                }

                // Backfill any existing null records to 'construction'
                DB::table($tableName)->whereNull('business_type')->update(['business_type' => 'construction']);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'projects',
            'testimonials',
            'package_details',
            'services',
            'gallery',
            'quote_requests',
            'contact_requests',
        ];

        foreach ($tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'business_type')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('business_type');
                });
            }
        }
    }
};
