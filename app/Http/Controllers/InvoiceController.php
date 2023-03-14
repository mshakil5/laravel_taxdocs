<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use PDF;
use Mail;
use App\Mail\MyMembershipMail;

class InvoiceController extends Controller
{
    public function getInvoice()
    {
        return view('user.invoice.allinvoice');
    }

    public function invoice_download($id)
    {
        $data = Invoice::with('invoicedetail')->where('id',$id)->first();
        $pdf = PDF::loadView('invoices.invoice', compact('data'));
        return $pdf->download('invoice-'.$data->invoiceid.'.pdf');
        // return view('invoices.invoice', compact('data'));
    }

    public function invoiceStore(Request $request)
    {

        if($request->image == 'null'){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Image\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->new_user_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select a \"User\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        
        
        $product_names = explode(",",$request->product_name);
        $descriptions = explode(",",$request->description);
        $quantitys = explode(",",$request->quantity);
        $amounts = explode(",",$request->amount);
        $unit_rates = explode(",",$request->unit_rate);
        $vats = explode(",",$request->vat);

        $data = new Invoice;
        $data->user_name = $request->user_name;

        // intervention
        if ($request->image != 'null') {
            $request->validate([
                'image' => 'mimes:jpeg,png,jpg,gif,svg,pdf|max:8048',
            ]);
            $rand = mt_rand(100000, 999999);
            $imageName = time(). $rand .'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data->image= $imageName;
        }
        // end

        $data->user_id = Auth::user()->id;
        $data->email = $request->useremail;
        $data->new_user_id = $request->new_user_id;
        $data->billing_address = $request->useraddress;
        $data->terms = $request->terms;
        $data->invoice_date = $request->invoice_date;
        $data->due_date = $request->due_date;
        $data->message_on_invoice = $request->invmessg;
        $data->message_on_appointment = $request->appointmentmessg;
        $data->tomail = $request->tomail;
        $data->subjectmail = $request->subjectmail;
        $data->mailbody = $request->mailbody;
        $data->subtotal = $request->subtotal;
        $data->total = $request->totalamount;
        $data->vat = $request->totalvat;
        $data->discount = $request->discount;
        $data->invoiceid = $request->invoiceid;

        $data->company_name = $request->company_name;
        $data->company_vatno = $request->company_vatno;
        $data->company_email = $request->company_email;
        $data->company_tell_no = $request->company_tell_no;
        $data->acct_no = $request->acct_no;
        $data->bank = $request->bank;
        $data->short_code = $request->short_code;
        $data->created_by = Auth::user()->id;
        if($data->save()){

            foreach($product_names as $key => $value)
            {
                
                $invdtl = new InvoiceDetail();
                $invdtl->invoice_id = $data->id;
                $invdtl->user_id = Auth::user()->id;
                $invdtl->product = $product_names[$key];
                $invdtl->description = $descriptions[$key]; 
                $invdtl->quantity = $quantitys[$key]; 
                $invdtl->unit_rate = $unit_rates[$key]; 
                $invdtl->amount = $amounts[$key]; 
                $invdtl->vat = $vats[$key]; 
                $invdtl->created_by = Auth::user()->id;
                $invdtl->save();
                
            }

            // $data = Invoice::with('invoicedetail')->where('id','=', $data->id)->first();

            // $pdf = PDF::loadView('invoices.invoice', compact('data'));
            // $output = $pdf->output();
            // file_put_contents(public_path().'/invoice/'.'Invoice#'.$data->invoiceid.'.pdf', $output);
            // $array['view'] = 'emails.invoice';
            // $array['subject'] = 'Invoice - '.$data->invoiceid;
            // $array['from'] = 'info@taxdocs.com';
            // $array['content'] = 'Hi, Your Invoice form has been placed';
            // $array['file'] = public_path().'/invoice/Invoice#'.$data->invoiceid.'.pdf';
            // $array['file_name'] = 'Invoice#'.$data->invoiceid.'.pdf';
            // $array['subjectsingle'] = 'Invoice Placed - '.$data->invoiceid;
            // Mail::to('kmushakil22@gmail.com')->queue(new MyMembershipMail($array));
            // unlink($array['file']);



            $message ="<div class='alert alert-success' style='color:white'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Invoice Store Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);

            
        }
        


    }

    public function invoicePdfStore(Request $request)
    {
        if(empty($request->new_user_id)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Select a \"User\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        
        $product_names = explode(",",$request->product_name);
        $descriptions = explode(",",$request->description);
        $quantitys = explode(",",$request->quantity);
        $amounts = explode(",",$request->amount);
        $unit_rates = explode(",",$request->unit_rate);
        $vats = explode(",",$request->vat);

        $data = new Invoice;
        $data->user_name = $request->user_name;

        // intervention
        if ($request->image != 'null') {
            $request->validate([
                'image' => 'mimes:jpeg,png,jpg,gif,svg,pdf|max:8048',
            ]);
            $rand = mt_rand(100000, 999999);
            $imageName = time(). $rand .'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data->image= $imageName;
        }
        // end

        $data->user_id = Auth::user()->id;
        $data->email = $request->useremail;
        $data->new_user_id = $request->new_user_id;
        $data->billing_address = $request->useraddress;
        $data->terms = $request->terms;
        $data->invoice_date = $request->invoice_date;
        $data->due_date = $request->due_date;
        $data->message_on_invoice = $request->invmessg;
        $data->subtotal = $request->subtotal;
        $data->total = $request->totalamount;
        $data->vat = $request->totalvat;
        $data->discount = $request->discount;
        $data->invoiceid = $request->invoiceid;
        $data->company_name = $request->company_name;
        $data->company_vatno = $request->company_vatno;
        $data->company_email = $request->company_email;
        $data->company_tell_no = $request->company_tell_no;
        $data->acct_no = $request->acct_no;
        $data->bank = $request->bank;
        $data->short_code = $request->short_code;
        $data->created_by = Auth::user()->id;
        if($data->save()){

            foreach($product_names as $key => $value)
            {
                
                $invdtl = new InvoiceDetail();
                $invdtl->invoice_id = $data->id;
                $invdtl->user_id = Auth::user()->id;
                $invdtl->product = $product_names[$key];
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
            // return $pdf->download('order-'.$data->invoiceid .'.pdf');

            
        }
        


    }
}
