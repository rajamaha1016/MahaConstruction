<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('client')->nullable();
            $table->string('location')->nullable();
            $table->string('budget')->nullable();
            $table->string('completion_date')->nullable();
            $table->string('duration')->nullable();
            $table->string('architecture_style')->nullable();
            $table->text('description')->nullable();
            $table->json('image_urls')->nullable();
            $table->string('video_url')->nullable();
            $table->json('timeline')->nullable();
            $table->string('category')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
