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
            $table->unsignedBigInteger('persona_id'); // Relación con la persona
            $table->decimal('total_pagado', 10, 2); // Total pagado
            $table->string('cedula'); // Cédula de la persona
            $table->string('referencia'); // Referencia de 6 dígitos
            $table->boolean('accepted')->default(false); // Referencia de 6 dígitos
            $table->timestamps();

            // Definir las claves foráneas
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