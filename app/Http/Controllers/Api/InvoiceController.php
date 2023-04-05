<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\NewUser;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use PDF;
use Mail;
use App\Mail\InvoiceMail;

class InvoiceController extends BaseController
{
    public function getAllInvoice()
    {
        $data = Invoice::with('invoicedetail')->where('user_id',Auth::user()->id)->where('paid',0)->orderby('id','DESC')->get();
        if($data == null){
            $data = 'Data Not Found';
        }
        $responseArray = [
            'status'=>'ok',
            'data'=>$data
        ]; 
        return response()->json($responseArray,200);
    }

    public function getPaidInvoice()
    {
        $data = Invoice::with('invoicedetail')->where('user_id',Auth::user()->id)->where('paid',1)->orderby('id','DESC')->get();
        if($data == null){
            $data = 'Data Not Found';
        }
        $responseArray = [
            'status'=>'ok',
            'data'=>$data
        ]; 
        return response()->json($responseArray,200);
    }

    public function delete($id)
    {
        $chkdata = Invoice::where('id',$id)->first();
        if ($chkdata->user_id == Auth::user()->id) {
            if ($chkdata->status == 0) {
                if(Invoice::destroy($id)){
                    $responseArray = [
                        'status'=>'Data Deleted Successfully.'
                    ]; 
                    return response()->json($responseArray,200);
                }else{
                    return response()->json(['success'=>false,'message'=>'Server Failed']);
                }
            } else {
                return response()->json(['success'=>false,'message'=>'This invoice couldn\'t delete']);
            }
            
        } else {
            return response()->json(['success'=>false,'message'=>'Authentication Error!!']);
        }
    }

    public function paidInvoice(Request $request)
    {
        $chkdata = Invoice::where('id',$request->id)->first();

        if (isset($chkdata)) {
            $data = Invoice::find($request->id);
            $data->paid = "1";
            if($data->save()){
                $responseArray = [
                    'status'=>'Invoice Paid Successfully.'
                ]; 
                return response()->json($responseArray,200);
            }else{
                return response()->json(['success'=>false,'message'=>'Server Failed']);
            }
        } else {
            return response()->json(['success'=>false,'message'=>'Invoice not found']);
        }
        
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

        $responseArray = [
            'status'=>'Email Send Successfully.'
        ]; 
        return response()->json($responseArray,200);
        
    }


