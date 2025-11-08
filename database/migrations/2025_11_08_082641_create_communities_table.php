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
        Schema::create('communities', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('icon_image')->nullable();
            $table->foreignId('game_id')->constrained('games')->onDelete('cascade');
            $table->string('hashtag')->unique(); // e.g., #TF2
            $table->integer('subscriber_count')->default(0);
            $table->integer('post_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->json('rules')->nullable(); // Community rules
            $table->json('moderators')->nullable(); // Array of user IDs who can moderate
            $table->timestamp('last_post_at')->nullable();
            $table->timestamps();

            $table->index(['is_active', 'last_post_at']);
            $table->index(['game_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('communities');
    }
};
