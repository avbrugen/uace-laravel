<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Session, Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Pages;
use Storage;
use File;
use Config;
use App\Auction;
use App;
use App\News;
use Intervention\Image\ImageManagerStatic as Image;
use elFinder;
use App\Cat;
use Baum\Node;

class DashboardController extends Controller
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
    public function SiteIndex()
    {
        $page = Pages::where(['slug' => 'about'])->firstOrFail();
        //$q = 'Товарна';
        //$ss = iconv("Windows-1252", "UTF-8", $q);
        //$page = Pages::where('contant', 'LIKE', '%' . $ss .'%')->get();
        return view('welcome', ['page' => $page]);
        //return $page;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getAddPage()
    {
        return view('dashboard.pages.add');
    }

    public function getPages()
    {
        $pages = Pages::all();
        return view('dashboard.pages.all', ['pages' => $pages]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function postAddPage(Request $request)
    {
        $page = new Pages;
        $page->title = $request->title;
        $page->slug = $request->slug;
        $page->contant = $request->editor;
        if($page->save()) {
            return redirect('/dashboard/pages');
        }
    }

    public function getEditPage($id)
    {
        $page = Pages::find($id);
        return view('dashboard.pages.edit', ['page' => $page]);
    }

    public function postEditPage(Request $request, $id)
    {
        $page = Pages::find($id);
        $page->title = $request->title;
        $page->slug = $request->slug;
        $page->contant = $request->editor;
        if($page->save()){
            return redirect('/dashboard/pages');
        }
    }

    public function getNews()
    {
        $article = News::orderBy('id', 'desc')->paginate(10);
        return view('dashboard.news.all', ['articles' => $article]);
    }

    public function getAddNews()
    {
        return view('dashboard.news.add');
    }

    public function postAddNews(Request $request)
    {
        $article = new News;
        $article->title = $request->title;
        $article->slug = $request->slug;
        $article->anonce = $request->anonce;
        $article->container = $request->editor;
        $article->category = $request->category;
        $article->date_publish = Carbon::parse($request->date_publish)->format('Y-m-d H:i');

        if($request->hasFile('preview')) {
            $file = $request->file('preview');
            $filename = str_random(10);
            $extension = $file->getClientOriginalExtension();
            $surl = $this->globalSiteSettings['site_url'];
            $imgurl = $surl.'/uploads/'.$filename.'.'.$extension;
            Image::make($request->file('preview'))->fit(500, 200)->save(public_path().'/uploads/'.$filename.'.'.$extension);
            $article->preview = $imgurl;
        }

        if($article->save()){
            return redirect('/dashboard/news');
        }

    }

    public function getEditNews($id) {
        $article = News::find($id);
        return view('dashboard.news.edit', ['article' => $article]);
    }

    public function postEditNews(Request $request, $id)
    {
        $article = News::find($id);
        $article->title = $request->title;
        $article->slug = $request->slug;
        $article->anonce = $request->anonce;
        $article->container = $request->editor;
        $article->category = $request->category;
        $article->date_publish = Carbon::parse($request->date_publish)->format('Y-m-d H:i');

        if($request->has_preview == 0)
        {
            $article->preview = null;
        }

        if($request->hasFile('preview')) {
            $file = $request->file('preview');
            $filename = str_random(10);
            $extension = $file->getClientOriginalExtension();
            $surl = $this->globalSiteSettings['site_url'];
            $imgurl = $surl.'/uploads/'.$filename.'.'.$extension;
            Image::make($request->file('preview'))->fit(500, 200)->save(public_path().'/uploads/'.$filename.'.'.$extension);
            $article->preview = $imgurl;
        }


        if($article->save()){
            return redirect('/dashboard/news');
        }

    }

    public function getDeleteNews($id) {
        if(News::destroy($id)) {
            return redirect('/dashboard/news');
        } else {
            return 'error';
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function upload(Request $request)
    {
        $callback = $_GET['CKEditorFuncNum'];
        $error = '';
        $file = $request->file('upload'); //Сам файл
//создаем ему уникальное название, чтобы нечаянно не перезаписать что-то
        $filename = md5(rand(5,50));
//получаем разрешение файла
        $extension = $file->getClientOriginalExtension();
//сохраняем файл в хранилище
        Storage::disk('uploads')->put($filename.'.'.$extension, File::get($file));
//формируем ссылку для ответа
        $http_path = '/uploads/'.$filename.".".$extension;
//собственно сам ответ CKEditor-у
        echo "<script type=\"text/javascript\">window.parent.CKEDITOR.tools.callFunction(".$callback.",  \"".$http_path."\", \"".$error."\" );</script>";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function index()
    {
        $news = News::orderBy('id', 'desc')->paginate(10);
        $pages = Pages::all();
        return view('dashboard.start', ['news' => $news, 'pages' => $pages]);
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

    /**
     * Возвращает страницу зарегистрированных пользователей
     * @return Users
     */
    public function getUsers()
    {
        $users = App\User::all();
        return view('dashboard.users.index', ['users' => $users]);
    }

    /**
     * Поиск по зарегистрированным пользователям
     */
    public function searchUsers(Request $request)
    {
        $query = App\User::query();
        $what = $request->s;

        if($request->group) {
            $query = $query->where('user_group', '=', $request->group);
        }

        if($request->s) {


            $query = $query->orWhere('first_name', 'like', '%'. $what .'%')
                ->orWhere('last_name', 'like', '%'. $what .'%')
                ->orWhere('middle_name', 'like', '%'. $what .'%')
                ->orWhere('email', 'like', '%'. $what .'%')
                ->orWhere('phone', 'like', '%'. $what .'%')->orWhere('id', '=', $what);

        }

        $query = $query->get();


        return view('dashboard.users.search', ['what' => $what, 'query' => $query, 'request' => $request]);

    }

    /**
     * Поиск по записям
     */
    public function searchPost(Request $request) {
        $query = News::query();

        if($request->category) {
            $query = $query->where('category', '=', $request->category);
        }

        if($request->category == 0) {
            $query = $query->where('category', '=', 0);
        }

        if($request->s) {
            $query = $query->where('title', 'like', '%'. $request->s .'%')->orWhere('anonce', 'like', '%'. $request->s .'%')->orWhere('container', 'like', '%'. $request->s .'%');
        }

        $query = $query->orderBy('id', 'desc');

        $query = $query->paginate(10);

        return view('dashboard.news.search', ['articles' => $query, 'request' => $request]);
    }

    /**
     * Вывод страницы с аукционами
     */
    public function getAuctions()
    {
        $auctions = Auction::with('curuser')->with('bidders')->orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.auctions.all', ['auctions' => $auctions]);
    }

    /**
     * Поиск по аукционам в админ-панели
     */
    public function getSearchAuctions(Request $request)
    {

        $auctions = Auction::query();

        if($request->category)
        {
            $auctions = $auctions->where(['category' => $request->category]);
        }

        if($request->title)
        {
            $auctions = $auctions->where('id', '=', $request->title)->orWhere('title', 'like', '%'.$request->title.'%');
        }

        if($request->status != 'del') {

            if($request->status == 1) {
                $auctions = $auctions->where('in_archive', '=', 1);
            }
            else {
                $auctions = $auctions->where('status', '=', $request->status);
            }
        }

        if($request->price_from)
        {
            $auctions = $auctions->where('starting_price', '>=', $request->price_from);
        }

        if($request->price_to)
        {
            $auctions = $auctions->where('starting_price', '<=', $request->price_to);
        }

        if($request->region)
        {
            $auctions = $auctions->where('region', '=', $request->region);
        }

        if($request->city)
        {
            $auctions = $auctions->where('city', 'like', '%'.$request->city.'%');
        }

        if($request->free_sale)
        {
            $auctions = $auctions->where('free_sale', '=', 1);
        }

        if($request->sortBy == 'lowcost') {
            $auctions = $auctions->orderBy('starting_price', 'asc');
        }
        elseif($request->sortBy == 'topcost') {
            $auctions = $auctions->orderBy('starting_price', 'desc');
        }
        else {
            $auctions = $auctions->orderBy('id', 'desc');
        }

        if($request->items_per_page) {
            $auctions = $auctions->paginate($request->items_per_page);
        } else {
            $auctions = $auctions->paginate(10);
        }

        return view('dashboard.auctions.search', ['auctions' => $auctions, 'request' => $request]);

    }

    /**
     * Вывод страницы добавления аукциона
     */
    public function getAddAuction()
    {
        return view('dashboard.auctions.add');
    }

    public function getEditLot($id)
    {
        $auction = Auction::find($id);
        //$categories = App\Categories::all();
        $documents = App\Uploads::where(['auction_id' => $id, 'type' => 'doc'])->get();
        return view('dashboard.auctions.edit', ['auction' => $auction, 'documents' => $documents]);
    }

    public function postUpdateLot(Request $request, $id)
    {
        $category = Cat::find($request->lot_category); // Категория в которую добавляем лот

        // Обязательные поля для заполнения: название, категория, область,
        $rights = ['lot_title' => 'required', 'lot_category' => 'required', 'region' => 'required', 'city' => 'required'];

        // Если категория имеет подкатегории - добавляем указание подкатегории обязательным для заполнения полем
        if($category->children()->count() > 0) {
            $rights = array_add($rights, 'lot_type', 'required'); // Тип лота
        }

        // Если добавлены прикрепления - добавляем валидацию по расширению файла
        if($request->hasFile('documents')) {
            //$rights = array_add($rights, 'documents', 'mimes:jpeg,bmp,png,pdf,doc,docx');
        }

        // Если объект свободной продажи
        if($request->free_sale) {
            // Если выбрана договорная цена - поле стоимости необязательно для заполнения
            if(!$request->negotiable_price) {
                $rights = array_add($rights, 'starting_price', 'required'); // Стоимость
            }
        } else {
            $rights = array_add($rights, 'starting_price', 'required'); // Стоимость
            $rights = array_add($rights, 'guarantee_fee', 'required'); // Гарантийный взнос
            $rights = array_add($rights, 'bid_price', 'required'); // Цена шага
            $rights = array_add($rights, 'data_start', 'required'); // Дана начала аукциона
            $rights = array_add($rights, 'date_end', 'required'); // Дата завершения
        }

        // Запрашиваем список обязательных полей для текущей категории и типа лота
        $rights = $this->getRightsForCategory($request->lot_category, $request->lot_type, $rights);

        // Собственный текст для ошибок
        $messages = array(
            'lot_title.required' => 'Поле «Назва лоту» обязательно для заполнения.',
            'lot_category.required' => 'Вы не выбрали категорию лота.',
            'lot_image.required' => 'Нужно загрузить хотя бы основную фотографию лота.',
            'region.required' => 'Вы не выбрали область.',
            'city.required' => 'Поле «Місто» обязательно для заполнения.',
            'starting_price.required' => 'Поле «Стартова ціна» обязательно для заполнения.',
            'guarantee_fee.required' => 'Поле «Гарантійний внесок» обязательно для заполнения.',
            'bid_price.required' => 'Поле «Крок аукціону» обязательно для заполнения.',
            'data_start.required' => 'Поле «Дата початку аукціону» обязательно для заполнения.',
            'date_end.required' => 'Поле «Дата завершення аукціону» обязательно для заполнения.',
            'property_material.required' => 'Вы не выбрали материал здания.',
            'property_floors.required' => 'Поле «Кiлькiсть поверхiв» обязательно для заполнения.',
            'property_floor.required' => "Поле «Поверх» обов'язково для заповнення.",
            'property_areas.required' => 'Поле «Кiмнат/примiщень» обязательно для заполнения.',
            'property_totalarea.required' => 'Поле «Загальна площа» обязательно для заполнения.',
            'property_livingarea.required' => 'Поле «Житлова площа» обязательно для заполнения.',
            'auto_mark.required' => 'Вы не выбрали марку автомобиля.',
            'auto_model.required' => 'Поле «Модель» обязательно для заполнения.',
            'auto_year.required' => 'Поле «Pік випуску» обязательно для заполнения.',
            'auto_transmission.required' => 'Поле «Коробка передач» обязательно для заполнения.',
            'auto_drive.required' => 'Поле «Тип привода» обязательно для заполнения.',
            'auto_fuel.required' => 'Поле «Тип пального» обязательно для заполнения.',
            'auto_doors.required' => 'Поле «Кількість дверей» обязательно для заполнения.',
        );

        // Если добавлены прикрепления - добавляем валидацию по расширению файла
        if($request->hasFile('documents')) {
            //$rights = array_add($rights, 'documents', 'mimes:jpeg,bmp,png,pdf,doc,docx');
            $files = $request->file('documents');
            $i = 0;
            foreach($files as $file) {
                //$rights = array_add($rights, 'documents'. $i, 'max:8000');
                $messages['documents.' . $i . '.max'] = 'Розмір файлу «'. $file->getClientOriginalName() .'» перевищує достустимый (8 мб).';
                $rights['documents.' . $i] = 'max:8000';
                $i++;
            }
        }

        // Выполняем валидацию
        $validator = Validator::make($request->all(), $rights, $messages);
        // При обнаружении ошибки - возвращаем пользователя на предыдущую страницу и выводим ошибки
        if($validator->fails()) { return redirect()->back()->withInput()->withErrors($validator->errors()); }


        /*
         * Обновление информации о лоте
         */
        $create = Auction::where('id', '=', $id)->with('bidders')->first();
        $create->title = $request->lot_title;
        $create->category = $request->lot_category;
        $create->lot_type = $request->lot_type;

        $this->getAddFieldsListCategory($request->lot_category, $create, $request);

        $create->more_information = $request->more_information; // Додаткові відомості
        $create->more_about = $request->more_about; // Відомості про майно, його склад, характеристики, опис
        $create->region = $request->region; // Область
        $create->city = $request->city; // Місцезнаходження
        $create->property_type = $request->property_type; // Тип майна
        $create->currency = $request->currency; // Валюта

        if($request->lot_image)
        {
            $create->img = $request->lot_image;
            $create->img_min = $request->lot_image_min;
        }
        else {
            $create->img = "http://uace.com.ua/static/images/no-picture-max.jpg";
            $create->img_min = "http://uace.com.ua/static/images/no-picture-min.jpg";
        }

        // Если есть основная фотография
        if($request->lot_image) {
            $create->img = $request->lot_image;
            $create->img_min = $request->lot_image_min;
        }
        else { // Если нет, ставим стандартные
            $create->img = "http://uace.com.ua/static/images/no-picture-max.jpg";
            $create->img_min = "http://uace.com.ua/static/images/no-picture-min.jpg";
        }

        // Если установлен флажок на "Свободная продажа"
        if($request->free_sale) {
            $create->free_sale = 1; // Помечаем как свободно продаваемый объект
            // Если установлен флажок на "Ціна договірна"
            if($request->negotiable_price) {
                $create->negotiable_price = 1;
                $create->starting_price = null;
            } else { // В противном случае записываем введенную цену
                $create->starting_price = str_replace(" ","",$request->starting_price);
                $create->negotiable_price = null;
            }
            $create->data_start = null; // Записываем дату начала
            $create->date_end = null; // Записываем дату завершения
            $create->guarantee_fee = null; // Гарантийный взнос
            $create->bid_price = null; // Стоимость шага
        } else {
            $create->free_sale = null;
        }

        // Если добавлен предмет на аукцион
        if(!$request->free_sale) {
            $create->free_sale = null; // Помечаем, что это не свободная продажа
            $create->data_start = Carbon::parse($request->data_start)->format('Y-m-d H:i'); // Записываем дату начала
            $create->date_end = Carbon::parse($request->date_end)->format('Y-m-d H:i'); // Записываем дату завершения
            $create->guarantee_fee = str_replace(" ","",$request->guarantee_fee); // Гарантийный взнос
            $create->starting_price = str_replace(" ","",$request->starting_price); // Стартовую цену
            $create->bid_price = str_replace(" ","",$request->bid_price); // Стоимость шага
        }

        // Если установлен флажок на "Можливий торг"
        if($request->possible_bargain) {
            $create->possible_bargain = 1;
        } else {
            $create->possible_bargain = null;
        }

        // Если выбран статус Архив
        if($request->in_archive) {
            $create->in_archive = 1;
            $create->save();
        } else {
            $create->in_archive = 0;
            $create->save();
        }

        if($create->status === $request->status)
        {
            $create->status = $request->status;
            $create->save();
        }

        // Если администрация утвердила аукцион
        elseif(!$create->free_sale && $request->status == 2)
        {
            $this->sendNotificationToUser($create->user, 3, 'default', $create->id, $create->title); // Отправка оповещения владельцу
            $create->status = 2;
            $create->save();
        }

        // Если вручную начат аукцион
        elseif(!$create->free_sale && $request->status == 3)
        {
            $this->sendNotificationAllBidders($create->id, $create->title, $create->bidders); // Отправка оповещения всем допущенным участникам
            $create->status = 3;
            $create->save();
        }

        /*
         * Если публикуется свободный лот - ищем владельца и отправляем ему сообщение об изменении статуса
         */
        elseif($create->free_sale && $request->status == 3 || $create->free_sale && $request->status == 5 || $create->free_sale && $request->status == 7)
        {
            $this->sendNotificationToUser($create->user, $request->status, 'free', $create->id, $create->title);

            if($request->status == 7) {
                $create->in_archive = 1; // Помещаем аукцион в Архив
            } elseif($request->status == 3) {
                $create->in_archive = 0;
            }

            $create->status = $request->status;
            $create->save();
        }


        // Если вручную завершен аукцион
        elseif(!$create->free_sale && $request->status == 7)
        {

            $user = App\User::find($create->user); // Информация о создателе аукциона
            $win = App\Bets::where('auction_id', '=', $create->id)->orderBy('created_at', 'desc')->first(); // Определение победителя
            $create->in_archive = 1; // Помещаем аукцион в Архив
            if($win) {

                $win_user = App\User::find($win->user_id); // Информация о победителе
                $win_status = App\Bidders::where('auction_id', '=', $create->id)->where('user_id', '=', $win->user_id)->first();
                $win_status->status = 2;
                $win_status->save();
                $create->final_price = $win->bet;
                $create->status = 7; // Смена статуса на "Торги відбулися"
                $create->save();

                // Отправка письма создателю аукциона
                Mail::queue('emails.auction-end', ['first_name' => $user->first_name, 'last_name' => $user->last_name, 'middle_name' => $user->middle_name, 'auction_id' => $create->id, 'auction_cyr' => $create->currency, 'auction_title' => $create->title, 'auction_status' => 7,
                    'win_first_name' => $win_user->first_name,
                    'win_last_name' => $win_user->last_name,
                    'win_middle_name' => $win_user->middle_name,
                    'win_email' => $win_user->email,
                    'win_phone' => $win_user->phone,
                    'win_cost' => $win->bet
                ], function($message) use ($user)
                {
                    $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Аукціон завершено');
                });

                // Отправка письма победителю аукциона
                Mail::queue('emails.auction-end-winner', ['first_name' => $win_user->first_name, 'last_name' => $win_user->last_name, 'auction_id' => $create->id, 'auction_title' => $create->title, 'auction_status' => 7,
                    'win_cost' => $win->bet
                ], function($message) use ($win_user)
                {
                    $message->to($win_user->email, $win_user->first_name . ' ' . $win_user->last_name)->subject('Аукціон завершено');
                });

                // Отправка письма администратору
                $adminEmail = $this->globalSiteSettings['admin_email'];
                Mail::queue('emails.auction-end-admin', ['auction_id' => $create->id, 'auction_title' => $create->title, 'auction_status' => 7,
                    'win_first_name' => $win_user->first_name,
                    'win_last_name' => $win_user->last_name,
                    'win_middle_name' => $win_user->middle_name,
                    'win_email' => $win_user->email,
                    'win_phone' => $win_user->phone,
                    'win_cost' => $win->bet
                ], function($message) use ($adminEmail)
                {
                    $message->to($adminEmail)->subject('Аукціон завершено');
                });

            } else {

                $create->status = 8; // Смена статуса на "Торги не відбулися"
                $create->save();

                // Отправка письма создателю аукциона
                Mail::queue('emails.auction-end', ['first_name' => $user->first_name, 'last_name' => $user->last_name, 'middle_name' => $user->middle_name, 'auction_id' => $create->id, 'auction_title' => $create->title, 'auction_status' => 8,], function($message) use ($user)
                {
                    $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Аукціон завершено');
                });

                // Отправка письма администратору
                $adminEmail = $this->globalSiteSettings['admin_email'];
                Mail::queue('emails.auction-end-admin', ['auction_id' => $create->id, 'auction_title' => $create->title, 'auction_status' => 8], function($message) use ($adminEmail)
                {
                    $message->to($adminEmail)->subject('Аукціон завершено');
                });

            }
        }
        // В любом другом случае
        else {
            $create->status = $request->status;
            $create->save();
        }

        if($request->more_images)
        {
            $attaches = App\Uploads::find($request->more_images);
            foreach ($attaches as $attach) {
                $attach->auction_id = $create->id;;
                $attach->type = 'image';
                $attach->save();
            }
        }

        if($request->hasFile('documents')) {
            $files = $request->file('documents');
            foreach($files as $file)
            {
                $surl = $this->globalSiteSettings['site_url'];
                $filename = preg_replace('/.[^.]*$/', '', $file->getClientOriginalName());
                $filename = $filename . '-' . mt_rand(10,100) . '.' . $file->getClientOriginalExtension();
                $genLink = $surl.'/uploads/docs/'.$filename; // Генерируем ссылку
                $file->move(public_path() . '/uploads/docs/', $filename); // Перемещаем файл
                $upload = new App\Uploads(); // Создаем экземпляр модели
                $upload->type = 'doc'; // Задаем тип экземпляра - документ
                $upload->link = $genLink; // Записываем сгенерированную ранее ссылку
                $upload->name = preg_replace('/.[^.]*$/', '', $file->getClientOriginalName()); // Записываем имя
                $upload->auction_id = $create->id; // Записываем сгенерированную ранее ссылку
                $upload->save(); // Сохраняем
            }
        }
        
        // Сбрасываем закешированные данные виджета "Останні надходження"
        if(Cache::has('last_lots'))
        {
            Cache::forget('last_lots');
        }
        
        return redirect('/dashboard/auctions');
    }

    /**
     * Обрабатываем обязательные поля для переданной категории
     */
    public function getRightsForCategory($id, $type, $rights) {

        // Недвижимость
        if($id == 1) {
            $rights = array_add($rights, 'property_totalarea', 'required'); // Загальна площа
            $rights = array_add($rights, 'property_livingarea', 'required'); // Житлова площа
            $rights = array_add($rights, 'lot_image', 'required'); // Основное изображение
            if($type == 7 || $type == 8) { // Дома, дачі, котеджі/Земельні ділянки
                $rights = array_add($rights, 'plot_size', 'required'); // Розмір земельної ділянки
            }
        }

        // Автомобили
        if($id == 4) {
            $rights = array_add($rights, 'auto_mark', 'required'); // Марка
            $rights = array_add($rights, 'auto_model', 'required'); // Модель
            $rights = array_add($rights, 'auto_year', 'required'); // Pік випуску
            $rights = array_add($rights, 'auto_transmission', 'required'); // Коробка передач
            $rights = array_add($rights, 'auto_drive', 'required'); // Тип привода
            $rights = array_add($rights, 'auto_fuel', 'required'); // Тип пального
            $rights = array_add($rights, 'auto_doors', 'required'); // Кількість дверей
        }

        return $rights;
    }

    /*
     * Условия добавлений для каждой категории
     */
    public function getAddFieldsListCategory($id, $create, $request) {

        if($id == 1) // Недвижимость
        {
            $create->property_material = $request->property_material;
            $create->property_purpose = $request->property_purpose;
            $create->property_floors = $request->property_floors;
            $create->property_floor = $request->property_floor;
            $create->property_areas = $request->property_areas;
            $create->property_totalarea = $request->property_totalarea;
            $create->property_livingarea = $request->property_livingarea;
            $create->plot_size = $request->plot_size;
        }

        if($id == 4) // Автомобілі
        {
            $create->auto_mark = $request->auto_mark;
            $create->auto_model = $request->auto_model;
            $create->auto_year = $request->auto_year;
            $create->auto_transmission = $request->auto_transmission;
            $create->auto_drive = $request->auto_drive;
            $create->auto_fuel = $request->auto_fuel;
            $create->auto_doors = $request->auto_doors;
            $create->auto_mileage = $request->auto_mileage;
            $create->auto_potencia = $request->auto_potencia;
            $create->lot_EDRPOU = $request->lot_edrpou;
            $create->lot_DebtorName = $request->lot_debtorname;
        }

        if($id == 6) { // Виробниче обладнання
            $create->equipment_brand = $request->equipment_brand; // Виробник
            $create->equipment_model = $request->equipment_model; // Модель
            $create->equipment_year = $request->equipment_year; // Рік
            $create->equipment_power = $request->equipment_power; // Потужність
        }

        if($id == 30) // Техніка та меблі
        {
            $create->stuff_brand = $request->stuff_brand; // Виробник
            $create->stuff_model = $request->stuff_model; // Модель
            $create->stuff_year = $request->stuff_year; // Рік
            $create->stuff_diagonal = $request->stuff_diagonal; // Діагональ, дюймів
        }

        if($id == 39) // Будівельні матеріали
        {
            $create->build_materials_col = $request->build_materials_col; // Кількість тис. шт.
            $create->build_materials_weight = $request->build_materials_weight; // Маса
            $create->build_materials_volume = $request->build_materials_volume; // Об'єм
            $create->build_materials_width = $request->build_materials_width; // build_materials_width
        }

        return $create;
    }

    /**
     * Возвращает заявки лота
     */
    public function getAuctionBidders($id){
        $auction = Auction::with('bidders')->find($id);
        return view('dashboard.auctions.bidders', ['auction' => $auction]);
    }

    public function getAuctionBidderEdit($id, $bidder_id)
    {
        $bidder = App\Bidders::find($bidder_id);
        return view('dashboard.auctions.bidder-info', ['bidder' => $bidder, 'auction_id' => $id]);
    }

    public function postAuctionBidderEdit(Request $request, $id, $bidder_id)
    {
        $bidder = App\Bidders::find($bidder_id);
        $bidder->last_name = $request->last_name;
        $bidder->first_name = $request->first_name;
        $bidder->middle_name = $request->middle_name;
        $bidder->phone = $request->phone;
        if($request->dop_phone) {
            $bidder->dop_phone = $request->dop_phone;
        }

        if($request->bidder_status != $bidder->status) {
            $bidder->status = $request->bidder_status;

            $user = App\User::find($bidder->user_id);
            $auction = Auction::find($id);

            Mail::send('emails.newstatus', ['first_name' => $user->first_name, 'last_name' => $user->last_name, 'auction_title' => $auction->title, 'auction_id' => $auction->id, 'auction_start' => $auction->data_start, 'new_status' => trans('theme.bidder_status.'.$request->bidder_status)], function($message) use ($user)
            {
                $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Изменен статус Вашей заявки!');
            });
        }

        $bidder->save();



        return response()->json(['status' => 'success', 'responseText' => 'Данные успешно обновлены'], 200);

    }

    public function getDeleteLot($id)
    {
        
        // Удаляем файлы
        $deleteFiles = App\Uploads::where('auction_id', $id)->get();
        if($deleteFiles->count() > 0)
        {
            
            setlocale(LC_ALL, 'ru_RU.utf8');
            foreach($deleteFiles as $b)
            {
                
                //dd($b);
                
                //
                //$e = substr(strrchr($fname,'.'),1);
                //$n = preg_replace('/.[^.]*$/', '', $fname);

                if($b->type == 'image')
                {
                    $extension = substr(strrchr($b->name,'.'),1);
                    $cutName = preg_replace('/.[^.]*$/', '', $b->name);
                    Storage::disk('upload_images')->delete($b->name);
                    Storage::disk('upload_images')->delete($cutName.'-sm.'.$extension);
                }
                elseif($b->type == 'doc')
                {
                    $fname = pathinfo($b->link);
                    Storage::disk('upload_docs')->delete($fname['basename']);
                }
                
                $b->delete();
            }
        }
        
        // Удаляем аукцион
        $delete = Auction::find($id);
        $delete->delete();

        // Удаляем участников аукциона
        $deleteBidders = App\Bidders::where('auction_id', $id)->get();
        if($deleteBidders->count() > 0)
        {
            foreach($deleteBidders as $b)
            {
                $b->delete();
            }
        }

        // Удаляем ставки
        $deleteBets = App\Bets::where('auction_id', $id)->get();
        if($deleteBets->count() > 0)
        {
            foreach($deleteBets as $b)
            {
                $b->delete();
            }
        }

        

        // Сбрасываем закешированные данные виджета "Останні надходження"
        if(Cache::has('last_lots'))
        {
            Cache::forget('last_lots');
        }
        
        return redirect()->back();
    }

    /**
     * Выводит страницу с файловым менеджером
     */
    public function getFileManager()
    {
        return view('dashboard.file-manager');
    }

    /**
     * Выводит страницу с настройками
     */
    public function getSettings()
    {
        $settings = App\Settings::all();
        return view('dashboard.settings', ['settings' => $settings]);
    }

    /**
     * Обновляет настройки сайта
     */
    public function postSettings(Request $request)
    {
        $rules = [];

        // Правила обработки
        $allSettings = App\Settings::all();
        foreach($allSettings as $item)
        {
            if($item->rules)
            {
                $rules = array_add($rules, $item->name, $item->rules);
            }
        }

        // Валидация
        $this->validate($request, $rules);

        // Обновление данных каждого поля
        foreach($request->except('_token') as $i => $val)
        {
            App\Settings::where('name', $i)->update(['value' => $val]);
        }

        // Удаляем закешированные настройки
        if(Cache::has('settings'))
        {
            Cache::forget('settings');
        }

        // Возврашаем сообщение об успешном обновлении
        Session::flash('success', 'Данные успешно обновлены');
        return redirect()->back();
    }


    /*
     * Отправка оповещения пользователю об изменении статуса его лота
     * Получает ID пользователя, номер статуса, тип лота (свободный/обычный)
     */
    public function sendNotificationToUser($user, $status, $type, $lotID, $lotTitle)
    {
        $user = App\User::find($user); // Ищем владельца аукциона по переданному ID

        if($type == 'free') {
            $status = trans('theme.statuses_free.' . $status); // Ищем текст статуса в файлах локализации
        } elseif($type == 'default') {
            $status = trans('theme.statuses.' . $status); // Ищем текст статуса в файлах локализации
        }

        Mail::send('emails.lot-change-status',
            ['first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'lot_title' => $lotTitle,
                'lot_id' => $lotID,
                'status' => $status,
            ], function($message) use ($user) {
                $message->to($user->email)->subject('Змінився статус вашого лота!');
            });

    }

    /*
     * Отправляем каждому утвержденному участнику аукциона письмо о его начале
     * Получаем ID аукциона, заголовок, массив участников
     */
    public function sendNotificationAllBidders($auction_id, $auction_title, $auction_bidders)
    {
        $bidders = []; // Массив для ID участников

        foreach($auction_bidders as $bidder)
        {
            if($bidder->status == 1) { // Если участник допущен до участия в торгах
                array_push($bidders, $bidder->user_id); // Записываем его в массив для отправки оповещения о начале аукциона
            }
        }

        // Получаем доступ к информации о каждом участнике
        $users = App\User::find($bidders);

        foreach($users as $user) // Отправляем письмо о начале каждому участнику
        {
            Mail::queue('emails.auctionstart', [
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'auction_id' => $auction_id,
                'auction_title' => $auction_title
            ],
                function($message) use ($user)
                {
                    $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Розпочато аукціон');
                });
        }

    }

    /*
     * Возвращаем вид переименования файла для модального окна
     */
    public function getRenameFile($id)
    {
        $file = App\Uploads::find($id);
        return view('dashboard.ajax.rename-file', ['file' => $file]);
    }

    /*
     * Меняем название файла в базе данных
     */
    public function postRenameFile(Request $request, $id)
    {
        $file = App\Uploads::find($id);
        $file->name = $request->name;
        $file->save();
        return response()->json(['status' => 'success', 'responseText' => 'Файл успішно перейменований', 'newFileName' => $file->name], 200);
    }

}
