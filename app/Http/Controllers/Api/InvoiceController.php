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
                    if ($item['vat'] != "") {
                        $invdtl->vat = $item['vat'];
                    }
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

    public function invoiceEdit($id)
    {
        $data = Invoice::with('invoicedetail')->where('id',$id)->first();
        if($data == null){
            $data = 'Data Not Found';
        }
        $responseArray = [
            'status'=>'ok',
            'data'=>$data
        ]; 
        return response()->json($responseArray,200);
    }

    public function invoiceUpdate(Request $request)
    {

        if(empty($request->new_user_id)){
            $success['message'] = 'Please select an user!!';
            return response()->json(['success'=>false,'response'=> $success], 203);
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
        $invdata->message_on_invoice = $request->message_on_invoice;
        $invdata->subtotal = $request->subtotal;
        $invdata->total = $request->total;
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
            $invoicedetails = json_decode($request->invoicedetails, true);   
                foreach ($invoicedetails as $key => $item)
                {
                    if(isset($item['invdtlid'])){
                        $invdtl = InvoiceDetail::findOrFail($item['invdtlid']);
                        $invdtl->invoice_id = $invdata->id;
                        $invdtl->user_id = Auth::user()->id;
                        $invdtl->description = $item['description'];
                        $invdtl->quantity = $item['quantity'];
                        $invdtl->unit_rate = $item['unit_rate'];
                        $invdtl->amount = $item['amount'];
                        if ($item['vat'] != "") {
                            $invdtl->vat = $item['vat'];
                        }
                        $invdtl->updated_by = Auth::user()->id;
                        $invdtl->save();
                    } else {
                        $invdtl = new InvoiceDetail;
                        $invdtl->invoice_id = $invdata->id;
                        $invdtl->user_id = Auth::user()->id;
                        $invdtl->description = $item['description'];
                        $invdtl->quantity = $item['quantity'];
                        $invdtl->unit_rate = $item['unit_rate'];
                        $invdtl->amount = $item['amount'];
                        if ($item['vat'] != "") {
                            $invdtl->vat = $item['vat'];
                        }
                        $invdtl->created_by = Auth::user()->id;
                        $invdtl->save();
                    }
                }
            $invoice = Invoice::with('invoicedetail')->where('id',$invdata->id)->first();
            $success['message'] = 'Invoice Updated successfully';
            $success['invoice'] = $invoice;
            return response()->json(['success'=>true,'response'=> $success], 200);
        }
        
    }

    public function invoicePdfDownload($id)
    {
        $data = Invoice::with('invoicedetail')->where('id',$id)->first();
        $pdf = PDF::loadView('invoices.invoice', compact('data'));
        return $pdf->download('invoice-'.$data->invoiceid.'.pdf');
        
    }

    
}
