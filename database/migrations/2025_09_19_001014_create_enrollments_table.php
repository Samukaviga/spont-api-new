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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('enrollments_id')->unique();
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('course_id')->nullable();
            $table->unsignedBigInteger('class_id')->nullable();
            $table->string('student_name')->nullable();
            $table->string('class_name')->nullable();
            $table->string('course_name')->nullable();
            $table->string('status')->nullable();
            $table->date('start_date')->nullable();
            $table->date('deadline_date')->nullable();
            $table->date('enrollment_date')->nullable();
            $table->string('contractor')->nullable();
            $table->string('financial_released')->nullable();
            $table->string('contract_number')->nullable();
            $table->string('type_of_contract')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
