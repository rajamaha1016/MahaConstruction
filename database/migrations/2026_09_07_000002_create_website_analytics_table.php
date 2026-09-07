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
        Schema::create('website_analytics', function (Blueprint $table) {
            $table->id();
            $table->string('business_type', 20)->index(); // 'construction' or 'interior'
            $table->string('event_type', 50)->index();     // 'page_view', 'session_start', 'section_view', 'project_view', 'package_view', 'consultation_click', 'enquiry_submitted', 'quote_submitted', 'contact_submitted'
            $table->string('visitor_id', 64)->index();    // Primary unique visitor identity (client persistent UUID)
            $table->string('session_id', 64)->index();    // Session identity (30-min window UUID)
            
            $table->string('page_url', 2048)->nullable();
            $table->string('page_name', 100)->nullable()->index();
            $table->string('section_name', 100)->nullable()->index();
            $table->string('item_id', 100)->nullable();
            
            $table->unsignedBigInteger('lead_id')->nullable()->index();
            $table->string('lead_type', 50)->nullable();
            
            $table->text('referrer')->nullable();
            $table->string('referrer_host', 255)->nullable()->index();
            $table->string('utm_source', 100)->nullable()->index();
            $table->string('utm_medium', 100)->nullable();
            $table->string('utm_campaign', 100)->nullable();
            
            $table->string('device_type', 20)->default('desktop')->index(); // 'mobile', 'desktop', 'tablet', 'unknown'
            $table->string('ip_hash', 64)->nullable()->index();            // Supplementary privacy-conscious hash (no raw IP)
            $table->string('user_agent_short', 255)->nullable();
            
            $table->timestamp('created_at')->index();
            
            // Composite indexes for fast analytical slicing
            $table->index(['business_type', 'created_at']);
            $table->index(['business_type', 'event_type', 'created_at']);
            $table->index(['visitor_id', 'created_at']);
            $table->index(['session_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_analytics');
    }
};
