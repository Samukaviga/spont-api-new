<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
    protected $table = 'financial';

    protected $fillable = [
        'unit_code',
        'account_receive_id',
        'student_id',
        'student_name',
        'number_of_parcels',
        'contract_number',
        'total_gross_value',
        'total_net_value',
        'total_discount_reais',
        'total_discount_percentage',
        'category',
    ];

}
