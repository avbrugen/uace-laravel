<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);

        $this->globalSiteSettings = Cache::remember('settings', 3600, function()
        {
            $array = array();
            $settings = App\Settings::all();
            foreach($settings as $setting)
            {
                $array = array_add($array, $setting->name, $setting->value);
            }
            return $array;
        });

    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = array(
            'legal_entity.required' => trans('theme.reg.required'),
            'legal_entity.min' => trans('theme.reg.min', ['col' => 5]),
            'EDRPOUcode.unique' => trans('theme.reg.EDRPOU_unique'),
            'EDRPOUcode.required' => trans('theme.reg.required'),
            'EDRPOUcode.min' => trans('theme.reg.min', ['col' => 5]),
            'LastName.required' => trans('theme.reg.required'),
            'FirstName.required' => trans('theme.reg.required'),
            'MiddleName.required' => trans('theme.reg.required'),
            'email.required' => trans('theme.reg.required'),
            'email.unique' => trans('theme.reg.email_unique'),
            'phone.required' => trans('theme.reg.required'),
            'password.required' => trans('theme.reg.required'),
            'password.confirmed' => trans('theme.reg.ps_confirmed'),
            'rules_agree.required' => 'Необхідно погодитися з правилами',
        );

        if($data['personGroup'] == 2) {
            $val = Validator::make($data, [
                //'name' => 'required|max:255',
                'legal_entity' => 'min:5|required',
                'EDRPOUcode' => 'min:5|required|unique:users',
                'LastName' => 'required',
                'FirstName' => 'required',
                'MiddleName' => 'required',
                'phone' => 'required',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:6',
                'rules_agree' => 'required',

            ], $messages);
        } else {
            $val = Validator::make($data, [
                //'name' => 'required|max:255',
                'LastName' => 'required',
                'FirstName' => 'required',
                'MiddleName' => 'required',
                'phone' => 'required',
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|confirmed|min:6',
                'rules_agree' => 'required',

            ], $messages);
        }

        Session::put('personGroup', $data['personGroup']);

        return $val;

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {


        //При регистрации физического лица
        if($data['personGroup'] == 1) {
            $user = new User();
            //$user->name = '';
            $user->last_name = $data['LastName']; //Прізвище
            $user->first_name = $data['FirstName']; //ім'я
            $user->middle_name = $data['MiddleName']; //по-батькові
            $user->email = $data['email']; //E-mail
            $user->phone = $data['phone']; //номер телефону
            $user->password = bcrypt($data['password']); //пароль
            $user->user_group = 1;
            $user->save();
        }

        //При регистрации юридического лица
        if($data['personGroup'] == 2) {
            $user = new User();
            //$user->name = '';
            $user->legal_entity = $data['legal_entity']; //Найменування юридичної особи
            $user->EDRPOUcode = $data['EDRPOUcode']; //Код ЄДРПОУ
            $user->last_name = $data['LastName']; //Прізвище представника
            $user->first_name = $data['FirstName']; //ім'я представника
            $user->middle_name = $data['MiddleName']; //по-батькові представника
            $user->email = $data['email']; //E-mail
            $user->phone = $data['phone']; //номер телефону
            $user->password = bcrypt($data['password']); //пароль
            $user->user_group = 2;
            $user->save();
        }

        // Отправка письма об успешной регистрации
        Mail::send('emails.register', array('first_name' => $data['FirstName'], 'last_name' => $data['LastName'], 'email' => $data['email'], 'pass' => $data['password']), function($message) use ($data) {
            $message->from('alex@avbrugen.com', 'UACE');
            $message->to($data['email'])->subject('Успешная регистрация');
        });
        
        Session::flash('gAnalyticsReachGoal', 'NEW_USER');
        Session::flash('YaMetrikaReachGoal', 'NEW_USER');
        return $user;


       // return User::create([
        //    'name' => $data['name'],
       //     'email' => $data['email'],
       //     'password' => bcrypt($data['password']),
//
       // ]);
    }

    protected $redirectTo = '/auctions';
    protected $redirectAfterLogout = '/auctions';

}
