<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'payroll_period',
        'date',
        'updated_by',
        'created_by',
    ];

    public function payrolldetail(){
        return $this->hasMany('App\Models\PayrollDetail');
    }
}
