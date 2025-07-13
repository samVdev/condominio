<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->text('link')->nullable();
            $table->dateTime('meeting_date');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('description_end')->nullable();
            $table->boolean('end')->default(false);
            $table->timestamps();
            
            // Indexes
            $table->index('meeting_date');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('boards');
    }
};
