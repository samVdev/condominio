<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElevatorDamageHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('elevator_damage_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('expense_id')->nullable();
            $table->foreignId('elevator_id')->constrained()->onDelete('cascade');
            $table->string('image')->nullable();
            $table->text('description');
            $table->boolean('status');
            $table->timestamps();
            $table->foreign('expense_id')->references('id')->on('expenses')->onDelete('set null');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elevator_damage_histories');
    }
}
