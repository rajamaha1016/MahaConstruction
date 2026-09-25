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
        Schema::create('password_reset_challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('otp_hash');
            $table->timestamp('expires_at');
            $table->unsignedInteger('attempt_count')->default(0);
            $table->unsignedInteger('max_attempts')->default(5);
            $table->timestamp('used_at')->nullable();
            $table->timestamp('last_sent_at')->nullable();
            $table->string('request_ip', 45)->nullable();
            $table->string('reset_token_hash', 64)->nullable()->index();
            $table->timestamp('reset_token_expires_at')->nullable();
            $table->timestamp('reset_token_used_at')->nullable();
            $table->timestamps();

            $table->index(['admin_user_id', 'used_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_challenges');
    }
};
