<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use App\Models\NewUser;
use App\Models\BankAccountDetail;
Use Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends BaseController
{
    public function profileInfo(Request $request){
        $data =   User::find(Auth::id());
        if($data ==null){
            $data = 'Data Not Found';
        }
        $responseArray = [
            'status'=>'ok',
            'data'=>$data
        ]; 
        return response()->json($responseArray,200);
    }

    public function profileUpdate(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.Auth::user()->id,
            'phone' => 'required',
            'bname' => 'required|unique:users,bname,'.Auth::user()->id,
            'house_number' => 'required',
            'town' => 'required',
            'surname' => 'required',
            'street_name' => 'required',
            'postcode' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }


        $emailchk = User::where('email','=', $request->email)->where('id','!=', Auth::id())->first();
        $bnamechk = User::where('bname','=', $request->bname)->where('id','!=', Auth::id())->first();
        if (empty($emailchk) && empty($bnamechk)) {
            $user = User::find(Auth::id());
            $user->name = $request->name;
            $user->surname = $request->surname;
            $user->email = $request->email;
            $user->phone = $request->phone;
            if (isset($request->accountant_name)) {
                $user->accountant_name = $request->accountant_name;
            }
            $user->bname = $request->bname;
            $user->bweb = $request->bweb;
            $user->house_number = $request->house_number;
            $user->street_name = $request->street_name;
            $user->postcode = $request->postcode;
            $user->town = $request->town;
            $user->reg_number = $request->reg_number;
            $user->bank_name = $request->bank_name;
            $user->updated_by = Auth::user()->id;
            $user->save();
            if (!empty($user))
            {
                if (isset($request->bank_name)) {
                    $bankaccount = BankAccountDetail::where('user_id',Auth::user()->id)->orderby('id','ASC')->first()->id;
                    $bankupdate = BankAccountDetail::find($bankaccount);
                    $bankupdate->bank_name = $request->bank_name;
                    $bankupdate->save();
                }
                return response()->json(['success'=>true,'response'=> $user], 200);
            }
            else{
                return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
            }
        } else {
            return response()->json(['success'=>false,'response'=> 'This email already have an account. Please try to another one. Thank You.'], 404);
        }
    }

    public function passwordUpdate(Request $request) {

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->old_password, $hashedPassword)) {
            if (!Hash::check($request->password, $hashedPassword)) {
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                $responseArray = [
                    'status'=>'Password updated successfully',
                    'data'=>$user
                ]; 
                return response()->json($responseArray,200);
            }else{
                return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
            }

        }else{
            return response()->json(['success'=>false,'response'=> 'Old password doesn\'t match..!!'], 404);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function bankAccountDetails(Request $request){
        $data =   BankAccountDetail::where('user_id', Auth::user()->id)->get();
        if($data ==null){
            $data = 'Data Not Found';
        }
        $responseArray = [
            'status'=>'ok',
            'data'=>$data
        ]; 
        return response()->json($responseArray,200);
    }

    public function bankAccountStore(Request $request){
        $bankdlt = new BankAccountDetail;
        $bankdlt->user_id = Auth::user()->id;
        $bankdlt->bank_name = $request->bank_name;
        $bankdlt->bank_acc_number = $request->bank_acc_number;
        $bankdlt->bank_acc_sort_code = $request->bank_acc_sort_code;
        $bankdlt->status = "0";
        $bankdlt->save();
        $responseArray = [
            'status'=>'Account Create Successfully.',
            'data'=>$bankdlt
        ]; 
        return response()->json($responseArray,200);
    }

    public function deleteBankAccount($id){


        $chkaccount = BankAccountDetail::where('id', $id)->first();
        if ($chkaccount->status == 1) {
            return response()->json(['success'=>false,'message'=>'Active account can\'t delete!!']);
        }

        if(BankAccountDetail::destroy($id)){
            $responseArray = [
                'status'=>'Data Deleted Successfully.'
            ]; 
            return response()->json($responseArray,200);
        }else{
            return response()->json(['success'=>false,'message'=>'Server Failed']);
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
            $user->updated_by = Auth::user()->id;
            $user->save();
            
            $userupdate = User::find(Auth::user()->id);
            $userupdate->bank_name = $user->bank_name;
            $userupdate->bank_acc_number = $user->bank_acc_number;
            $userupdate->bank_acc_sort_code = $user->bank_acc_sort_code;
            $userupdate->updated_by = Auth::user()->id;
            $userupdate->save();

            $responseArray = [
                'status'=>'Active Successfully.'
            ]; 
            return response()->json($responseArray,200);

        }else{

            $user = BankAccountDetail::find($request->id);
            $user->status = $request->status;
            $user->updated_by = Auth::user()->id;
            $user->save();

            $responseArray = [
                'status'=>'Inactive Successfully.'
            ]; 
            return response()->json($responseArray,200);

        }

    }
    
    public function profileImageUpdate(Request $request){

        $validator = Validator::make($request->all(), [
            'photo' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }


            $user = User::find(Auth::id());
            if ($request->photo != 'null') {
                $originalImage = $request->file('photo');
                $thumbnailImage = Image::make($originalImage);
                $thumbnailPath = public_path().'/images/thumbnail/';
                $originalPath = public_path().'/images/';
                $time = time();
                $thumbnailImage->save($originalPath.$time.$originalImage->getClientOriginalName());
                $thumbnailImage->resize(500,500);
                $thumbnailImage->save($thumbnailPath.$time.$originalImage->getClientOriginalName());
                $user->photo = $time.$originalImage->getClientOriginalName();
            }
            $user->updated_by = Auth::user()->id;
            
            if ($user->save())
            {
                $responseArray = [
                    'status'=>'Profile Image Updated Successfully.',
                    'data'=>$user
                ];
                return response()->json(['success'=>true,'response'=> $responseArray], 200);
            }
            else{
                return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
            }
        
    }

    public function getNewUser()
    {
        $data = NewUser::where('user_id', '=', Auth::user()->id)->get();
        
        if($data ==null){
            $data = 'Data Not Found';
        }
        $responseArray = [
            'status'=>'ok',
            'data'=>$data
        ]; 
        return response()->json($responseArray,200);
    }

    public function newUserStore(Request $request)
    {
        $data = new NewUser;
        $data->user_id = Auth::user()->id;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->address = $request->address;
        $data->post_code = $request->post_code;
        $data->created_by = Auth::user()->id;
        if ($data->save())
            {
                $responseArray = [
                    'status'=>'User Create Successfully.',
                    'data'=>$data
                ];
                return response()->json(['success'=>true,'response'=> $responseArray], 200);
            }
            else{
                return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
            }
    }

    public function newUserUpdate(Request $request)
    {
        $data = NewUser::find($request->id);
        $data->user_id = Auth::user()->id;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->address = $request->address;
        $data->post_code = $request->post_code;
        $data->updated_by = Auth::user()->id;
        if ($data->save())
            {
                $responseArray = [
                    'status'=>'User Create Successfully.',
                    'data'=>$data
                ];
                return response()->json(['success'=>true,'response'=> $responseArray], 200);
            }
            else{
                return response()->json(['success'=>false,'response'=> 'Something went wrong!'], 404);
            }
    }

    public function newUserDelete($id)
    {
        if(NewUser::destroy($id)){
            $responseArray = [
                'status'=>'Data Deleted Successfully.'
            ]; 
            return response()->json($responseArray,200);
        }else{
            return response()->json(['success'=>false,'message'=>'Server Failed']);
        }
    }

    // account deactive
    public function deactiveAccount(Request $request)
    {
        
        $data = User::find(Auth::user()->id);
        $data->status = "0";
        if($data->save()){
            $responseArray = [
                'status'=>'Account Deactive Successfully.'
            ]; 
            return response()->json($responseArray,200);
        }else{
            return response()->json(['success'=>false,'message'=>'Server Failed']);
        }
        
        
    }
}
