<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\NewUser;
use App\Models\User;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\CompanyDetail;
use PDF;
use Mail;
use App\Mail\InvoiceMail;

class InvoiceController extends Controller
{

    public function getPaidInvoiceByAdmin($id)
    {
        $data = Invoice::with('invoicedetail','account')->where('user_id',decrypt($id))->where('paid',1)->orderby('id','DESC')->get();
        $user = User::where('id',decrypt($id))->first();
        return view('admin.invoice.paidinvoice', compact('data','user'));
    }

    public function getInvoice()
    {
        return view('user.invoice.allinvoice');
    }

    public function getAllInvoice()
    {
        $data = Invoice::with('invoicedetail')->where('user_id',Auth::user()->id)->where('paid',0)->orderby('id','DESC')->get();
        // dd($data);
        return view('user.invoice.index', compact('data'));
    }

    public function getPaidInvoice()
    {
        $data = Invoice::with('invoicedetail')->where('user_id',Auth::user()->id)->where('paid',1)->orderby('id','DESC')->get();
        return view('user.invoice.paidinvoice', compact('data'));
    }

    public function paidInvoice(Request $request)
    {
        $data = Invoice::find($request->id);
        $data->paid = "1";
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Invoice Paid Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
    }

    public function getInvoiceDetails($id)
    {
        $data = Invoice::with('invoicedetail')->where('id',decrypt($id))->first();
        return view('user.invoice.invoicedetail', compact('data'));
    }

    public function getInvoiceDetailsByAdmin($id)
    {
        $data = Invoice::with('invoicedetail')->where('id',decrypt($id))->first();
        return view('admin.invoice.invoicedetail', compact('data'));
    }

    public function invoiceEdit($id)
    {
        $data = Invoice::with('invoicedetail')->where('id',$id)->first();
        return view('user.invoice.invoiceedit', compact('data'));
    }

    public function invoiceSendEmail(Request $request)
    {
        
        $data = Invoice::with('invoicedetail')->where('id',$request->id)->first();
        $pdf = PDF::loadView('invoices.invoice', compact('data'));
        $output = $pdf->output();
        file_put_contents(public_path().'/invoice/'.'Invoice#'.$data->invoiceid.'.pdf', $output);
        $array['view'] = 'emails.invoice';
        $array['subject'] = 'Invoice - '.$data->invoiceid;
        $array['name'] = $data->name;
        $array['from'] = $data->company_email;
        $array['company_bname'] = $data->company_bname;
        $array['company_fullname'] = Auth::user()->name;
        $array['company_surname'] = Auth::user()->surname;
        $array['company_tell_no'] = $data->company_tell_no;
        $array['content'] = 'Hi, Your Invoice form has been placed';
        $array['file'] = public_path().'/invoice/Invoice#'.$data->invoiceid.'.pdf';
        $array['file_name'] = 'Invoice#'.$data->invoiceid.'.pdf';
        $array['subjectsingle'] = 'Invoice Placed - '.$data->invoiceid;

        Mail::to($data->email)->queue(new InvoiceMail($array));
        unlink($array['file']);

        $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Mail Send Successfully.</b></div>";
        return response()->json(['status'=> 300,'message'=>$message]);
        
    }

    // public function invoiceSendEmail(Request $request) 
    // {
    //     try{
        
    //         $data = Invoice::with('invoicedetail')->where('id',$request->id)->first();
    //         $pdf = PDF::loadView('invoices.invoice', compact('data'));
    //         $output = $pdf->output();
    //         file_put_contents(public_path().'/invoice/'.'Invoice#'.$data->invoiceid.'.pdf', $output);
    //         $array['view'] = 'emails.invoice';
    //         $array['subject'] = 'Invoice - '.$data->invoiceid;
    //         $array['from'] = 'info@taxdocs.co.uk';
    //         $array['content'] = 'Hi, Your Invoice form has been placed';
    //         $array['file'] = public_path().'/invoice/Invoice#'.$data->invoiceid.'.pdf';
    //         $array['file_name'] = 'Invoice#'.$data->invoiceid.'.pdf';
    //         $array['subjectsingle'] = 'Invoice Placed - '.$data->invoiceid;

