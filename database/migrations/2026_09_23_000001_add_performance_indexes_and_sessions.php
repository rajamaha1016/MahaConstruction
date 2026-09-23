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
        // 1. Ensure sessions table exists for database session driver
        if (!Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        }

        // 2. Add performance indexes for high-frequency admin filter queries
        if (Schema::hasTable('contact_requests')) {
            Schema::table('contact_requests', function (Blueprint $table) {
                $table->index('is_read', 'idx_contact_requests_is_read');
            });
        }

        if (Schema::hasTable('quote_requests')) {
            Schema::table('quote_requests', function (Blueprint $table) {
                $table->index('is_read', 'idx_quote_requests_is_read');
            });
        }

        if (Schema::hasTable('projects')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->index('is_featured', 'idx_projects_is_featured');
            });
        }

        if (Schema::hasTable('partners')) {
            Schema::table('partners', function (Blueprint $table) {
                $table->index('is_active', 'idx_partners_is_active');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('partners')) {
            Schema::table('partners', function (Blueprint $table) {
                $table->dropIndex('idx_partners_is_active');
            });
        }

        if (Schema::hasTable('projects')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropIndex('idx_projects_is_featured');
            });
        }

        if (Schema::hasTable('quote_requests')) {
            Schema::table('quote_requests', function (Blueprint $table) {
                $table->dropIndex('idx_quote_requests_is_read');
            });
        }

        if (Schema::hasTable('contact_requests')) {
            Schema::table('contact_requests', function (Blueprint $table) {
                $table->dropIndex('idx_contact_requests_is_read');
            });
        }

        Schema::dropIfExists('sessions');
    }
};
