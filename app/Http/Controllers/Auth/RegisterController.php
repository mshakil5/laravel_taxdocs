<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\BankAccountDetail;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'phone' => ['required', 'string', 'max:255'],
            'bname' => ['required', 'string', 'max:255'],
            'house_number' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'],
            'bname' => $data['bname'],
            'house_number' => $data['house_number'],
            'town' => $data['town'],
            'bank_acc_number' => $data['bank_account_number'],
            'surname' => $data['surname'],
            'accountant_name' => $data['accountant_name'],
            'street_name' => $data['street'],
            'postcode' => $data['postcode'],
            'subscription_plan' => $data['sub_plan'],
            'bank_acc_sort_code' => $data['bank_account_code'],
        ]);

        $bankdlt = new BankAccountDetail;
        $bankdlt->user_id = $user->id;
        $bankdlt->bank_acc_number = $data['bank_account_number'];
        $bankdlt->bank_acc_sort_code = $data['bank_account_code'];
        $bankdlt->status = "1";
        $bankdlt->save();
        return $user;
    }
}
