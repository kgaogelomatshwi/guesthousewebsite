<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('external_reviews', function (Blueprint $table): void {
            $table->id();
            $table->string('source', 50);
            $table->string('external_id')->nullable();
            $table->string('author_name')->nullable();
            $table->unsignedTinyInteger('rating')->default(0);
            $table->text('comment')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->string('review_url')->nullable();
            $table->string('avatar_url')->nullable();
            $table->boolean('is_published')->default(true);
            $table->json('raw_payload')->nullable();
            $table->timestamps();

            $table->index(['source', 'rating', 'is_published']);
            $table->index('reviewed_at');
            $table->unique(['source', 'external_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('external_reviews');
    }
};
