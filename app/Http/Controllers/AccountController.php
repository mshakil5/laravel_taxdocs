<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Account;
use App\Http\Controllers\Controller;
Use Image;
use Illuminate\support\Facades\Auth;

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

        if ($request->image == 'null') {
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Image \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        // if(empty($request->expense) && empty($request->income)){
        //     $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Income or Expense \" field..!</b></div>";
        //     return response()->json(['status'=> 303,'message'=>$message]);
        //     exit();
        // }


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

        // if(empty($request->expense) && empty($request->income)){
        //     $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Income or Expense \" field..!</b></div>";
        //     return response()->json(['status'=> 303,'message'=>$message]);
        //     exit();
        // }


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

        if(empty($request->amount)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Amount \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if ($request->image == 'null') {
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Image \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        // if(empty($request->expense) && empty($request->income)){
        //     $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Income or Expense \" field..!</b></div>";
        //     return response()->json(['status'=> 303,'message'=>$message]);
        //     exit();
        // }


        $data = new Photo();
        $data->user_id = $request->uid;
        // intervention
        if ($request->image != 'null') {
            $originalImage = $request->file('image');
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = public_path().'/images/thumbnail/';
            $originalPath = public_path().'/images/';
            $time = time();
            $thumbnailImage->save($originalPath.$time.$originalImage->getClientOriginalName());
            $thumbnailImage->resize(150,150);
            $thumbnailImage->save($thumbnailPath.$time.$originalImage->getClientOriginalName());
            $data->image = $time.$originalImage->getClientOriginalName();
            $data->link = "/images/thumbnail/".$time.$originalImage->getClientOriginalName();
        }
        // end
        $data->status = "1";
        $data->created_by = Auth::user()->id;
        if ($data->save()) {

            $account = new Account();
            $account->user_id = $request->uid;
            $account->photo_id = $data->id;
            $account->date = $request->date;
            $account->particular = $request->particular;
            $account->category = $request->category;
            $account->amount = $request->amount;
            $account->vat = $request->vat;
            $account->net = $request->net;
            $account->status = "0";
            $account->created_by = Auth::user()->id;
            $account->save();

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        } else {
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function delete($id)
    {
        $acc = Account::where('photo_id',$id)->first()->id;
        Account::destroy($acc);
        if(Photo::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Data deleted successfully']);
        }else{
            return response()->json(['success'=>false,'message'=>'Delete Failed']);
        }
    }


}
