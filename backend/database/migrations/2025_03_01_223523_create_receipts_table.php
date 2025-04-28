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
            $table->decimal('porcent_alicuota', 5, 2);
            $table->boolean('accepted')->default(false);
            $table->boolean('withMora')->default(false); 
            $table->boolean('withDays')->default(false); 
            $table->decimal('mount_prov', 10, 2)->default(0); // Monto de las provisiones
            $table->decimal('mount_exp', 10, 2); // Monto de los gastos
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