<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('package_details', function (Blueprint $table) {
            $table->integer('price_per_sqft')->nullable()->default(null)->change();
        });
    }

    public function down(): void
    {
        Schema::table('package_details', function (Blueprint $table) {
            $table->integer('price_per_sqft')->default(1999)->change();
        });
    }
};