    //         Mail::to($data->email)->queue(new InvoiceMail($array));
    //         unlink($array['file']);

    //         $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Mail Send Successfully.</b></div>";
    //         return response()->json(['status'=> 300,'message'=>$message]);

    //     }catch (\Exception $e){
    //         return response()->json(['status'=> 303,'message'=>'Server Error!!']);
    //     }
        
    // }

    public function invoice_download($id)
    {
        $data = Invoice::with('invoicedetail')->where('id',$id)->first();
        $pdf = PDF::loadView('invoices.invoice', compact('data'));
        return $pdf->download('invoice-'.$data->invoiceid.'.pdf');
        
    }

    public function invoice_print($id)
    {
        $data = Invoice::with('invoicedetail')->where('id',$id)->first();
        $pdf = PDF::loadView('invoices.invoice', compact('data'));
        return view('invoices.print', compact('data'));
    }

    public function invoiceShow($id)
    {
        $data = Invoice::with('invoicedetail')->where('id',$id)->first();
        // $pdf = PDF::loadView('invoices.invoice', compact('data'));
        return view('user.invoice.download', compact('data'));
    }

    public function invoiceStore(Request $request)
    {

        if(empty($request->new_user_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select a \"User\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $descriptions = explode(",",$request->description);
        $quantitys = explode(",",$request->quantity);
        $amounts = explode(",",$request->amount);
        $unit_rates = explode(",",$request->unit_rate);
        $vats = explode(",",$request->vat);

        foreach($descriptions as $key => $name){
            if($descriptions[$key] == "" ||  $quantitys[$key] == "" || $amounts[$key] == "" || $unit_rates[$key] == "" ){
            $message ="<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill all field.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
            }
        }


        try{
        
            $invdata = new Invoice;
            $invdata->user_name = $request->user_name;
            $invdata->image = Auth::user()->photo;
            $invdata->user_id = Auth::user()->id;
            $invdata->firm_id = Auth::user()->firm_id;
            $invdata->email = $request->useremail;
            $invdata->new_user_id = $request->new_user_id;
            $invdata->billing_address = $request->useraddress;
            $invdata->terms = $request->terms;
            $invdata->invoice_date = $request->invoice_date;
            $invdata->due_date = $request->due_date;
            $invdata->message_on_invoice = $request->invmessg;
            $invdata->subtotal = $request->subtotal;
            $invdata->total = $request->totalamount;
            $invdata->vat = $request->totalvat;
            $invdata->discount = $request->discount;
            $invdata->invoiceid = $request->invoiceid;
            $invdata->company_name = Auth::user()->bname;
            $invdata->company_vatno = Auth::user()->reg_number;
            $invdata->company_email = Auth::user()->email;
            $invdata->company_tell_no = Auth::user()->phone;
            $invdata->acct_no = Auth::user()->bank_acc_number;
            $invdata->bank = Auth::user()->bank_name;
            $invdata->short_code = Auth::user()->bank_acc_sort_code;
            $invdata->created_by = Auth::user()->id;
            if($invdata->save()){
                foreach($descriptions as $key => $value)
                {
                    $invdtl = new InvoiceDetail();
                    $invdtl->invoice_id = $invdata->id;
                    $invdtl->user_id = Auth::user()->id;
                    $invdtl->description = $descriptions[$key]; 
                    $invdtl->quantity = $quantitys[$key]; 
                    $invdtl->unit_rate = $unit_rates[$key]; 
                    $invdtl->amount = $amounts[$key]; 
                    $invdtl->vat = $vats[$key]; 
                    $invdtl->created_by = Auth::user()->id;
                    $invdtl->save();
                }
    
                $data = Invoice::with('invoicedetail')->where('id','=', $invdata->id)->first();
                $pdf = PDF::loadView('invoices.invoice', compact('data'));
                $output = $pdf->output();
                file_put_contents(public_path().'/invoice/'.'Invoice#'.$data->invoiceid.'.pdf', $output);
                $array['view'] = 'emails.invoice';
                $array['subject'] = 'Invoice - '.$data->invoiceid;
                $array['from'] = 'info@eminentint.com';
                $array['content'] = 'Hi, Your Invoice form has been placed';
                $array['file'] = public_path().'/invoice/Invoice#'.$data->invoiceid.'.pdf';
                $array['file_name'] = 'Invoice#'.$data->invoiceid.'.pdf';
                $array['subjectsingle'] = 'Invoice Placed - '.$data->invoiceid;
                Mail::to($request->useremail)->queue(new InvoiceMail($array));
                unlink($array['file']);
                $message ="<div class='alert alert-success' style='color:white'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Invoice Store Successfully.</b></div>";
                return response()->json(['status'=> 300,'message'=>$message]);
            }

        }catch (\Exception $e){
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }

        
        


    }

    public function invoicePdfStore(Request $request)
    {

        if(empty($request->new_user_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select a \"User\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        
        $descriptions = explode(",",$request->description);
        $quantitys = explode(",",$request->quantity);
        $amounts = explode(",",$request->amount);
        $unit_rates = explode(",",$request->unit_rate);
        $vats = explode(",",$request->vat);

        foreach($descriptions as $key => $name){
            if($descriptions[$key] == "" ||  $quantitys[$key] == "" || $amounts[$key] == "" || $unit_rates[$key] == ""  ){
            $message ="<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill all field.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
            }
        }

        $newuserinfo = NewUser::where('id',$request->new_user_id)->first();
        try{
        
            $data = new Invoice;
            $data->user_name = $request->new_user_id;
            if (isset(Auth::user()->photo)) {
                $data->image = Auth::user()->photo;
            }else{
                $data->image = "default.png";
            }
            
            $data->user_id = Auth::user()->id;
            $data->firm_id = Auth::user()->firm_id;
            $data->email = $newuserinfo->email;
            $data->new_user_id = $request->new_user_id;
            $data->billing_address = $newuserinfo->address;
            $data->post_code = $newuserinfo->post_code;
            $data->name = $newuserinfo->name;
            $data->invoice_date = $request->invoice_date;
            $data->message_on_invoice = $request->invmessg;
            $data->subtotal = $request->subtotal;
            $data->total = $request->totalamount;
            $data->vat = $request->totalvat;
            $data->discount = $request->discount;
            $data->invoiceid = date('his');
            $data->company_name = Auth::user()->name;
            $data->company_surname = Auth::user()->surname;
            $data->company_bname = Auth::user()->bname;
            $data->company_house_number = Auth::user()->house_number;
            $data->company_vatno = Auth::user()->reg_number;
            $data->company_email = Auth::user()->email;
            $data->company_tell_no = Auth::user()->phone;
            $data->company_street_name = Auth::user()->street_name;
            $data->company_post_code = Auth::user()->postcode;
            $data->company_town = Auth::user()->town;
            $data->acct_no = Auth::user()->bank_acc_number;
            $data->bank = Auth::user()->bank_name;
            $data->short_code = Auth::user()->bank_acc_sort_code;
            $data->created_by = Auth::user()->id;
            if($data->save()){
                foreach($descriptions as $key => $value)
                {
                    $invdtl = new InvoiceDetail();
                    $invdtl->invoice_id = $data->id;
                    $invdtl->user_id = Auth::user()->id;
                    $invdtl->description = $descriptions[$key]; 
                    $invdtl->quantity = $quantitys[$key]; 
                    $invdtl->unit_rate = $unit_rates[$key]; 
                    $invdtl->amount = $amounts[$key]; 
                    $invdtl->vat = $vats[$key]; 
                    $invdtl->created_by = Auth::user()->id;
                    $invdtl->save();
                }
                //stores the pdf for invoice
                $pdf = PDF::loadView('invoices.invoice', compact('data'));
                
                $message ="<div class='alert alert-success' style='color:white'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Invoice Store Successfully.</b></div>";
                return response()->json(['status'=> 300,'id'=>$data->id,'message'=>$message]);
                
            }

        }catch (\Exception $e){
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }

        
    }

    public function delete($id)
    {
        if(Invoice::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Listing Deleted']);
        }
        else{
            return response()->json(['success'=>false,'message'=>'Update Failed']);
        }
    }

    public function invoiceUpdate(Request $request)
    {

        if(empty($request->new_user_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select a \"User\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        $invdtlids = explode(",",$request->invdtlid);
        $descriptions = explode(",",$request->description);
        $quantitys = explode(",",$request->quantity);
        $amounts = explode(",",$request->amount);
        $unit_rates = explode(",",$request->unit_rate);
        $vats = explode(",",$request->vat);


        foreach($descriptions as $key => $name){
            if($descriptions[$key] == "" ||  $quantitys[$key] == "" || $amounts[$key] == "" || $unit_rates[$key] == ""  ){
            $message ="<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill all field.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
            }
        }

        
        $newuserinfo = NewUser::where('id',$request->new_user_id)->first();
        $invdata = Invoice::find($request->dataid);
        $invdata->user_name = $request->new_user_id;
        if (isset(Auth::user()->photo)) {
            $invdata->image = Auth::user()->photo;
        }else{
            $invdata->image = "default.png";
        }
        
        $invdata->user_id = Auth::user()->id;
        $invdata->firm_id = Auth::user()->firm_id;
        $invdata->email = $newuserinfo->email;
        $invdata->new_user_id = $request->new_user_id;
        $invdata->billing_address = $newuserinfo->address;
        $invdata->post_code = $newuserinfo->post_code;
        $invdata->name = $newuserinfo->name;
        $invdata->invoice_date = $request->invoice_date;
        $invdata->message_on_invoice = $request->invmessg;
        $invdata->subtotal = $request->subtotal;
        $invdata->total = $request->totalamount;
        $invdata->vat = $request->totalvat;
        $invdata->discount = $request->discount;
        $invdata->company_name = Auth::user()->name;
        $invdata->company_surname = Auth::user()->surname;
        $invdata->company_bname = Auth::user()->bname;
        $invdata->company_house_number = Auth::user()->house_number;
        $invdata->company_vatno = Auth::user()->reg_number;
        $invdata->company_email = Auth::user()->email;
        $invdata->company_tell_no = Auth::user()->phone;
        $invdata->company_street_name = Auth::user()->street_name;
        $invdata->company_post_code = Auth::user()->postcode;
        $invdata->company_town = Auth::user()->town;
        $invdata->acct_no = Auth::user()->bank_acc_number;
        $invdata->bank = Auth::user()->bank_name;
        $invdata->short_code = Auth::user()->bank_acc_sort_code;
        $invdata->updated_by = Auth::user()->id;
        if($invdata->save()){

        foreach($descriptions as $key => $value)
        {
            if(isset($invdtlids[$key])){

                $invdtl = InvoiceDetail::findOrFail($invdtlids[$key]);
                $invdtl->invoice_id = $invdata->id;
                $invdtl->user_id = Auth::user()->id;
                $invdtl->description = $descriptions[$key]; 
                $invdtl->quantity = $quantitys[$key]; 
                $invdtl->unit_rate = $unit_rates[$key]; 
                $invdtl->amount = $amounts[$key]; 
                $invdtl->vat = $vats[$key]; 
                $invdtl->updated_by = Auth::user()->id;
                $invdtl->save();

            }else{

                $invdtl = new InvoiceDetail();
                $invdtl->invoice_id = $invdata->id;
                $invdtl->user_id = Auth::user()->id;
                $invdtl->description = $descriptions[$key]; 
                $invdtl->quantity = $quantitys[$key]; 
                $invdtl->unit_rate = $unit_rates[$key]; 
                $invdtl->amount = $amounts[$key]; 
                $invdtl->vat = $vats[$key]; 
                $invdtl->created_by = Auth::user()->id;
                $invdtl->save();
            }

        }
            $message ="<div class='alert alert-success' style='color:white'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Invoice Update Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        
    }


}
