<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProvisionBalancesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('provision_balances', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('service_id');
            $table->decimal('current_balance', 12, 2)->default(0.00);

            $table->timestamps();

            $table->foreign('service_id')
                ->references('id')
                ->on('services')
                ->onDelete('cascade');

            $table->unique('service_id');
        });

        Schema::table('provisions', function (Blueprint $table) {
            $table->unsignedBigInteger('balance_id');
            $table->foreign('balance_id')->references('id')->on('provision_balances')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provision_balances');
    }
}
