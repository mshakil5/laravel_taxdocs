<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
Use Image;
use Illuminate\support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Admin\Validator;

class AdminController extends Controller
{
    public function profile()
    {
        $profile_data= Auth::user();
        return view('admin.profile')->with('profile_data', $profile_data);
    }

    public function adminProfileUpdate(Request $request)
    {

        $chkemail = User::where('email',$request->email)->where('id','!=', Auth::user()->id)->first();
        if($chkemail){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This email already added.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        $userdata= Auth::user();
        $userdata->name= $request->name;
        $userdata->email= $request->email;
        $userdata->phone= $request->phone;
        $userdata->city= $request->city;
        $userdata->country= $request->country;
        $userdata->about= $request->about;
        $userdata->address= $request->address;

        if ($userdata->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Profile Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }

    }

    public function changeAdminPassword(Request $request)
        {

            if(empty($request->opassword)){
                $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Old Password\" field..!</b></div>";
                return response()->json(['status'=> 303,'message'=>$message]);
                exit();
            }

            if(empty($request->password)){
                $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"New Password\" field..!</b></div>";
                return response()->json(['status'=> 303,'message'=>$message]);
                exit();
            }

            if(empty($request->password === $request->confirmpassword)){
                $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>New password doesn't match.</b></div>";
                return response()->json(['status'=> 303,'message'=>$message]);
                exit();
            }

        $hashedPassword = Auth::user()->password;

       if (\Hash::check($request->opassword , $hashedPassword )) {

         if (!\Hash::check($request->password , $hashedPassword)) {
                $where = [
                    'id'=>auth()->user()->id
                ];
                $passwordchange = User::where($where)->get()->first();
                $passwordchange->password =Hash::make($request->password);

                if ($passwordchange->save()) {
                    $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Password Change Successfully.</b></div>";
                    return response()->json(['status'=> 300,'message'=>$message]);
                }else{
                    return response()->json(['status'=> 303,'message'=>'Server Error!!']);
                }

        }else{
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>New password can not be the old password.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
                }

           }else{
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Old password doesn't match.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
             }

        }



        public function adminImageUpload(Request $request, $id)
        {
            $where = [
                'id'=>auth()->user()->id
            ];
            $user = User::where($where)->get()->first();

           

            if ($request->image != 'null') {
                $originalImage= $request->file('image');
                $thumbnailImage = Image::make($originalImage);
                $thumbnailPath = public_path().'/images/thumbnail/';
                $originalPath = public_path().'/images/';
                $time = time();
                $thumbnailImage->save($originalPath.$time.$originalImage->getClientOriginalName());
                $thumbnailImage->resize(150,150);
                $thumbnailImage->save($thumbnailPath.$time.$originalImage->getClientOriginalName());
                $user->photo= $time.$originalImage->getClientOriginalName();
            }


            if ($user->save()) {
                $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>User Image Upload Successfully.</b></div>";
                return response()->json(['status'=> 300,'message'=>$message]);
            }
            else{
                return response()->json(['status'=> 303,'message'=>'Server Error!!']);
            }
        }

    public function adminindex()
    {
        $accounts = User::where('is_type','=', '1')->get();

        return view('admin.register.index')->with('accounts',$accounts);
    }

    public function adminstore(Request $request)
    {

        
        if(empty($request->name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Username \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->email)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Email \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        // if(empty($request->phone)){
        //     $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Phone \" field..!</b></div>";
        //     return response()->json(['status'=> 303,'message'=>$message]);
        //     exit();
        // }
        if(empty($request->password)){            
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Password\" field..!</b></div>"; 
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->password === $request->cpassword)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Password doesn't match.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $chkemail = User::where('email',$request->email)->first();
        if($chkemail){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This email already added.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        try{
            $account = new User();
            $account->name = $request->name;
            $account->email = $request->email;
            $account->is_type = "1";
            $account->phone = $request->phone;
            $account->password = Hash::make($request->input('password'));
            $account->save();
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Admin Account Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);

        }catch (\Exception $e){
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function adminedit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = User::where($where)->get()->first();
        return response()->json($info);
    }

    public function adminupdate(Request $request, $id)
    {

        
        if(empty($request->name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Username \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->email)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Email \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        // if(empty($request->phone)){
        //     $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Phone \" field..!</b></div>";
        //     return response()->json(['status'=> 303,'message'=>$message]);
        //     exit();
        // }
        
        if(isset($request->password) && ($request->password != $request->cpassword)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Password doesn't match.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        $chkemail = User::where('email',$request->email)->where('id','!=', $request->registerid)->first();
        if($chkemail){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This email already added.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $where = [
            'id'=>$request->registerid
        ];
        
        //$userData = User::find($id);
        $userData = User::where($where)->get()->first();

        if(isset($request->password)){
        $userData->name = request('name');
        $userData->email = request('email');
        $userData->is_type =   "1";
        $userData->password = Hash::make($request->input('password'));

        }else{

        $userData->name = request('name');
        $userData->email = request('email');
        $userData->is_type =   "1";
        
        }

        if ($userData->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Admin Account Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        } 
    }

    public function admindestroy($id)
    {

        if(User::destroy($id)){
            return response()->json(['success'=>true,'message'=>'User has been deleted successfully']);
        }else{
            return response()->json(['success'=>false,'message'=>'Delete Failed']);
        }
    }


    public function agentindex()
    {
        $roles = Role::all();
        $accounts = User::where('is_type','=', '2')->get();

        return view('admin.register.agent')->with('accounts',$accounts)->with('roles',$roles);
    }

    public function agentstore(Request $request)
    {

        
        if(empty($request->name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Username \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->email)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Email \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->password)){            
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Password\" field..!</b></div>"; 
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->password === $request->cpassword)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Password doesn't match.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $chkemail = User::where('email',$request->email)->first();
        if($chkemail){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This email already added.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        try{
            $account = new User();
            $account->name = $request->name;
            $account->email = $request->email;
            $account->is_type = "2";
            $account->phone = $request->phone;

            $account->street_name = $request->street_name;
            $account->contact_person = $request->contact_person;
            $account->postcode = $request->postcode;
            $account->town = $request->town;
            $account->house_number = $request->house_number;

            $account->password = Hash::make($request->input('password'));
            $account->created_by = Auth::user()->id;
            $account->save();

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Accountant Firm Created Successfully.</b></div>";

            return response()->json(['status'=> 300,'message'=>$message]);
        }catch (\Exception $e){
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);

        }
    }

    public function agentedit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = User::where($where)->get()->first();
        return response()->json($info);
    }

    public function agentupdate(Request $request, $id)
    {

        
        if(empty($request->name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Username \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->email)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Email \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        
        if(isset($request->password) && ($request->password != $request->cpassword)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Password doesn't match.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $chkemail = User::where('email',$request->email)->where('id','!=', $request->uid)->first();
        if($chkemail){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This email already added.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        $where = [
            'id'=>$request->uid
        ];
        
        $userData = User::find($request->uid);
        $userData->name = $request->name;
        $userData->email = $request->email;
        $userData->is_type =  "2";
        $userData->phone = $request->phone;
        $userData->street_name = $request->street_name;
        $userData->contact_person = $request->contact_person;
        $userData->postcode = $request->postcode;
        $userData->town = $request->town;
        $userData->house_number = $request->house_number;
        if($request->password != null && ($request->password == $request->cpassword)){
            $userData->password = Hash::make($request->password);
        }
        if ($userData->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        } 
    }

    public function agentdestroy($id)
    {

        if(User::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Agent has been deleted successfully']);
        }else{
            return response()->json(['success'=>false,'message'=>'Delete Failed']);
        }
    }

    public function activeuser(Request $request)
    {
        $user = User::find($request->id);
        $user->status = $request->status;
        $user->save();

        if($request->status==1){
            $user = User::find($request->id);
            $user->status = $request->status;
            $user->save();
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Active Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            $user = User::find($request->id);
            $user->status = $request->status;
            $user->save();
            $message ="<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Inactive Successfully.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
        }

    }


    public function userindex()
    {
        $roles = Role::all();
        if (Auth::user()->is_type == 1) {
            $accounts = User::where('is_type','=', '0')->whereNotNull('firm_id')->get();
        } else {
            $accounts = User::where('is_type','=', '0')->where('agent_assign','1')->where('firm_id', Auth::user()->id)->get();
        }
        

        return view('admin.register.user')->with('accounts',$accounts)->with('roles',$roles);
    }

    public function userstore(Request $request)
    {

        
        if(empty($request->name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Username \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->email)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Email \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        
        if(empty($request->password)){            
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Password\" field..!</b></div>"; 
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->password === $request->cpassword)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Password doesn't match.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $chkemail = User::where('email',$request->email)->first();
        if($chkemail){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This email already added.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        try{
            $account = new User();
            $account->name = $request->name;
            $account->email = $request->email;
            $account->is_type = "0";
            $account->phone = $request->phone;
            $account->firm_id = $request->firm_id;
            $account->bname = $request->bname;
            $account->baddress = $request->baddress;
            $account->contact_person = $request->contact_person;
            $account->blandnumber = $request->blandnumber;
            $account->password = Hash::make($request->input('password'));

            $account->save();

            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>User Account Created Successfully.</b></div>";

            return response()->json(['status'=> 300,'message'=>$message]);
        }catch (\Exception $e){
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);

        }
    }

    public function useredit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = User::where($where)->get()->first();
        return response()->json($info);
    }

    public function userupdate(Request $request, $id)
    {

        
        if(empty($request->name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Username \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->email)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Email \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        // if(empty($request->phone)){
        //     $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Phone \" field..!</b></div>";
        //     return response()->json(['status'=> 303,'message'=>$message]);
        //     exit();
        // }
        
        if(isset($request->password) && ($request->password != $request->cpassword)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Password doesn't match.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $chkemail = User::where('email',$request->email)->where('id','!=', $request->registerid)->first();
        if($chkemail){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This email already added.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $where = [
            'id'=>$request->registerid
        ];
        
        //$userData = User::find($id);
        $userData = User::where($where)->get()->first();
        $userData->name = request('name');
        $userData->surname = request('surname');
        $userData->email = request('email');
        $userData->phone = request('phone');
        if(isset($request->password)){
            $userData->password = Hash::make($request->input('password'));
        }
        $userData->bname = request('bname');
        $userData->firm_id = request('firm_id');
        $userData->house_number = request('house_number');
        $userData->street_name = request('street_name');
        $userData->baddress = request('baddress');
        $userData->town = request('town');
        $userData->postcode = request('postcode');
        $userData->bank_acc_number = request('bank_acc_number');
        $userData->bank_acc_sort_code = request('bank_acc_sort_code');
        $userData->subscription_plan = request('subscription_plan');
        $userData->contact_person = request('contact_person');
        $userData->blandnumber = request('blandnumber');
        $userData->updated_by = Auth::user()->id;
        if (isset($request->assign)) {
            $userData->agent_assign = 1;
        }
        if ($userData->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>User Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        } 
    }

    public function userdestroy($id)
    {

        if(User::destroy($id)){
            return response()->json(['success'=>true,'message'=>'User has been deleted successfully']);
        }else{
            return response()->json(['success'=>false,'message'=>'Delete Failed']);
        }
    }





}
