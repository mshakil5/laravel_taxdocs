<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use PDF;
use Mail;
use App\Mail\InvoiceMail;

class InvoiceController extends Controller
{
    public function getInvoice()
    {
        return view('user.invoice.allinvoice');
    }

    public function getAllInvoice()
    {
        $data = Invoice::with('invoicedetail')->where('user_id',Auth::user()->id)->orderby('id','DESC')->get();
        return view('user.invoice.index', compact('data'));
    }

    public function getInvoiceDetails($id)
    {
        $data = InvoiceDetail::where('invoice_id',$id)->get();
        return view('user.invoice.invoicedetail', compact('data'));
    }

    public function invoiceEdit($id)
    {
        $data = Invoice::with('invoicedetail')->where('id',$id)->first();
        return view('user.invoice.invoiceedit', compact('data'));
    }

    public function invoiceSendEmail($id)
    {
        $data = Invoice::with('invoicedetail')->where('id',$id)->first();

        $pdf = PDF::loadView('invoices.invoice', compact('data'));
        $output = $pdf->output();
        file_put_contents(public_path().'/invoice/'.'Invoice#'.$data->invoiceid.'.pdf', $output);
        $array['view'] = 'emails.invoice';
        $array['subject'] = 'Invoice - '.$data->invoiceid;
        $array['from'] = 'info@taxdocs.com';
        $array['content'] = 'Hi, Your Invoice form has been placed';
        $array['file'] = public_path().'/invoice/Invoice#'.$data->invoiceid.'.pdf';
        $array['file_name'] = 'Invoice#'.$data->invoiceid.'.pdf';
        $array['subjectsingle'] = 'Invoice Placed - '.$data->invoiceid;
        Mail::to($data->email)->queue(new InvoiceMail($array));
        unlink($array['file']);


        return redirect()->route('user.allinvoice');
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

        $invdata = new Invoice;
        $invdata->user_name = $request->user_name;

        // intervention
        if ($request->image != 'null') {
            $request->validate([
                'image' => 'mimes:jpeg,png,jpg,gif,svg,pdf|max:8048',
            ]);
            $rand = mt_rand(100000, 999999);
            $imageName = time(). $rand .'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $invdata->image= $imageName;
        }
        // end

        $invdata->user_id = Auth::user()->id;
        $invdata->email = $request->useremail;
        $invdata->new_user_id = $request->new_user_id;
        $invdata->billing_address = $request->useraddress;
        $invdata->terms = $request->terms;
        $invdata->invoice_date = $request->invoice_date;
        $invdata->due_date = $request->due_date;
        $invdata->message_on_invoice = $request->invmessg;
        $invdata->message_on_appointment = $request->appointmentmessg;
        $invdata->tomail = $request->tomail;
        $invdata->subjectmail = $request->subjectmail;
        $invdata->mailbody = $request->mailbody;
        $invdata->subtotal = $request->subtotal;
        $invdata->total = $request->totalamount;
        $invdata->vat = $request->totalvat;
        $invdata->discount = $request->discount;
        $invdata->invoiceid = $request->invoiceid;
        $invdata->company_name = $request->company_name;
        $invdata->company_vatno = $request->company_vatno;
        $invdata->company_email = $request->company_email;
        $invdata->company_tell_no = $request->company_tell_no;
        $invdata->acct_no = $request->acct_no;
        $invdata->bank = $request->bank;
        $invdata->short_code = $request->short_code;
        $invdata->created_by = Auth::user()->id;
        if($invdata->save()){
            foreach($product_names as $key => $value)
            {
                $invdtl = new InvoiceDetail();
                $invdtl->invoice_id = $invdata->id;
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

            $data = Invoice::with('invoicedetail')->where('id','=', $invdata->id)->first();
            $pdf = PDF::loadView('invoices.invoice', compact('data'));
            $output = $pdf->output();
            file_put_contents(public_path().'/invoice/'.'Invoice#'.$data->invoiceid.'.pdf', $output);
            $array['view'] = 'emails.invoice';
            $array['subject'] = 'Invoice - '.$data->invoiceid;
            $array['from'] = 'info@taxdocs.com';
            $array['content'] = 'Hi, Your Invoice form has been placed';
            $array['file'] = public_path().'/invoice/Invoice#'.$data->invoiceid.'.pdf';
            $array['file_name'] = 'Invoice#'.$data->invoiceid.'.pdf';
            $array['subjectsingle'] = 'Invoice Placed - '.$data->invoiceid;
            Mail::to($request->useremail)->queue(new InvoiceMail($array));
            unlink($array['file']);

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


        $invdtlids = explode(",",$request->invdtlid);
        $product_names = explode(",",$request->product_name);
        $descriptions = explode(",",$request->description);
        $quantitys = explode(",",$request->quantity);
        $amounts = explode(",",$request->amount);
        $unit_rates = explode(",",$request->unit_rate);
        $vats = explode(",",$request->vat);

        $invdata = Invoice::find($request->dataid);
        $invdata->user_name = $request->user_name;
        // intervention
        if ($request->image != 'null') {
            $request->validate([
                'image' => 'mimes:jpeg,png,jpg,gif,svg,pdf|max:8048',
            ]);
            $rand = mt_rand(100000, 999999);
            $imageName = time(). $rand .'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $invdata->image= $imageName;
        }
        // end

        $invdata->user_id = Auth::user()->id;
        $invdata->email = $request->useremail;
        $invdata->new_user_id = $request->new_user_id;
        $invdata->billing_address = $request->useraddress;
        $invdata->terms = $request->terms;
        $invdata->invoice_date = $request->invoice_date;
        $invdata->due_date = $request->due_date;
        $invdata->message_on_invoice = $request->invmessg;
        $invdata->message_on_appointment = $request->appointmentmessg;
        $invdata->tomail = $request->tomail;
        $invdata->subjectmail = $request->subjectmail;
        $invdata->mailbody = $request->mailbody;
        $invdata->subtotal = $request->subtotal;
        $invdata->total = $request->totalamount;
        $invdata->vat = $request->totalvat;
        $invdata->discount = $request->discount;
        $invdata->invoiceid = $request->invoiceid;
        $invdata->company_name = $request->company_name;
        $invdata->company_vatno = $request->company_vatno;
        $invdata->company_email = $request->company_email;
        $invdata->company_tell_no = $request->company_tell_no;
        $invdata->acct_no = $request->acct_no;
        $invdata->bank = $request->bank;
        $invdata->short_code = $request->short_code;
        $invdata->created_by = Auth::user()->id;
        if($invdata->save()){

        foreach($product_names as $key => $value)
        {
            if(isset($invdtlids[$key])){

                $invdtl = InvoiceDetail::findOrFail($invdtlids[$key]);
                $invdtl->invoice_id = $invdata->id;
                $invdtl->user_id = Auth::user()->id;
                $invdtl->product = $product_names[$key];
                $invdtl->description = $descriptions[$key]; 
                $invdtl->quantity = $quantitys[$key]; 
                $invdtl->unit_rate = $unit_rates[$key]; 
                $invdtl->amount = $amounts[$key]; 
                $invdtl->vat = $vats[$key]; 
                $invdtl->created_by = Auth::user()->id;
                $invdtl->save();

            }else{

                $invdtl = new InvoiceDetail();
                $invdtl->invoice_id = $invdata->id;
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

        }

            

            $message ="<div class='alert alert-success' style='color:white'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Invoice Update Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);

            
        }
        


    }


}
