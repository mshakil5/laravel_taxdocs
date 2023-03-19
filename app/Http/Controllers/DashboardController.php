<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function closeNewUserNotificationbyAdmin(Request $request)
    {

        $data = User::find($request->userid);
        $data->admin_notify = 1;
        if($data->save()){
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Notification Delete Successfully.</b></div>";

        return response()->json(['status'=> 300,'message'=>$message]);
        }
        return response()->json(['status'=> 300,'message'=>'Server Error!!']);

    }

    public function closeNewNotificationbyAgent(Request $request)
    {

        $data = User::find($request->userid);
        $data->agent_notify = 1;
        if($data->save()){
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Notification Delete Successfully.</b></div>";

        return response()->json(['status'=> 300,'message'=>$message]);
        }
        return response()->json(['status'=> 300,'message'=>'Server Error!!']);

    }

    public function closeNewImageNotificationbyAdmin(Request $request)
    {

        $data = Photo::find($request->imgid);
        $data->admin_notification = 1;
        if($data->save()){
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Notification Delete Successfully.</b></div>";

        return response()->json(['status'=> 300,'message'=>$message]);
        }
        return response()->json(['status'=> 300,'message'=>'Server Error!!']);

    }
    public function closeNewImageNotificationbyAgent(Request $request)
    {

        $data = Photo::find($request->imgid);
        $data->accfirm_notification = 1;
        if($data->save()){
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Notification Delete Successfully.</b></div>";

        return response()->json(['status'=> 300,'message'=>$message]);
        }
        return response()->json(['status'=> 300,'message'=>'Server Error!!']);

    }
}
