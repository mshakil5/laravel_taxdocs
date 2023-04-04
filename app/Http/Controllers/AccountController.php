<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Account;
use App\Models\Invoice;
use App\Models\User;
use App\Http\Controllers\Controller;
Use Image;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AccountController extends Controller
{
    public function store(Request $request)
    {
        if(empty($request->date)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Date \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->amount)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->category)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Category \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if ($request->image == 'null') {
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Image \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        $data = new Account();
        $data->user_id = $request->uid;
        $data->photo_id = $request->dataid;
        $data->date = $request->date;
        $data->particular = $request->particular;
        $data->category = $request->category;
        $data->amount = $request->amount;
        $data->vat = $request->vat;
        $data->expense = $request->expense;
        $data->income = $request->income;
        $data->others = $request->others;
        $data->net = $request->net;
        $data->status = "0";
        $data->created_by = Auth::user()->id;
        if ($data->save()) {

            $imgupdate = Photo::find($request->dataid);
            $imgupdate->status = "1";
            $imgupdate->save();
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        } else {
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function edit($id)
    {
        $info = Account::where('id',$id)->first();
        // dd($data);
        return response()->json($info);
    }

    public function update(Request $request)
    {

        if(empty($request->date)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Date \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->amount)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        

        if(empty($request->category)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Category \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }



        $data = Account::find($request->dataid);
        $data->user_id = $request->uid;
        $data->date = $request->date;
        $data->particular = $request->particular;
        $data->category = $request->category;
        $data->amount = $request->amount;
        $data->vat = $request->vat;
        $data->expense = $request->expense;
        $data->income = $request->income;
        $data->others = $request->others;
        $data->net = $request->net;
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        } else {
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }


    public function newTranStore(Request $request)
    {
        if(empty($request->date)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Date \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        //image upload start
        if ($request->hasfile('media')) {
            // $media= [];
            foreach ($request->file('media') as $image) {
                $rand = mt_rand(100000, 999999);
                $name = time(). $rand .'.'.$image->getClientOriginalExtension();
                $image->move(public_path() . '/images/', $name);
                $data = new Photo();
                $data->user_id = $request->newuid;
                $data->firm_id = $request->firm_id;
                $data->date = $request->date;
                $data->image = $name;
                $data->link = "/images/".$name;
                $data->status = "0";
                $data->created_by = Auth::user()->id;
                $data->save();
            }
        }
        $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
        return response()->json(['status'=> 300,'message'=>$message]);
    }

    public function delete($id)
    {
        // $acc = Account::where('photo_id',$id)->first()->id;
        // Account::destroy($acc);
        if(Photo::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Data deleted successfully']);
        }else{
            return response()->json(['success'=>false,'message'=>'Delete Failed']);
        }
    }

    public function invoiceAccountStore(Request $request)
    {

        if(empty($request->date)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Date \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->category)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Category \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->amount)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        $data = new Account();
        $data->user_id = $request->uid;
        $data->invoice_id = $request->dataid;
        $data->date = $request->date;
        $data->particular = $request->particular;
        $data->category = $request->category;
        $data->amount = $request->amount;
        $data->vat = $request->vat;
        $data->expense = $request->expense;
        $data->income = $request->income;
        $data->others = $request->others;
        $data->net = $request->net;
        $data->status = "0";
        $data->created_by = Auth::user()->id;
        if ($data->save()) {

            $imgupdate = Invoice::find($request->dataid);
            $imgupdate->status = "1";
            $imgupdate->save();
            $uid = encrypt($data->user_id);
            return Redirect::route('admin.paidinvoice', $uid)->with('message', 'Data saved correctly!!!');
        } else {
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function invoiceAccountStore2(Request $request)
    {
        if(empty($request->date)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Date \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->amount)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

    


        $data = new Account();
        $data->user_id = $request->uid;
        $data->invoice_id = $request->dataid;
        $data->date = $request->date;
        $data->particular = $request->particular;
        $data->category = $request->category;
        $data->amount = $request->amount;
        $data->vat = $request->vat;
        $data->expense = $request->expense;
        $data->income = $request->income;
        $data->others = $request->others;
        $data->net = $request->net;
        $data->status = "0";
        $data->created_by = Auth::user()->id;
        if ($data->save()) {

            $imgupdate = Invoice::find($request->dataid);
            $imgupdate->status = "1";
            $imgupdate->save();
            $uid = encrypt($data->user_id);
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message,'user_id'=>$uid]);
        } else {
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function invoiceAccountAdd($id)
    {
        $data = Invoice::with('invoicedetail')->where('id',decrypt($id))->first();
        return view('admin.invoice.addaccount', compact('data'));
    }

    public function invoiceAccountEdit($id)
    {
        $account = Account::where('invoice_id',decrypt($id))->first();
        $data = Invoice::with('invoicedetail')->where('id',decrypt($id))->first();
        return view('admin.invoice.edit', compact('data','account'));
    }

    public function invoiceAccountUpdate(Request $request)
    {

        if(empty($request->date)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Date \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->amount)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $data = Account::find($request->dataid);
        $data->date = $request->date;
        $data->particular = $request->particular;
        $data->category = $request->category;
        $data->amount = $request->amount;
        $data->vat = $request->vat;
        $data->net = $request->net;
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        } else {
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }



}
