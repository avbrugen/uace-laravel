<?php

namespace App\Http\Controllers;

use App\Auction;
use App\Bidders;
use App\Bets;
use App\Settings;
use App\Uploads;
use App\User;
use Session;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class BiddersController extends Controller
{
    public function __construct()
    {

        $this->globalSiteSettings = Cache::remember('settings', 3600, function()
        {
            $array = array();
            $settings = Settings::all();
            foreach($settings as $setting)
            {
                $array = array_add($array, $setting->name, $setting->value);
            }
            return $array;
        });

        view()->share('globalSiteSettings', $this->globalSiteSettings);
    }

    public function doit(Request $request) {
        $files = $request->file('documents');
        foreach($files as $file)
        {
            $surl = $this->globalSiteSettings['site_url']; // Домен сайта из конфигов
            $filename = str_random(10).'.'.$file->getClientOriginalExtension();
            $genLink = $surl.'/uploads/docs/'.$filename;
            $file->move(public_path() . '/uploads/docs/', $filename);
            $upload = new Uploads();
            $upload->type = 'doc';
            $upload->link = $genLink;
            $upload->save();
        }

            return $files;
    }


    /**
     * Возвращает страницу добавления участника
     * @param AuctionID
     * @return View
     */
    public function getAddBidder($id)
    {
        $User = [];
        $User['first_name'] = '';
        $User['last_name'] = '';
        $User['middle_name'] = '';
        $User['phone'] = '';
        $User['email'] = '';

        if(Auth::check())
        {
            $CurrentUser = Auth::user();
            $User['first_name'] = $CurrentUser->first_name;
            $User['last_name'] = $CurrentUser->last_name;
            $User['middle_name'] = $CurrentUser->middle_name;
            $User['phone'] = $CurrentUser->phone;
            $User['email'] = $CurrentUser->email;
        }

        return view('auction.lots.add-bidder', ['User' => $User, 'auction_id' => $id]);
    }

    /**
     * Производит добавление участника
     */
    public function postAddBidder(Request $request, $id)
    {
        $messages = array(
            'required' => trans('theme.reg.required'),
            'mimes' => trans('theme.reg.mimes'),
            'rules_agree.required' => 'Необхідно погодитися з правилами',
        );

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'middle_name' => 'required',
            'phone' => 'required',
            'bank_name' => 'required',
            'account_number' => 'required',
            'bank_code' => 'required',
            'passport_series' => 'required',
            'passport_number' => 'required',
            'passport_issue' => 'required',
            'passport_issued' => 'required',
            'adress_postcode' => 'required',
            'adress_region' => 'required',
            'adress_city' => 'required',
            'adress_full' => 'required',
            'rules_agree' => 'required',
            'file1' => 'required|mimes:jpeg,bmp,png,pdf,doc,docx',
            'file2' => 'required|mimes:jpeg,bmp,png,pdf,doc,docx',
            'file3' => 'mimes:jpeg,bmp,png,pdf,doc,docx',
            'file4' => 'required|mimes:jpeg,bmp,png,pdf,doc,docx',
       ];

        if($request->payment_type == 2)
        {
            $rules = array_add($rules, 'payment_card', 'required');
            $rules = array_add($rules, 'payment_code', 'required');
        }

        if(!Auth::check()) {
            $rules = array_add($rules, 'email', 'required');
        }

        // Если у пользователя нет отказа от ИНН
        if(!$request->has('inn_waiver'))
        {
            $rules = array_add($rules, 'passport_inn', 'required');
        }

        // Валидатор
        $this->validate($request, $rules, $messages);

        $request->flash();

        $add = new Bidders();
        $add->auction_id = $id;

        // Если пользователь авторизован
        if(Auth::check())
        {
            $add->user_id = Auth::user()->id;
        }
        else {
            $createUser = new User();
            $createUser->first_name = $request->first_name;
            $createUser->last_name = $request->last_name;
            $createUser->middle_name = $request->middle_name;
            $createUser->email = $request->email;
            $createUser->phone = $request->phone;

            $genPass = str_random(8); // Случаные 8 символов в качестве пароля
            $createUser->password = bcrypt($genPass);
            $createUser->user_group = 1; // По-умолчанию регистрируется как физическое лицо
            $createUser->save();
            $add->user_id = $createUser->id;

            $sendTo = $request->email;

            // Отправка письма об успешной регистрации
            Mail::send('emails.register', array('first_name' => $request->first_name, 'last_name' => $request->last_name, 'email' => $request->email, 'pass' => $genPass), function($message) use ($sendTo) {
                $message->to($sendTo)->subject('Успешная регистрация');
            });
        }

        // Информация о лице
        $add->first_name = $request->first_name;
        $add->last_name = $request->last_name;
        $add->middle_name = $request->middle_name;
        $add->phone = $request->phone;
        $add->dop_phone = $request->dop_phone;

        // Банковские реквизиты
        $add->payment_type = $request->payment_type;
        $add->bank_name = $request->bank_name;

        // Дополнительные поля при оплате картой
        if($request->payment_type == 2)
        {
            $add->payment_card = $request->payment_card;
            $add->payment_code = $request->payment_code;
        }

        $add->account_number = $request->account_number;
        $add->bank_code = $request->bank_code;

        // Паспортные данные
        $add->passport_series = $request->passport_series;
        $add->passport_number = $request->passport_number;
        $add->passport_issue = $request->passport_issue;
        $add->passport_issued = $request->passport_issued;

        // Если у пользователя нет отказа от ИНН
        if(!$request->has('inn_waiver'))
        {
            $add->passport_inn = $request->passport_inn;
        }

        // Адрес
        $add->adress_postcode = $request->adress_postcode;
        $add->adress_region = $request->adress_region;
        $add->adress_city = $request->adress_city;
        $add->adress_full = $request->adress_full;
        $add->status = 0;

        $surl = $this->globalSiteSettings['site_url']; // Домен сайта из конфигов

        // Файл 1
        if($request->hasFile('file1')) {
            $file1 = $request->file('file1');
            $filename = str_random(10).'.'.$file1->getClientOriginalExtension();
            $imgurl = $surl.'/userfiles/'.$filename;
            $file1->move(public_path() . '/userfiles/', $filename);
            $add->file1 = $imgurl;
        }

        // Файл 2
        if($request->hasFile('file2')) {
            $file2 = $request->file('file2');
            $filename = str_random(10).'.'.$file2->getClientOriginalExtension();
            $imgurl = $surl.'/userfiles/'.$filename;
            $file2->move(public_path() . '/userfiles/', $filename);
            $add->file2 = $imgurl;
        }

        // Файл 3
        if($request->hasFile('file3')) {
            $file3 = $request->file('file3');
            $filename = str_random(10).'.'.$file3->getClientOriginalExtension();
            $imgurl = $surl.'/userfiles/'.$filename;
            $file3->move(public_path() . '/userfiles/', $filename);
            $add->file3 = $imgurl;
        }

        // Файл 4
        if($request->hasFile('file4')) {
            $file4 = $request->file('file4');
            $filename = str_random(10).'.'.$file4->getClientOriginalExtension();
            $imgurl = $surl.'/userfiles/'.$filename;
            $file4->move(public_path() . '/userfiles/', $filename);
            $add->file4 = $imgurl;
        }

        $add->save();

        $auction = Auction::find($id);
        $adminEmail = $this->globalSiteSettings['admin_email'];

        Mail::send('emails.admin-new-bidder', ['lot_title' => $auction->title, 'lot_id' => $auction->id], function($message) use ($adminEmail)
        {
            $message->to($adminEmail)->subject('Новий учасник');
        });

        if(!Auth::check()) {
            Auth::loginUsingId($createUser->id);
        }
        
        Session::flash('gAnalyticsReachGoal', 'NEW_BIDDER');
        Session::flash('YaMetrikaReachGoal', 'NEW_BIDDER'); // Отправка данных о достижении цели в Яндекс Метрику
        return redirect('/auctions')->with('success_bidders_add', 'Ваша заявка успішно додано. Після перевірки даних адміністрацією, вона буде допущена до системи.');

    }

    /**
     * Возвращает ценовые предложения (AJAX)
     */
    public function ajaxGetBets(Request $request, $id) {
        $response = Bets::where('auction_id', '=', $id)->orderBy('created_at', 'desc')->get();
        return view('auction.lots.inc.auction-bidders-ajax', ['bets' => $response, 'currency' => $request->currency]);
    }

}
