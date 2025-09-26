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
        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_receive_id'); // ContaReceberID
            $table->unsignedInteger('installment_number');   // NumeroParcela
            $table->string('status')->nullable();            // SituacaoParcela
            $table->string('cnab_status')->nullable();       // SituacaoCNAB
            $table->date('due_date')->nullable();            // Vencimento
            $table->string('value')->nullable();     // ValorParcela
            $table->string('paid_value', )->nullable(); // ValorPago
            $table->string('invoice_number')->nullable();    // NumeroBoleto
            $table->string('billing_type')->nullable();      // FormaCobranca
            $table->string('category')->nullable();          // Categoria
            $table->timestamps();

            $table->unique(['account_receive_id', 'installment_number']); // <- chave única
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
