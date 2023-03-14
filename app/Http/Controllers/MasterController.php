<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
Use Image;
use App\Models\Master;

class MasterController extends Controller
{
    public function index()
    {
        $data = Master::orderby('id','DESC')->get();
        return view('admin.master.index',compact('data'));
    }
    
    public function store(Request $request)
    {
        $data = new Master();
        $data->title = $request->title;
        $data->description = $request->description;
        $data->status = "1";
        $data->created_by = Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        } else {
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function edit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = Master::where($where)->get()->first();
        return response()->json($info);
    }

    public function update(Request $request, $id)
    {
        $data = Master::find($id);
        $data->title = $request->title;
        $data->description = $request->description;
        $data->status = "0";
        $data->updated_by = Auth::user()->id;

        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    // public function delete($id)
    // {
    //     if(Master::destroy($id)){
    //         return response()->json(['success'=>true,'message'=>'Listing Deleted']);
    //     }
    //     else{
    //         return response()->json(['success'=>false,'message'=>'Update Failed']);
    //     }
    // }
}
