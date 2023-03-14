<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Models\PayrollDetail;
use Illuminate\support\Facades\Auth;

class PayrollController extends Controller
{
    public function index()
    {
        $data = Payroll::with('payrolldetail')->orderby('id','ASC')->where('user_id',Auth::user()->id)->first();
        return view('user.payroll.index',compact('data'));
    }
    
    public function payrollStore(Request $request)
    {
        

        if(empty($request->date)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Date\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->payroll_period)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Payroll Period\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->company_name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Company Name\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }





            try{
                $payroll = new Payroll();
                $payroll->date = $request->date;
                $payroll->payroll_period = $request->payroll_period;
                $payroll->company_name = $request->company_name;
                $payroll->user_id = Auth::user()->id;
                $payroll->created_by= Auth::user()->id;
            if ($payroll->save()) {
                
                foreach($request->input('name') as $key => $value)
                    {
                        
                        $payrolldtl = new PayrollDetail();
                        $payrolldtl->payroll_id = $payroll->id;
                        $payrolldtl->user_id = Auth::user()->id;
                        $payrolldtl->name = $request->get('name')[$key];
                        $payrolldtl->national_insurance = $request->get('national_insurance')[$key]; 
                        $payrolldtl->frequency = $request->get('frequency')[$key]; 
                        $payrolldtl->pay_rate = $request->get('pay_rate')[$key]; 
                        $payrolldtl->working_hour = $request->get('working_hour')[$key]; 
                        $payrolldtl->holiday_hour = $request->get('holiday_hour')[$key]; 
                        $payrolldtl->overtime_hour = $request->get('overtime_hour')[$key]; 
                        $payrolldtl->total_paid_hour = $request->get('total_paid_hour')[$key]; 
                        $payrolldtl->note = $request->get('note')[$key]; 
                        $payrolldtl->created_by = Auth::user()->id;
                        $payrolldtl->save();
                        
                    }

                $message ="<div class='alert alert-success' style='color:white'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Payroll Store Successfully.</b></div>";
                return response()->json(['status'=> 300,'message'=>$message]);
            }

            }catch (\Exception $e){
                return response()->json(['status'=> 303,'message'=>'Server Error!!']);

            }

    }

    public function payrollUpdate(Request $request)
    {

        


        $frequencys = $request->frequency;
        $national_insurances = $request->national_insurance;
        $names = $request->name;
        $holiday_hours = $request->holiday_hour;
        $working_hours = $request->working_hour;
        $pay_rates = $request->pay_rate;
        $notes = $request->note;
        $total_paid_hours = $request->total_paid_hour;
        $overtime_hours = $request->overtime_hour;
        $payrolldtl_ids = $request->payrolldtl_id;

        foreach($names as $key => $name){
            if($frequencys[$key] == "" || $national_insurances == "" || $holiday_hours[$key] == "" || $working_hours[$key] == "" || $pay_rates[$key] == "" || $notes[$key] == "" || $total_paid_hours[$key] == "" || $overtime_hours[$key] == "" || $names[$key] == ""){
            $message ="<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill all field.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
            }
        }

        $pdata = Payroll::find($request->payroll_id);
        $pdata->date = $request->date;
        $pdata->payroll_period = $request->payroll_period;
        $pdata->company_name = $request->company_name;
        $pdata->updated_by = Auth::user()->id;

        
        if ($pdata->save()) {

        foreach($request->name as $key => $name)
        {
            if(isset($payrolldtl_ids[$key])){

            $data = PayrollDetail::findOrFail($payrolldtl_ids[$key]);
            $data->national_insurance = $national_insurances[$key];
            $data->name = $name;
            $data->holiday_hour = $holiday_hours[$key];
            $data->frequency = $frequencys[$key];
            $data->working_hour = $working_hours[$key];
            $data->pay_rate = $pay_rates[$key];
            $data->note = $notes[$key];
            $data->total_paid_hour = $total_paid_hours[$key];
            $data->overtime_hour = $overtime_hours[$key];
            $data->updated_by = Auth::user()->id;
            $data->save();

            }else{

            $data = new PayrollDetail;
            $data->national_insurance = $national_insurances[$key];
            $data->user_id = Auth::user()->id;
            $data->payroll_id = $pdata->id;
            $data->name = $name;
            $data->holiday_hour = $holiday_hours[$key];
            $data->frequency = $frequencys[$key];
            $data->working_hour = $working_hours[$key];
            $data->pay_rate = $pay_rates[$key];
            $data->note = $notes[$key];
            $data->total_paid_hour = $total_paid_hours[$key];
            $data->overtime_hour = $overtime_hours[$key];
            $data->created_by = Auth::user()->id;
            $data->save();
            }

        }

        
        $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data updated successfully.</b></div>";
        return response()->json(['status'=> 300,'message'=>$message]);

        
        }

        


    }


    

    

    

    public function payrollDetails($id)
    {
        $data = PayrollDetail::where('payroll_id', $id)->orderby('id','DESC')->get();
        return view('user.payroll.payrolldtl',compact('data'));
    }

    public function showPayroll($id)
    {
        $id = decrypt($id);
        $data = Payroll::with('payrolldetail')->orderby('id','ASC')->where('user_id',$id)->first();
        return view('admin.payroll.index',compact('data'));
    }

    public function showPayrollDetails($id)
    {
        $id = decrypt($id);
        $data = PayrollDetail::orderby('id','DESC')->where('payroll_id',$id)->get();
        return view('admin.payroll.payrolldtl',compact('data'));
    }

}
