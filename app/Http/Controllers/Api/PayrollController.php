<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Models\PayrollDetail;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class PayrollController extends BaseController
{
    public function getPayrollHistory()
    {
        $data = Payroll::with('payrolldetail')->orderby('id','DESC')->where('user_id',Auth::user()->id)->get();
        if($data == null){
            $data = 'Data Not Found';
        }
        $responseArray = [
            'status'=>'ok',
            'data'=>$data
        ]; 
        return response()->json($responseArray,200);
    }

    public function index()
    {
        $data = Payroll::with('payrolldetail')->orderby('id','DESC')->where('user_id',Auth::user()->id)->limit(1)->first();
        if($data == null){
            $data = 'Data Not Found';
        }
        $responseArray = [
            'status'=>'ok',
            'data'=>$data
        ]; 
        return response()->json($responseArray,200);
    }

    public function payrollDetails($id)
    {
        $data = PayrollDetail::where('payroll_id', $id)->orderby('id','DESC')->get();
        if($data == null){
            $data = 'Data Not Found';
        }
        $responseArray = [
            'status'=>'ok',
            'data'=>$data
        ]; 
        return response()->json($responseArray,200);
    }

    public function payrollStore(Request $request)
    {
        

        if(empty($request->date)){
            $responseArray = [
                'status'=>'false',
                'messege'=>'Please fill date field!!'
            ]; 
            return response()->json($responseArray,202);
        }

        if(empty($request->payroll_period)){
            $responseArray = [
                'status'=>'false',
                'messege'=>'Please fill Payroll Period field!!'
            ]; 
            return response()->json($responseArray,202);
        }

        if(empty($request->company_name)){
            $responseArray = [
                'status'=>'false',
                'messege'=>'Please fill Company Name field!!'
            ]; 
            return response()->json($responseArray,202);
        }

            
            $payroll = new Payroll();
            $payroll->date = $request->date;
            $payroll->payroll_period = $request->payroll_period;
            $payroll->company_name = $request->company_name;
            $payroll->frequency = $request->frequency;
            $payroll->user_id = Auth::user()->id;
            $payroll->firm_id = Auth::user()->firm_id;
            $payroll->created_by= Auth::user()->id;
            if ($payroll->save()) {

                $payrolldetails = json_decode($request->payrolldetails, true);
    
                foreach ($payrolldetails as $item)
                {
                    $payrolldtl['payroll_id'] = $payroll->id;
                    $payrolldtl['user_id'] = Auth::user()->id;
                    $payrolldtl['name'] = $item['name'];
                    $payrolldtl['national_insurance'] = $item['national_insurance'];
                    $payrolldtl['pay_rate'] = $item['pay_rate'];
                    $payrolldtl['working_hour'] = $item['working_hour'];
                    $payrolldtl['holiday_hour'] = $item['holiday_hour'];
                    $payrolldtl['overtime_hour'] = $item['overtime_hour'];
                    $payrolldtl['total_paid_hour'] = $item['total_paid_hour'];
                    $payrolldtl['note'] = $item['note'];
                    $payrolldtl['created_by'] = Auth::user()->id;
                    PayrollDetail::create($payrolldtl);
                }

                $data = Payroll::with('payrolldetail')->where('id', $payroll->id)->first();
                
                $success['response'] = 'Payroll create successfully';
                $success['payroll'] = $data;
                return response()->json(['success'=>true,'response'=> $success], 200);
            }else {
                return response()->json(['success'=>true,'response'=> 'Server Error!!'], 404);
            }

    }


    
}
