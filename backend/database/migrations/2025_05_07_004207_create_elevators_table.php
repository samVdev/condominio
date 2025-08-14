<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElevatorsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('elevators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('condominium_id')->nullable();
            $table->boolean('operative')->default(true);
            $table->string('number');
            $table->timestamps();
            
            $table->foreign('condominium_id')->references('id')->on('condominium')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('elevators');
    }
}
