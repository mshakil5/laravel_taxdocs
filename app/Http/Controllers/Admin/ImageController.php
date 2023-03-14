<?php

namespace App\Http\Controllers\Admin;

use App\Models\Photo;
use App\Http\Controllers\Controller;
Use Image;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;

class ImageController extends Controller
{
    public function index()
    {
        $data = Photo::orderby('id','DESC')->get();
        return view('admin.photo.index',compact('data'));
    }
    
    public function store(Request $request)
    {
        $data = new Photo();
        $data->title = $request->title;

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
        $info = Photo::where($where)->get()->first();
        return response()->json($info);
    }

    public function update(Request $request, $id)
    {
        $data = Photo::find($id);

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
            $data->status = "0";

        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function delete($id)
    {
        if(Photo::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Listing Deleted']);
        }
        else{
            return response()->json(['success'=>false,'message'=>'Update Failed']);
        }
    }

    public function showImage($id)
    {
        $id = decrypt($id);
        $data = Photo::with('account')->where('user_id',$id)->orderby('id','DESC')->get();

        return view('admin.photo.userimg',compact('data','id'));
    }

    public function getUserImage()
    {
        $data = Photo::with('account')->where('user_id',Auth::user()->id)->orderby('id','DESC')->get();
        return view('user.userimg',compact('data'));
    }

    public function userImageStore(Request $request)
    {
        $data = new Photo();
        $data->user_id = Auth::user()->id;
        $data->date = $request->date;

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
}
