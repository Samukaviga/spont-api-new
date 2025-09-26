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
        Schema::create('financial', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_receive_id')->unique();
            $table->unsignedBigInteger('unit_code')->nullable();
            $table->unsignedBigInteger('student_id')->nullable();

            $table->string('student_name')->nullable();
            $table->string('number_of_parcels')->nullable();
            $table->string('contract_number')->nullable();
            $table->string('total_gross_value')->nullable();
            $table->string('total_net_value')->nullable();
            $table->string('total_discount_reais')->nullable();
            $table->string('total_discount_percentage')->nullable();
            $table->string('category')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('financial');
    }
};
