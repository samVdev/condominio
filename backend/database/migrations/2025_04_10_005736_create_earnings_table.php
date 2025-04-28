<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarningsTable extends Migration
{
    public function up()
    {
        Schema::create('earnings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('type_id');
            $table->foreignId('condominium_id')->nullable();
            $table->foreignId('facture_id')->nullable()->constrained('factures')->onDelete('set null');

            $table->decimal('amount_dollars', 10, 2);
            $table->decimal('dollar_value', 10, 2);
            $table->string('image')->nullable();

            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('type_earnings')->onDelete('set null');
            $table->foreign('condominium_id')->references('id')->on('condominium')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('earnings');
    }
}
