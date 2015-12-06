<?php

namespace App\Http\Controllers;

use App\Auction;
use App\Bets;
use App\Bidders;
use App\Cat;
use App\Categories;
use App\Settings;
use App\Uploads;
use App\User;
use App\News;
use App\Pages;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Intervention\Image\ImageManagerStatic as Image;
use Baum\Node;

class AuctionsController extends Controller
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

    /**
     * Главная страница
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $auctions = Auction::query();
        $status = 2;
        $curcat = '';
        $price_from = '';
        $lot_number = '';
        $q = '';
        $price_to = '';
        $auctions = $auctions->where('status', '=', $status);

        if($request->sortBy == 'lowcost') {
            $auctions = $auctions->orderBy('starting_price', 'asc');
        }
        elseif($request->sortBy == 'topcost') {
            $auctions = $auctions->orderBy('starting_price', 'desc');
        }
        elseif($request->sortBy == 'new') {
            $auctions = $auctions->orderBy('created_at', 'desc');
        }
        else {
            $request->sortBy = 'new';
            $auctions = $auctions->orderBy('created_at', 'desc'); 
        }

        if($request->items_per_page) {
            $auctions = $auctions->paginate($request->items_per_page);
        } else {
            $auctions = $auctions->paginate(10);
        }

        if(!$request)
        {
            $request = null;
        }

        $cats = Cache::remember('cats', 10, function()
        {
            return Cat::roots()->get();
        });
        return view('auction.index', ['categories' => $cats, 'currentCategory' => null, 'request' => $request, 'auctions' => $auctions, 'status_id' => $status, 'curcat' => $curcat, 'price_from' => $price_from, 'lot_number' => $lot_number, 'search_text' => $q, 'price_to' => $price_to]);
    }

    /**
     * Выводит идущие на данный момент торги
     */

    public function now(Request $request)
    {
        
        $cats = Cache::remember('cats', 10, function()
        {
            return Cat::roots()->get();
        });
        $auctions = Auction::query();
        $auctions = $auctions->where('status', '=', 3);

        if($request->sortBy == 'lowcost') {
            $auctions = $auctions->orderBy('starting_price', 'asc');
        }
        elseif($request->sortBy == 'topcost') {
            $auctions = $auctions->orderBy('starting_price', 'desc');
        }
        elseif($request->sortBy == 'new') {
            $auctions = $auctions->orderBy('created_at', 'desc');
        }
        else {
            $request->sortBy = 'new';
            $auctions = $auctions->orderBy('created_at', 'desc'); 
        }

        if($request->items_per_page) {
            $auctions = $auctions->paginate($request->items_per_page);
        } else {
            $auctions = $auctions->paginate(10);
        }

        $status = 3;
        return view('auction.index', ['categories' => $cats, 'auctions' => $auctions, 'status_id' => $status, 'currentCategory' => null, 'request' => $request]);
    }


    /**
     * Выводит лоты помещенные в архив
     */
    public function archive(Request $request)
    {
        $cats = Cache::remember('cats', 10, function()
        {
            return Cat::roots()->get();
        });
        
        $auctions = Auction::query();
        $auctions = $auctions->where('status', '>', 0);
        $auctions = $auctions->where('in_archive', '=', 1);

        if($request->sortBy == 'lowcost') {
            $auctions = $auctions->orderBy('starting_price', 'asc');
        }
        elseif($request->sortBy == 'topcost') {
            $auctions = $auctions->orderBy('starting_price', 'desc');
        }
        elseif($request->sortBy == 'new') {
            $auctions = $auctions->orderBy('created_at', 'desc');
        }
        else {
            $request->sortBy = 'new';
            $auctions = $auctions->orderBy('created_at', 'desc'); 
        }

        if($request->items_per_page) {
            $auctions = $auctions->paginate($request->items_per_page);
        } else {
            $auctions = $auctions->paginate(10);
        }
        
        $status = 1;
        return view('auction.index', ['categories' => $cats, 'auctions' => $auctions, 'status_id' => $status, 'currentCategory' => null, 'request' => $request]);
    }

    /**
     * Обрабатываем входные данные при добавлении лота
     */

    public function postAddLot(Request $request)
    {
        // Собственный текст для ошибок
        $messages = array(
            'lot_title.required' => "Поле «Назва лота» обов'язково для заповнення.",
            'lot_category.required' => "Ви не вибрали категорію лота.",
            'lot_image.required' => "Потрібно завантажити хоча б основну фотографію лота.",
            'region.required' => "Ви не вибрали область.",
            'city.required' => "Поле «Місцезнаходження» обов'язково для заповнення.",
            'guarantee_fee.required' => "Поле «Гарантійний внесок» язково для заповнення.",
            'bid_price.required' => "Поле «Крок аукціону» обов'язково для заповнення.",
            'data_start.required' => "Поле «Дата початку аукціону» обов'язково для заповнення.",
            'date_end.required' => "Поле «Дата завершення аукціону» обов'язково для заповнення.",
            'property_material.required' => 'Ви не вибрали матеріал будівлі.',
            'property_floors.required' => "Поле «Кількість поверхів» обов'язково для заповнення.",
            'property_areas.required' => "Поле «Кімнат/приміщень» обов'язково для заповнення.",
            'property_totalarea.required' => "Поле «Загальна площа» обов'язково для заповнення.",
            'property_livingarea.required' => "Поле «Житлова площа» обов'язково для заповнення.",
            'auto_mark.required' => "Ви не вибрали марку автомобіля.",
            'auto_model.required' => "Поле «Модель» обов'язково для заповнення.",
            'auto_year.required' => "Поле «Рік випуску» обов'язково для заповнення.",
            'auto_transmission.required' => "Поле «Коробка передач» обов'язково для заповнення.",
            'auto_drive.required' => "Поле «Тип приводу» обов'язково для заповнення.",
            'auto_fuel.required' => "Поле «Тип пального» обов'язково для заповнення.",
            'auto_doors.required' => "Поле «Кількість дверей» обов'язково для заповнення.",
            'documents.max' => "Размер файла.",
        );

        $category = Cat::find($request->lot_category); // Категория в которую добавляем лот

        // Обязательные поля для заполнения
        $rights = ['lot_title' => 'required', 'lot_category' => 'required', 'region' => 'required', 'city' => 'required', 'documents' => 'max:5000'];

        // Если категория имеет подкатегории - добавляем указание подкатегории обязательным для заполнения полем
        if($request->category && $category->children()->count() > 0) {
            $rights = array_add($rights, 'lot_type', 'required'); // Тип лота
        }

        // Если добавлены прикрепления - добавляем валидацию по расширению файла
        if($request->hasFile('documents')) {
            //$rights = array_add($rights, 'documents', 'mimes:jpeg,bmp,png,pdf,doc,docx');
            $files = $request->file('documents');
            $i = 0;
            foreach($files as $file) {
                //$rights = array_add($rights, 'documents'. $i, 'max:8000');
                $messages['documents.' . $i . '.max'] = 'Розмір файлу «'. $file->getClientOriginalName() .'» перевищує достустимый (8 мб).'; // Индивидуальное сообщение об ошибке для каждого файла
                $rights['documents.' . $i] = 'max:8000'; // Ограничение по размеру для каждого файла
                $i++;
            }
        }

        // Если объект свободной продажи
        if($request->free_sale) {
            $messages['starting_price.required'] = "Поле «Вартість» обов'язково для заповнення.";
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
            $messages['starting_price.required'] = "Поле «Стартова ціна» обов'язково для заповнення.";
        }

        // Запрашиваем список обязательных полей для текущей категории и типа лота
        $rights = $this->getRightsForCategory($request->lot_category, $request->lot_type, $rights);

        // Выполняем валидацию
        $validator = Validator::make($request->all(), $rights, $messages);
        // При обнаружении ошибки - возвращаем пользователя на предыдущую страницу и выводим ошибки
        if($validator->fails()) { return redirect()->back()->withInput()->withErrors($validator->errors()); }


        /*
         * Добавление аукциона после успеной валидации
         */
        $create = new Auction();
        $create->title = $request->lot_title;
        $create->user = Auth::id();
        $create->category = $request->lot_category;
        $create->lot_type = $request->lot_type;
        $create->slug = str_slug($request->lot_title, '-');

        $this->getAddFieldsListCategory($request->lot_category, $create, $request);

        $create->more_information = $request->more_information; // Додаткові відомості
        $create->more_about = $request->more_about; // Відомості про майно, його склад, характеристики, опис
        $create->region = $request->region; // Область
        $create->city = $request->city; // Місцезнаходження
        $create->property_type = $request->property_type; // Тип майна
        $create->currency = $request->currency; // Валюта

        // Если есть основная фотография
        if($request->lot_image) {
            $create->img = $request->lot_image;
            $create->img_min = $request->lot_image_min;
        }
        else { // Если нет, ставим стандартные
            $create->img = "https://uace.com.ua/static/images/no-picture-max.jpg";
            $create->img_min = "https://uace.com.ua/static/images/no-picture-min.jpg";
        }

        // Статус по-умолчанию: 0 (не утвержден)
        $create->status = 0;

        // Если установлен флажок на "Свободная продажа"
        if($request->free_sale) {
            $create->free_sale = 1; // Помечаем как свободно продаваемый объект
            // Если установлен флажок на "Ціна договірна"
            if($request->negotiable_price) {
                $create->negotiable_price = 1;
            } else { // В противном случае записываем введенную цену
                $create->starting_price = str_replace(" ","",$request->starting_price);
            }
        }

        // Если добавлен предмет на аукцион (не свободная продажа)
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

        // Сохранение данных
        $create->save();

        // Ищет загруженные изображения с ID добавленного файла и добавляет к ним ID лота
        $attaches = Uploads::find($request->more_images);
        if($attaches) {
            foreach ($attaches as $attach) {
                $attach->auction_id = $create->id;;
                $attach->type = 'image';
                $attach->save();
            }
        }

        // Если есть прикрепленные файлы - загружаем их
        if($request->hasFile('documents')) {
            $files = $request->file('documents');
            foreach($files as $file)
            {
                $surl = $this->globalSiteSettings['site_url'];
                $filename = preg_replace('/.[^.]*$/', '', $file->getClientOriginalName());
                $filename = $filename . '-' . mt_rand(10,100) . '.' . $file->getClientOriginalExtension();
                $genLink = $surl.'/uploads/docs/'.$filename; // Генерируем ссылку
                $file->move(public_path() . '/uploads/docs/', $filename); // Перемещаем файл
                $upload = new Uploads(); // Создаем экземпляр модели
                $upload->type = 'doc'; // Задаем тип экземпляра - документ
                $upload->link = $genLink; // Записываем сгенерированную ранее ссылку
                $upload->name = preg_replace('/.[^.]*$/', '', $file->getClientOriginalName()); // Записываем имя
                $upload->auction_id = $create->id; // Записываем сгенерированную ранее ссылку
                $upload->save(); // Сохраняем
            }
        }

        // Отправка оповещения о новом лоте администратору на E-mail
        $this->sendNotificationAboutNewLot($create, $this->globalSiteSettings['admin_email']);

        Session::flash('gAnalyticsReachGoal', 'NEW_LOT'); // Отправка данных о достижении цели в Google Аналитику
        Session::flash('YaMetrikaReachGoal', 'NEW_LOT'); // Отправка данных о достижении цели в Яндекс Метрику
        Session::flash('addsuccess', '1');
        return redirect('/auctions');
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
            $create->equipment_brand = $request->equipment_brand;
            $create->equipment_model = $request->equipment_model;
            $create->equipment_year = $request->equipment_year;
            $create->equipment_power = $request->equipment_power;
        }

        if($id == 30) // Техніка та меблі
        {
            $create->stuff_brand = $request->stuff_brand;
            $create->stuff_model = $request->stuff_model;
            $create->stuff_year = $request->stuff_year;
            $create->stuff_diagonal = $request->stuff_diagonal;
        }

        if($id == 39) // Будівельні матеріали
        {
            $create->build_materials_col = $request->build_materials_col;
            $create->build_materials_weight = $request->build_materials_weight;
            $create->build_materials_volume = $request->build_materials_volume;
            $create->build_materials_width = $request->build_materials_width;
        }

        return $create;
    }

    /**
     * Отправка сообщения о добавленном лоте
     */
    public function sendNotificationAboutNewLot($lot, $email) {

        $user = User::find($lot->user);
        $cat = Cat::find($lot->category);

        $tempvar = array(
            'lot_id' => $lot->id,
            'lot_title' => $lot->title,
            'lot_category' => $cat->name,
            'lot_region' => $lot->region,
            'lot_city' => $lot->city,
            'starting_price' => $lot->starting_price,
            'negotiable_price' => $lot->negotiable_price,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'phone' => $user->phone
        );

        Mail::send('emails.newlot', $tempvar, function($message) use ($email) {
            $message->to($email)->subject('У систему UACE доданий новий лот!');
        });
    }

    /**
     * Создание категории (AJAX)
     */

    public function addCategory(Request $request) {

        $this->validate($request, [
            'title' => 'required',
            'url' => 'required',
        ]);

        $category = new Categories();
        $category->title = $request->title;
        $category->slug = $request->url;

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = str_random(10);
            $extension = $file->getClientOriginalExtension();
            $surl = $this->globalSiteSettings['site_url'];
            $imgurl = $surl.'/uploads/'.$filename.'.'.$extension;
            Image::make($request->file('image'))->fit(135, 120)->save(public_path().'/uploads/'.$filename.'.'.$extension);
            $category->img = $imgurl;
        }

        if($category->save()) {
            Session::flash('success', 'Категория «' . $request->title . '» успешно создана.');
            return redirect()->back();
        }

            return response()->json(['status' => 'error']);

    }

    /**
     * Возвращает аукционны определенной категории
     */

    public function getCategory($slug) {
        return $slug;
    }

    /**
     * Страница регистрации
     */

    public function getRegister()
    {
        return view('auction.register');
    }


    /**
     * Страница изменения данных пользователя
     */

    public function getEdit()
    {
        $current = User::find(Auth::id());
        return view('auction.edit', ['current' => $current]);
    }

    /**
     * Изменение данных пользователя
     */

    public function postEdit(Request $request)
    {
        $current = User::find(Auth::id());
        $current->last_name = $request->LastName;
        $current->first_name = $request->FirstName;
        $current->middle_name = $request->MiddleName;
        $current->phone = $request->phone;
        $current->save();
        return redirect()->back();
    }

    /**
     * Страница добавления лота
     *
     */
    public function getAddLot()
    {
        return view('auction.lots.add');
    }

    /**
     * AJAX загрузка изображения
     */
    public function postImagesUpload(Request $request)
    {
        $file = $request->file('file');
        $filename = str_random(10); // Генерация случайного имени
        $extension = $file->getClientOriginalExtension(); // Берем расширение файла
        $surl = $this->globalSiteSettings['site_url'];
        $imgurl = $surl.'/uploads/a/'.$filename.'.'.$extension; // Ссылка на полный файл
        $imgurl_min = $surl.'/uploads/a/'.$filename.'-sm.'.$extension; // Ссылка на миниатюру
        Image::make($request->file('file'))->save(public_path().'/uploads/a/'.$filename.'.'.$extension); // Грузим полный файл
        Image::make($request->file('file'))->fit(230, 165)->save(public_path().'/uploads/a/'.$filename.'-sm.'.$extension); // Грузим миниатюру, предварительно обрезав

        $add = new Uploads(); // Создаем экземпляр загрузки
        $add->name = $filename.'.'.$extension; // Сохраняем имя файла
        $add->image = $imgurl; // Сохраняем ссылку на полный файл
        $add->image_small = $imgurl_min; // Сохраняем ссылку на миниатюру
        $add->save(); // Сохраняем экземпляр

        // Возвращаем ответ в формате json со статусом, названием файла на сервере, прямой ссылкой на полную копию и миниатюру, ID экземпляра
        return response()->json(['status' => 'success', 'responseText' => 'yas', 'url' => $filename.'.'.$extension, 'img' => $imgurl, 'imgmin' => $imgurl_min, 'id' => $add->id], 200);
    }

    public function postImageDelete(Request $request)
    {
        $del = Uploads::where('name', '=', $request->name); // Ищем загрузки по имени
        $del->delete(); // Удаляем экземпляр

        // Проверяем, есть ли файл с переданным именем на диске
        if(Storage::disk('upload_images')->exists($request->name)) {

            Storage::disk('upload_images')->delete($request->name); // Удаляем

            $e = substr(strrchr($request->name,'.'),1); // Расширение
            $n = preg_replace('/.[^.]*$/', '', $request->name); // Название

            Storage::disk('upload_images')->delete($n.'-sm.'.$e); // Удаляем миниатюру
        }

        // Возвращаем ответ в формате json со статусом
        return response()->json(['status' => 'success'], 200);
    }

    /*
     * Удаление файла по ID
     */
    public function postFileDelete(Request $request)
    {
        $del = Uploads::find($request->id); // Ищем экземпляр
        $fileDeleteName = pathinfo($del->link); // Загружаем информацию о пути к файлу

        // Если файл с таким именем существует на сервере - удаляем его
        if(Storage::disk('upload_docs')->exists($fileDeleteName['basename'])) {
            Storage::disk('upload_docs')->delete($fileDeleteName['basename']);
        }

        $del->delete(); // Удаляем экземпляр

        // Возвращаем ответ в формате json со статусом
        return response()->json(['status' => 'success'], 200);
    }

    /*
     * Возвращает страницу аукциона (старое)
     */

    public function getAuctionPage($id)
    {
        //return dd();

        $documents = Uploads::where(['auction_id' => $id, 'type' => 'doc'])->get();

        $auction = Auction::findOrFail($id);
        $haveBidder = 0;
        $Bidder = null;
        $currentUSD = Settings::where(['name' => 'usd_cyr'])->first();
        $currentEUR = Settings::where(['name' => 'eur_cyr'])->first();

        $Bidder = Auction::with('bidders')->with('curuser')->find($id);
        $Bets = Bets::where('auction_id', '=', $id)->orderBy('created_at', 'desc')->get();

        if(Auth::check()) {
            $BidderCurrent = Bidders::where('user_id', '=', Auth::user()->id)->where('auction_id', '=', $id)->get();
            $haveBidder = $BidderCurrent->count();
        }

        return view('auction.lots.single', ['auction' => $auction, 'documents' => $documents, 'haveBidder' => $haveBidder, 'Bidders' => $Bidder, 'Bets' => $Bets, 'currentUSD' => $currentUSD, 'currentEUR' => $currentEUR]);
    }

    /*
     * Поиск лота по id и названию
     */
    public function getAuctionPageBySlug($id, $slug) {
        try {
            $auction = Auction::where('id', '=', $id)->where('slug', '=', $slug)->firstOrFail();

            // Если аукцион не утвержден его сможет просматривать только администратор
            if($auction->status == 0) {
                if(Auth::check()) {
                    if(Auth::user()->is_admin != 1) {
                        abort(404);
                    }
                } else {
                    abort(404);
                }
            }

        } catch (\Exception $e) {
            // Если запись не найдена - показываем 404 ошибку
            abort(404);
        }

        // Выбираем документы лота
        $documents = Uploads::where(['auction_id' => $id, 'type' => 'doc'])->get();

        // Текуший курс доллара из настроек
        $currentUSD = Cache::remember('currentUSD', 10, function() {
            return Settings::where(['name' => 'usd_cyr'])->first();
        });

        // Текуший евро доллара из настроек
        $currentEUR = Cache::remember('currentEUR', 10, function() {
            return Settings::where(['name' => 'eur_cyr'])->first();
        });

        $haveBidder = 0;
        $Bidder = null;

        // Загружаем участников аукциона
        $Bidder = Auction::with('bidders')->with('curuser')->find($id);

        // Загружаем ставки
        $Bets = Bets::where('auction_id', '=', $id)->orderBy('created_at', 'desc')->get();

        // Если пользователь авторизован
        if(Auth::check()) {
            // Проверка, является ли текущий пользователь участником
            $BidderCurrent = Bidders::where('user_id', '=', Auth::user()->id)->where('auction_id', '=', $id)->get();
            $haveBidder = $BidderCurrent->count();
        }

        return view('auction.lots.single', ['auction' => $auction, 'documents' => $documents, 'haveBidder' => $haveBidder, 'Bidders' => $Bidder, 'Bets' => $Bets, 'currentUSD' => $currentUSD, 'currentEUR' => $currentEUR]);
    }

    /*function getAuctionUsersFields($ids)
    {
        foreach($ids as $id)
        {
            echo $id[0]['title'];
        }

        dd($ids);
    }*/

    /*
     * Сделать ставку
     */
    public function getAddBet($id) {

        // Проверка, является ли текущий пользователь участником
        $haveAccess = Bidders::where(['user_id' => Auth::user()->id, 'auction_id' => $id, 'status' => 1])->get();

        // Экземпляр лота
        $auction = Auction::find($id);

        // Список ставок
        $thisBids = Bets::where('auction_id', '=', $id)->orderBy('created_at', 'desc')->get();

        // Если пользователь не является участником - редиректим на главную страницу
        if($haveAccess->count() == 0) {
            return redirect('/auctions');
        }
        else {

            // Если данный пользователь является последним, кто сделал ставку и пытается сделать ее еще раз - редиректим назад и показываем ошибку
            if($thisBids->count() > 0 && $thisBids->first()->user_id == Auth::user()->id) {
                return redirect()->back()->with('bit_error', 'Ви вже зробили ставку!');
            }

            // Если пользователь не делал ставок, но имеет доступ
            $bet = new Bets(); // Создаем экземпляр ставки
            $bet->auction_id = $id; // Указываем id аукциона
            $bet->user_id = Auth::user()->id; // Указываем id пользователя

            // Если это первая ставка - складываем стартовую цену и цену за шаг
            if($thisBids->count() == 0) {
                $bet->bet = $auction->starting_price + $auction->bid_price;
            } else {
                // Добавляем цену за шаг к последнему ценовому предложению
                $bet->bet = $thisBids->first()->bet + $auction->bid_price;
            }

            // Продлеваем аукцион еще на 15 минут
            $auction->date_end = Carbon::parse($auction->date_end)->addMinutes(15);
            $auction->save();
            $bet->save();

        }

        // В случае успеха - редиректим назад и передаем flash переменную
        return redirect()->back()->with('bit_success', '1');
    }

    /*
     * Показываем все лоты продавца
     */
    public function getUserLots($id, Request $request){

        $lots = Auction::query();
        $lots = $lots->where('status', '>', 0); // Выбираем только утвержденные
        $lots = $lots->where('user', '=', $id); // Принадлежащие пользователю по переданному ID

        if($request->sortBy == 'lowcost') {
            $lots = $lots->orderBy('starting_price', 'asc');
        }
        elseif($request->sortBy == 'topcost') {
            $lots = $lots->orderBy('starting_price', 'desc');
        }
        else {
            $lots = $lots->orderBy('starting_price', 'desc');
        }

        if($request->items_per_page) {
            $lots = $lots->paginate($request->items_per_page);
        } else {
            $lots = $lots->paginate(10);
        }

        $user = User::find($id);
        $cats = Cat::roots()->get();

        return view('auction.profile-lots', ['lots' => $lots, 'categories' => $cats, 'currentCategory' => null, 'request' => null, 'user' => $user]);
    }

    public function getProtocol($id)
    {
        return view('auction.lots.protocol', ['auction_id' => $id]);

    }
    
    /**
     * Генерирует sitemap.xml
     *
     */
    public function getSitemap()
    {
        $auctions = Cache::remember('auctions_sitemap', 3600, function()
        {
            $auctions = Auction::where('status', '>', 0)->get();
            return $auctions;
        });
        
        $pages = Cache::remember('pages_sitemap', 3600, function()
        {
            $pages = Pages::all();
            return $pages;
        });
        
        $news = Cache::remember('news_sitemap', 3600, function()
        {
            $news = News::where('date_publish', '<=', Carbon::parse(Carbon::now())->format('Y-m-d H:i'))->get();
            return $news;
        });
        
        $xml = view('sitemap', ['auctions' => $auctions, 'pages' => $pages, 'news' => $news]);
        return response($xml)->header('Content-Type', 'text/xml; charset=utf-8');
    }
    
    /**
     * Отображает страницу с картой сайта
     *
     */
    public function getSitemapPage(Request $request)
    {
        $cats = Cache::remember('cats', 10, function()
        {
            return Cat::roots()->get();
        });
        
        $pages = Pages::all();
        
        $news = Cache::remember('news_sitemap', 3600, function()
        {
            $news = News::where('date_publish', '<=', Carbon::parse(Carbon::now())->format('Y-m-d H:i'))->where('category', '=', 0)->get();
            return $news;
        });
        
        $ogoloshenia = News::where('date_publish', '<=', Carbon::parse(Carbon::now())->format('Y-m-d H:i'))->where('category', '=', 1)->get();
        
        return view('auction.sitemap', ['categories' => $cats, 'currentCategory' => null, 'request' => $request, 'pages' => $pages, 'news' => $news, 'ogoloshenia' => $ogoloshenia]);
    }
    
    public function sendToYaMetrika(Request $request)
    {
        return view('yametrika-callback', ['id' => $request->id]);
    }

}
