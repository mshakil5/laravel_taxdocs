<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\NewUser;
use App\Models\BankAccountDetail;
Use Image;
use Illuminate\support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{

    
    public function getCustomerByAgent($id)
    {
        if (Auth::user()->is_type == 1) {
            $user = User::where('id','=', $id)->first();
            $accounts = User::where('firm_id','=', $id)->get();
        } else {
            $user = User::where('id','=', Auth::user()->id)->first();
            $accounts = User::where('firm_id','=', Auth::user()->id)->get();
        }
        return view('agent.customer',compact('accounts','user'));
    }

    public function getCustomerDetails($id)
    {
        $id = decrypt($id);
        $data = User::where('id','=', $id)->first();
        return view('admin.register.userdtl',compact('data'));
    }

    public function getNotAssignCustomer()
    {
        if (Auth::user()->is_type == 1) {
            $accounts = User::where('is_type','=', '0')->where('agent_assign','0')->orderby('id','DESC')->get();
        }
        return view('admin.register.newuser',compact('accounts'));
    }

    public function profile()
    {
        $data= Auth::user();
        return view('user.profile', compact('data'));
    }

    public function userImageUpload(Request $request)
    {
        
        $user = User::find(Auth::user()->id);

        if ($request->image != 'null') {
            $request->validate([
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:8048',
            ]);
            $rand = mt_rand(100000, 999999);
            $imageName = time(). $rand .'.'.$request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $user->photo= $imageName;
        }


        if ($user->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>User Image Upload Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function userProfileUpdate(Request $request)
    {

        if(empty($request->email)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Email \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $chkemail = User::where('email',$request->email)->where('id','!=', Auth::user()->id)->first();
        if($chkemail){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>This email already added.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $userdata = User::find(Auth::user()->id);
        $userdata->name = $request->name;
        $userdata->surname = $request->surname;
        $userdata->email = $request->email;
        $userdata->phone = $request->phone;
        $userdata->bname = $request->bname;
        $userdata->baddress = $request->baddress;
        $userdata->house_number = $request->house_number;
        $userdata->street_name = $request->street_name;
        $userdata->town = $request->town;
        $userdata->postcode = $request->postcode;
        $userdata->contact_person = $request->contact_person;
        $userdata->bweb = $request->bweb;
        $userdata->reg_number = $request->reg_number;
        $userdata->note = $request->note;
        $userdata->bank_acc_sort_code = $request->bank_acc_sort_code;
        $userdata->bank_acc_number = $request->bank_acc_number;
        $userdata->bank_name = $request->bank_name;
        $userdata->updated_by = Auth::user()->id;
        if ($userdata->save()) {
            if (isset($request->bank_name)) {
                $bankaccount = BankAccountDetail::where('user_id',Auth::user()->id)->orderby('id','ASC')->first()->id;
                $bankupdate = BankAccountDetail::find($bankaccount);
                $bankupdate->bank_name = $request->bank_name;
                $bankupdate->save();
            }
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>User Details Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{

            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }

    }

    public function changeUserPassword(Request $request)
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


    public function bankaccountstore(Request $request)
    {
        $bankdlt = new BankAccountDetail;
        $bankdlt->user_id = Auth::user()->id;
        $bankdlt->bank_name = $request->bank_name;
        $bankdlt->bank_acc_number = $request->bank_acc_number;
        $bankdlt->bank_acc_sort_code = $request->bank_acc_sort_code;
        if ($bankdlt->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function activeAccount(Request $request)
    {
        BankAccountDetail::where('user_id', '=', Auth::user()->id)->update(['status' => '0']);

        $user = BankAccountDetail::find($request->id);
        $user->status = $request->status;
        $user->save();

        if($request->status==1){
            $user = BankAccountDetail::find($request->id);
            $user->status = $request->status;
            $user->save();

            $userupdate = User::find(Auth::user()->id);
            $userupdate->bank_name = $user->bank_name;
            $userupdate->bank_acc_number = $user->bank_acc_number;
            $userupdate->bank_acc_sort_code = $user->bank_acc_sort_code;
            $userupdate->updated_by = Auth::user()->id;
            $userupdate->save();
            
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Active Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            $user = BankAccountDetail::find($request->id);
            $user->status = $request->status;
            $user->save();
            $message ="<div class='alert alert-danger'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Inactive Successfully.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
        }

    }

    public function accountDelete($id)
    {

        if(BankAccountDetail::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Listing Deleted']);
        }
        else{
            return response()->json(['success'=>false,'message'=>'Update Failed']);
        }
    }

    public function getNewUser()
    {
        $data = NewUser::where('user_id', '=', Auth::user()->id)->get();
        return view('user.alluser', compact('data'));
    }

    

    public function newUserStore(Request $request)
    {
        $data = new NewUser;
        $data->user_id = Auth::user()->id;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->address = $request->address;
        $data->post_code = $request->post_code;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message,'data'=>$data]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }
    public function newUserUpdate(Request $request)
    {
        $data =  NewUser::find($request->uid);
        $data->user_id = Auth::user()->id;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->address = $request->address;
        $data->post_code = $request->post_code;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message,'data'=>$data]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function getUserDetails(Request $request)
    {
        $userDtl = NewUser::where('id', '=', $request->uid)->first();
        if(empty($userDtl)){
            return response()->json(['status'=> 303,'message'=>"No data found"]);
        }else{
            return response()->json(['status'=> 300,'username'=>$userDtl->name,'useremail'=>$userDtl->email,'user_id'=>$userDtl->id,'address'=>$userDtl->address]);
        }
    }

    public function newUserDelete($id)
    {

        if(NewUser::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Listing Deleted']);
        }
        else{
            return response()->json(['success'=>false,'message'=>'Update Failed']);
        }
    }
}
