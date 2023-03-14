<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
Use Image;
use App\Models\HowWeWork;

class WorkController extends Controller
{
    public function index()
    {
        $data = HowWeWork::orderby('id','DESC')->get();
        return view('admin.work.index',compact('data'));
    }
    
    public function store(Request $request)
    {
        $data = new HowWeWork();
        $data->title = $request->title;
        $data->description = $request->description;

        // intervention
        if ($request->image != 'null') {
            $request->validate([
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:8048',
            ]);
            $rand = mt_rand(100000, 999999);
            $imageName = time(). $rand .'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data->image= $imageName;
        }
        // end

        $data->status = "0";
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
        $info = HowWeWork::where($where)->get()->first();
        return response()->json($info);
    }

    public function update(Request $request, $id)
    {
        $data = HowWeWork::find($id);

        if($request->image != 'null'){

            $request->validate([
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:8048',
            ]);
            $rand = mt_rand(100000, 999999);
            $imageName = time(). $rand .'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data->image= $imageName;
        }
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

    public function delete($id)
    {
        if(HowWeWork::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Listing Deleted']);
        }
        else{
            return response()->json(['success'=>false,'message'=>'Update Failed']);
        }
    }
}