    public function invoiceStore2(Request $request)
    {

        if(empty($request->new_user_id)){
            return response()->json(['success'=>false,'message'=>'Please Select An User']);
        }

        if(empty($request->acct_no)){
            return response()->json(['success'=>false,'message'=>'Please make sure bank account number']);
        }

        if(empty($request->bank)){
            return response()->json(['success'=>false,'message'=>'Please make sure bank account name']);
        }

        if(empty($request->short_code)){
            return response()->json(['success'=>false,'message'=>'Please make sure bank sort code.']);
        }

        
        // image
            $userupdate = User::find(Auth::user()->id);
            if ($request->image != 'null') {
                $request->validate([
                    'image' => 'mimes:jpeg,png,jpg,gif,svg,pdf|max:8048',
                ]);
                $rand = mt_rand(100000, 999999);
                $imageName = time(). $rand .'.'.$request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $userupdate->invoice_image = $imageName;
            }
            $userupdate->bank_acc_number = $request->acct_no;
            $userupdate->bank_acc_sort_code = $request->short_code;
            $userupdate->bank_name = $request->bank;
            $userupdate->vat_number = $request->company_vatno;
            $userupdate->save();
        // end

        $newuser = NewUser::where('id',$request->new_user_id)->first();
        $invnumber = Invoice::orderby('id','DESC')->limit(1)->first();
        if (isset($invnumber)) {
            $newinv = 1001 + $invnumber->id;
        } else {
            $newinv = 1000 + 1;
        }
        try{
        
            $invdata = new Invoice;
            $invdata->user_name = $request->new_user_id;
            if ($request->image != 'null') {
                $invdata->image = $imageName;
            } else {
                $invdata->image =  Auth::user()->invoice_image;
            }
            $invdata->user_id = Auth::user()->id;
            $invdata->email = $newuser->email;
            $invdata->new_user_id = $request->new_user_id;
            $invdata->billing_address = $request->billing_address;
            $invdata->terms = $request->terms;
            $invdata->invoice_date = $request->invoice_date;
            $invdata->due_date = $request->due_date;
            $invdata->message_on_invoice = $request->invmessg;
            $invdata->subtotal = $request->subtotal;
            $invdata->total = $request->totalamount;
            $invdata->vat = $request->totalvat;
            $invdata->discount = $request->discount;
            $invdata->invoiceid = $newinv;
            $invdata->company_name = $request->company_name;
            $invdata->company_vatno = $request->company_vatno;
            $invdata->company_email = $request->company_email;
            $invdata->company_tell_no = $request->company_tell_no;
            $invdata->acct_no = $request->acct_no;
            $invdata->bank = $request->bank;
            $invdata->short_code = $request->short_code;
            $invdata->created_by = Auth::user()->id;
            if($invdata->save()){

                $invoicedetails = json_decode($request->invoicedetails, true);    
                foreach ($invoicedetails as $item)
                {
                    $payrolldtl['invoice_id'] = $invdata->id;
                    $payrolldtl['user_id'] = Auth::user()->id;
                    $payrolldtl['name'] = $item['name'];
                    $payrolldtl['description'] = $item['description'];
                    $payrolldtl['quantity'] = $item['quantity'];
                    $payrolldtl['unit_rate'] = $item['unit_rate'];
                    $payrolldtl['amount'] = $item['amount'];
                    $payrolldtl['vat'] = $item['vat'];
                    $payrolldtl['created_by'] = Auth::user()->id;
                    InvoiceDetail::create($payrolldtl);
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
                
                $success['response'] = 'Invoice create successfully';
                $success['invoice'] = $data;
                return response()->json(['success'=>true,'response'=> $success], 200);
            }

        }catch (\Exception $e){
            return response()->json(['success'=>true,'response'=> 'Server Error!!'], 404);
        }
    }

    public function invoicePdfStore(Request $request)
    {

        if(empty($request->new_user_id)){
            return response()->json(['success'=>false,'message'=>'Please Select An User']);
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
            $data->message_on_invoice = $request->message_on_invoice;
            $data->subtotal = $request->subtotal;
            $data->total = $request->total;
            $data->vat = $request->vat;
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
                $invoicedetails = json_decode($request->invoicedetails, true);   
                
                foreach ($invoicedetails as $item)
                {
                    $invdtl = new InvoiceDetail;
                    $invdtl->invoice_id = $data->id;
                    $invdtl->user_id = Auth::user()->id;
                    $invdtl->description = $item['description'];
                    $invdtl->quantity = $item['quantity'];
                    $invdtl->unit_rate = $item['unit_rate'];
                    $invdtl->amount = $item['amount'];
                    $invdtl->vat = $item['vat'];
                    $invdtl->created_by = Auth::user()->id;
                    $invdtl->save();

                }
                //stores the pdf for invoice
                $invoice = Invoice::with('invoicedetail')->where('id',$data->id)->first();
                $success['message'] = 'Invoice create successfully';
                $success['invoice'] = $invoice;
                return response()->json(['success'=>true,'response'=> $success], 200);
                
            }

        }catch (\Exception $e){
            return response()->json(['success'=>false,'response'=> 'Server Error!!'], 404);
        }

        
    }

    public function invoicePdfDownload($id)
    {
        $data = Invoice::with('invoicedetail')->where('id',$id)->first();
        $pdf = PDF::loadView('invoices.invoice', compact('data'));
        return $pdf->download('invoice-'.$data->invoiceid.'.pdf');
        
    }

    
}
