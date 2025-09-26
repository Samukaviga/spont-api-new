<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $table = 'installments';

    protected $fillable = [
            'account_receive_id',
            'installment_number',
            'status',
            'cnab_status',
            'due_date',
            'value',
            'paid_value',
            'invoice_number',
            'billing_type',
            'category',
    ];


}
