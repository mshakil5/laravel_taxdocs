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

        $request->validate([
            'image' => 'required|mimes:pdf,jpg,jpeg,png,JPEG|max:10048',
        ]);
        if($request->hasFile('image')) {
            $data = new Photo();
            $data->user_id = Auth::user()->id;
            $data->date = $request->date;
            $data->title = $request->title;
            $data->caption = $request->caption;
            // intervention
            if ($request->image != 'null') {
                $request->validate([
                    'image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:8048',
                ]);
                $rand = mt_rand(100000, 999999);
                $imageName = time(). $rand .'.'.$request->image->extension();
                $request->image->move(public_path('images'), $imageName);
                $data->image= $imageName;
                $data->link = "/images/".$imageName;
            }
            // end
            $data->status = "0";
            $data->created_by = Auth::user()->id;
            if ($data->save()) {
                return response()->json(['success' => true, 'response' => $data], 200);
            } else {
                return response()->json(['success' => false, 'response' => 'Server Error!!'], 404);
            }
        } else {
            return response()->json(['success' => false, 'response' => 'Invalid file format!!'], 422);
        }


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
