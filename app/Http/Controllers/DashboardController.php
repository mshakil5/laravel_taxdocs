<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function closeNewUserNotif(Request $request)
    {

        $data = User::find($request->userid);
        $data->admin_notify = 1;
        if($data->save()){
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Notification Delete Successfully.</b></div>";

        return response()->json(['status'=> 300,'message'=>$message]);
        }
        return response()->json(['status'=> 300,'message'=>'Server Error!!']);

    }

    public function closeNewNotification(Request $request)
    {

        $data = User::find($request->userid);
        $data->agent_notify = 1;
        if($data->save()){
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Notification Delete Successfully.</b></div>";

        return response()->json(['status'=> 300,'message'=>$message]);
        }
        return response()->json(['status'=> 300,'message'=>'Server Error!!']);

    }
}
