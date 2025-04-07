<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('persona_id'); 
            $table->unsignedBigInteger('user_id')->nullable(); 
            $table->decimal('dolarBCV', 10, 2); 
            $table->decimal('total_pagado', 10, 2); 
            $table->string('cedula'); 
            $table->string('referencia');
            $table->boolean('accepted')->default(false);
            $table->boolean('withMora')->default(false); 
            $table->boolean('withDays')->default(false); 
            $table->timestamps();

            // Definir las claves foráneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('persona_id')->references('id')->on('personas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receipts');
    }
}