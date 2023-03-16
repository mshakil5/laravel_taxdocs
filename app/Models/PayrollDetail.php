<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'payroll_id',
        'national_insurance',
        'frequency',
        'pay_rate',
        'working_hour',
        'holiday_hour',
        'overtime_hour',
        'total_paid_hour',
        'note',
        'updated_by',
        'created_by',
    ];

    public function payroll(){
        return $this->belongsTo('App\Models\Payroll');
    }
}
