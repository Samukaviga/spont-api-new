<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $table = 'enrollments';

    protected $fillable = [
            'enrollments_id',
            'student_id',
            'course_id',
            'class_id',
            'student_name',
            'class_name',
            'course_name',
            'status',
            'start_date',
            'deadline_date',
            'enrollment_date',
            'contractor',
            'financial_released',
            'contract_number',
    ];

}
