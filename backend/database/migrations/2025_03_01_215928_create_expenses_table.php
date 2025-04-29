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
            $table->decimal('amount_dollars', 10, 2); // Monto total de la factura
            $table->decimal('dollar_value', 10, 2); // Precio del dólar al momento del gasto
            $table->decimal('mount_prov', 10, 2)->default(0); // Monto de las provisiones
            $table->decimal('mount_fund', 10, 2)->default(0); // Monto del fondo de reserva
            $table->string('image')->nullable();
            $table->timestamps();

            // Definir las claves foráneas
            $table->foreign('service_id')->references('id')->on('services')->onDelete('set null');
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