<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->nullable()->after('id');
            $table->date('fecha');
            //$table->string('number_month', 2)->unique();
            $table->string('number_month', 2);
            $table->decimal('porcent_first_five_days', 10, 2);
            $table->decimal('total_dollars', 10, 2); 
            $table->decimal('dollar_bcv', 10, 2); 
            $table->timestamps();
        });


        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('facture_id')->nullable()->constrained('factures')->onDelete('set null');
        });

        Schema::table('receipts', function (Blueprint $table) {
            $table->foreignId('facture_id')->nullable()->constrained('factures')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
