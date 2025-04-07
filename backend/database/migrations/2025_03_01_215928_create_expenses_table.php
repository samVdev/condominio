<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('condominium_id')->nullable();
            $table->decimal('amount_dollars', 10, 2); // Monto del gasto
            $table->decimal('dollar_value', 10, 2); // Precio del dólar al momento del gasto
            $table->string('image')->nullable();
            $table->timestamps();

            // Definir las claves foráneas
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->foreign('condominium_id')->references('id')->on('condominium')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
}