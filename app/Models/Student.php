<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $table = 'students';

    protected $fillable = [
            'student_id',
            'responsible_financial_id',
            'responsible_didactic_id',
            'name',
            'cpf',
            'rg',
            'midia',
            'date_of_birth',
            'email',
            'date_of_register',
            'ra',
            'portal_login',
            'portal_password',
            'obs',
            'phone',
            'mobile_phone',
            'current_class',
            'enrollments_number',
            'gender',
            'status',
            'postal_code',
            'address',
            'address_number',
            'city',
            'neighborhood',
            'hometown',
            'defaulter',
            'origin',
            'origin_name',
            'course_interest',
    ];

}
