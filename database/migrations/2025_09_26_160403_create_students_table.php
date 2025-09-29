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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->unique();
            $table->unsignedBigInteger('responsible_financial_id')->nullable();
            $table->unsignedBigInteger('responsible_didactic_id')->nullable();

            $table->string('name')->nullable();
            $table->string('cpf')->nullable();
            $table->string('rg')->nullable();
            $table->string('midia')->nullable();
            $table->date('date_of_birth')->nullable();

            $table->string('email')->nullable();
            $table->date('date_of_register')->nullable();
            $table->string('ra')->nullable();
            $table->string('portal_login')->nullable();
            $table->string('portal_password')->nullable();
            $table->string('obs')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('current_class')->nullable();
            $table->string('enrollments_number')->nullable();
            $table->string('gender')->nullable();
            $table->string('status')->nullable();

            $table->string('postal_code')->nullable();
            $table->string('address')->nullable();
            $table->string('address_number')->nullable();
            $table->string('city')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('hometown')->nullable();
            $table->string('defaulter')->nullable();
            $table->string('origin')->nullable();
            $table->string('origin_name')->nullable();
            $table->string('course_interest')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
