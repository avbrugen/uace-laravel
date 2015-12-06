<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;


class FormsController extends Controller
{
    public function __construct()
    {

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

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function question(Request $request)
    {
        $v = Validator::make($request->all(), [
            'person' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'question' => 'required',
        ]);

        if ($v->fails())
        {
            return redirect()->back()->withInput()->withErrors($v->errors());
        } else {

            $adminEmail = $this->globalSiteSettings['admin_email'];
            Mail::queue('emails.new-question', ['person' => $request->person, 'email' => $request->email, 'phone' => $request->phone, 'question' => $request->question], function($message) use ($adminEmail)
            {
                $message->to($adminEmail)->subject('Нове запитання');
            });

        }

        Session::flash('sended', 'Питання успішно відправлено. Ви отримаєте відповідь найближчим часом.');
        Session::flash('gAnalyticsReachGoal', 'ASK_QUESTION');
        Session::flash('YaMetrikaReachGoal', 'ASK_QUESTION');
        return redirect()->back();
    }

    /**
     * Отправляет данные пользователя продавцу и показывает его контакты
     * @param Request $request
     */
    public function getSeller(Request $request)
    {
        // Указываем поля для валидации
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        // Если запрос не прошел валидацию - возвращаем пользователя на предыдушую страницу и передаем ошибки
        if($validator->fails())
        {
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $seller = User::find($request->user); // Ищем владельца по ID
        Session::flash('seller', $seller); // Записываем данные владельца во временную переменную

        Mail::send('emails.get-seller', array('request' => $request), function($message) use ($seller)
        {
            $message->to($seller->email)->subject("Зв'язок з продавцем");
        });

        Session::flash('gAnalyticsReachGoal', 'GET_SELLER_INFO'); 
        Session::flash('YaMetrikaReachGoal', 'GET_SELLER_INFO'); // Отправка данных о достижении цели в Яндекс Метрику
        return redirect()->back(); // Возвращаем пользователя на страницу с которой была отправлена форма
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
