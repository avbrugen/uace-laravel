<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Cache;

class PasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');

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

        view()->share('globalSiteSettings', $this->globalSiteSettings);
    }

    protected $redirectTo = '/auctions';
}
