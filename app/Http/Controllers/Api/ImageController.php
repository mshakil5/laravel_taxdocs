<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Photo;
Use Image;
use Illuminate\support\Facades\Auth;

class ImageController extends Controller
{
    public function index()
    {
        $data = Photo::select('id','user_id','date','title','image','link','caption','status')->where('user_id', Auth::user()->id)->orderby('id','DESC')->get();
        $datacount = Photo::where('user_id', Auth::user()->id)->count();
        if ($datacount > 0)
        {
            return response()->json(['success'=>true,'response'=> $data], 200);
        }
        else{
            return response()->json(['success'=>false,'response'=> 'No Image Found. Please upload an image!'], 404);
        }
    }

    public function store(Request $request)
    {
        if(!$request->hasFile('image')) {
            return response()->json(['success' => false, 'response' => 'File not found!!'], 404);
        }

        if ($request->hasfile('image')) {
            foreach ($request->file('image') as $image) {
                $rand = mt_rand(100000, 999999);
                $name = time(). $rand .'.'.$image->getClientOriginalExtension();
                //move image to postimages folder
                $image->move(public_path() . '/images/', $name);
                //insert into picture table
                $data = new Photo();
                $data->user_id = Auth::user()->id;
                $data->firm_id = Auth::user()->firm_id;
                $data->date = $request->date;
                $data->image = $name;
                $data->link = "/images/".$name;
                $data->status = "0";
                $data->created_by = Auth::user()->id;
                $data->save();
            }
        }

        $responseArray = [
            'status'=>'Document upload successfully!!'
        ]; 
        return response()->json($responseArray,200);


    }

    public function delete($id){


        $chkaccount = Photo::where('id', $id)->first();
        if ($chkaccount->status == 1) {
            return response()->json(['success'=>false,'message'=>'This Image can\'t delete!!']);
        }

        if(Photo::destroy($id)){
            $responseArray = [
                'status'=>'Data Deleted Successfully.'
            ]; 
            return response()->json($responseArray,200);
        }else{
            return response()->json(['success'=>false,'message'=>'Server Failed']);
        }
        
    }
}
