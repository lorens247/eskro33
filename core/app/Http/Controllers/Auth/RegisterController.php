<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Escrow;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\UserLogin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('regStatus')->except('registrationNotAllowed');
        $this->activeTemplate = activeTemplate();
    }

    public function showRegistrationForm()
    {
        $pageTitle = "Sign Up";
        $info = json_decode(json_encode(getIpInfo()), true);
        $mobile_code = @implode(',', $info['code']);
        $countries = getCountryList();
        return view($this->activeTemplate . 'user.auth.register', compact('pageTitle','mobile_code','countries'));
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $general = GeneralSetting::first();
        $password_validation = Password::min(6);
        if ($general->secure_password) {
            $password_validation = $password_validation->mixedCase()->numbers()->symbols()->uncompromised();
        }
        $agree = 'nullable';
        if ($general->agree) {
            $agree = 'required';
        }
        $countryData = getCountryList();
        $countryArray = (array)$countryData;
        $countries = implode(',', array_keys($countryArray));
        $validationRules =  [
            'lastname'  => 'sometimes|required',
            'email'     => 'required|string|email|unique:users',
            'mobile'    => 'required|unique:users',
            'password'  => ['required','confirmed',$password_validation],
            'username'  => 'required|alpha_num|unique:users|min:6',
            'country'   => 'required|in:'.$countries,
            'agree'     => $agree
        ];
        $validate = Validator::make($data, $validationRules);

        return $validate;
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        $request->session()->regenerateToken();

        if(!verifyCaptcha()){
            $notify[] = ['error','Invalid captcha provided'];
            return back()->withNotify($notify);
        }


        $exist = User::where('mobile',$request->mobile_code.$request->mobile)->first();
        if ($exist) {
            $notify[] = ['error', 'This mobile number already exists'];
            return back()->withNotify($notify)->withInput();
        }

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $general = GeneralSetting::first();


        $referBy = session()->get('reference');
        if ($referBy) {
            $referUser = User::where('username', $referBy)->first();
        } else {
            $referUser = null;
        }

        $countryData = getCountryList();

        $countryCode = @$data['country'];
        $country = @$countryData->$countryCode->country;
        $dialCode = @$countryData->$countryCode->dial_code;


        //User Create
        $user = new User();
        $user->firstname = isset($data['firstname']) ? $data['firstname'] : null;
        $user->lastname = isset($data['lastname']) ? $data['lastname'] : null;
        $user->email = strtolower(trim($data['email']));
        $user->password = Hash::make($data['password']);
        $user->username = trim($data['username']);
        $user->ref_by = $referUser ? $referUser->id : 0;
        $user->country_code = $countryCode;
        $user->mobile = $dialCode.$data['mobile'];
        $user->address = [
            'address' => '',
            'state' => '',
            'zip' => '',
            'country' => $country,
            'city' => ''
        ];
        $user->status = 1;
        $user->ev = $general->ev ? 0 : 1;
        $user->sv = $general->sv ? 0 : 1;
        $user->ts = 0;
        $user->tv = 1;
        $user->save();


        $adminNotification = new AdminNotification();
        $adminNotification->user_id = $user->id;
        $adminNotification->title = 'New member registered';
        $adminNotification->click_url = urlPath('admin.users.detail',$user->id);
        $adminNotification->save();


        //Login Log Create
        $ip = getRealIP();
        $exist = UserLogin::where('user_ip',$ip)->first();
        $userLogin = new UserLogin();

        //Check exist or not
        if ($exist) {
            $userLogin->longitude =  $exist->longitude;
            $userLogin->latitude =  $exist->latitude;
            $userLogin->city =  $exist->city;
            $userLogin->country_code = $exist->country_code;
            $userLogin->country =  $exist->country;
        }else{
            $info = json_decode(json_encode(getIpInfo()), true);
            $userLogin->longitude =  @implode(',',$info['long']);
            $userLogin->latitude =  @implode(',',$info['lat']);
            $userLogin->city =  @implode(',',$info['city']);
            $userLogin->country_code = @implode(',',$info['code']);
            $userLogin->country =  @implode(',', $info['country']);
        }

        $userAgent = osBrowser();
        $userLogin->user_id = $user->id;
        $userLogin->user_ip =  $ip;

        $userLogin->browser = @$userAgent['browser'];
        $userLogin->os = @$userAgent['os_platform'];
        $userLogin->save();

        $escrows = Escrow::where('invitation_mail',$user->email)->get();
        foreach($escrows as $escrow){
            $conversation = $escrow->conversation;
            if ($escrow->seller_id == 0) {
                $escrow->seller_id = $user->id;
                $conversation->seller_id = $user->id;
            }else{
                $escrow->buyer_id = $user->id;
                $conversation->buyer_id = $user->id;
            }
            $escrow->invitation_mail = null;
            $escrow->save();
            $conversation->save();
        }

        return $user;
    }

    public function checkUser(Request $request){
        $validator = Validator::make($request->all(),[
            'value' => 'required',
            'column' => 'required|in:email,mobile,username'
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=> 'error']);
        }

        $user = User::where($request->column, $request->value)->first();
        if($user){
            return response()->json(['status'=> 'exists', 'message' => "This $request->column is already exist"]);
        }
        return response()->json(['status'=> 'ok']);
    }

    public function registered()
    {
        return redirect()->route('user.home');
    }

}
