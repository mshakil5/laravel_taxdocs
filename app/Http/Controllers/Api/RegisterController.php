<?php
   
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;
use App\Models\BankAccountDetail;
use Illuminate\Support\Facades\Auth;
use Validator;
   
class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required',
            'bname' => 'required',
            'house_number' => 'required',
            'town' => 'required',
            'bank_acc_number' => 'required',
            'accountant_name' => 'required',
            'surname' => 'required',
            'bank_acc_sort_code' => 'required',
            'street_name' => 'required',
            'postcode' => 'required',
            'subscription_plan' => 'required',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);

        $bankdlt = new BankAccountDetail;
        $bankdlt->user_id = $user->id;
        $bankdlt->bank_acc_number = $request->bank_acc_number;
        $bankdlt->bank_acc_sort_code = $request->bank_acc_sort_code;
        $bankdlt->status = "1";
        $bankdlt->save();
   
        $success = [];
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;
        $success['message'] =  'User register successfully.';
        return response()->json($success,200);
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $chksts = User::where('email', $request->email)->first();
        if ($chksts) {
            if ($chksts->status == 1) {
                if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
                    $user = Auth::user(); 
                    $success['token'] =  $user->createToken('MyApp')->accessToken; 
                    $success['name'] =  $user->name;
                    $success['message'] =  'User login successfully.';
                    return response()->json($success,200);
                } 
                else{ 
                    return $this->sendError('Wrong Password!!.', ['error'=>'Wrong Password!!']);
                }
            }else{
                return $this->sendError('Your Account is deactive..', ['error'=>'Your Account is deactive.']);
            }
        }else {
            return $this->sendError('Credential Error. You are not authenticate user..', ['error'=>'Credential Error. You are not authenticate user.']);
        }

    }

    
}