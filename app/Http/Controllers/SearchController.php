<?php

namespace App\Http\Controllers;

use App\Auction;
use App\Cat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use \App\User;

class SearchController extends Controller
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
     * Обрабатываем стандартный поиск
     */
    public function getQuery(Request $request)
    {

        $auctions = Auction::query();
        if($request->category)
        {
            $auctions = $auctions->where('category', '=', $request->category);
        }

        if($request->category == 1) // Недвижимость
        {
            if($request->property_material) {
                $auctions = $auctions->where('property_material', '=', $request->property_material);
            }
            if($request->property_floors_from) {
                $auctions = $auctions->where('property_floors', '>=', $request->property_floors_from);
            }
            if($request->property_floors_to) {
                $auctions = $auctions->where('property_floors', '<=', $request->property_floors_to);
            }
            if($request->property_totalarea_from) {
                $auctions = $auctions->where('property_totalarea', '>=', $request->property_totalarea_from);
            }
            if($request->property_totalarea_to) {
                $auctions = $auctions->where('property_totalarea', '<=', $request->property_totalarea_to);
            }
            if($request->property_livingarea_from) {
                $auctions = $auctions->where('property_livingarea', '>=', $request->property_livingarea_from);
            }
            if($request->property_livingarea_to) {
                $auctions = $auctions->where('property_livingarea', '<=', $request->property_livingarea_to);
            }
        }

        if($request->category == 4) // Автомобили
        {
            if($request->auto_mark) {
                $auctions = $auctions->where('auto_mark', '=', $request->auto_mark);
            }
            if($request->auto_model)
            {
                $auctions = $auctions->where('auto_model', 'like', '%'.$request->auto_model.'%');
            }
            if($request->auto_year_from) {
                $auctions = $auctions->where('auto_year', '>=', $request->auto_year_from);
            }
            if($request->auto_year_to) {
                $auctions = $auctions->where('auto_year', '<=', $request->auto_year_to);
            }
            if($request->auto_transmission) {
                $auctions = $auctions->where('auto_transmission', '=', $request->auto_transmission);
            }
            if($request->auto_drive) {
                $auctions = $auctions->where('auto_drive', '=', $request->auto_drive);

            }
            if($request->auto_fuel) {
                $auctions = $auctions->where('auto_fuel', '=', $request->auto_fuel);
            }
            if($request->auto_doors) {
                $auctions = $auctions->where('auto_doors', '=', $request->auto_doors);
            }
        }

        if($request->lot_type)
        {
            $auctions = $auctions->where('lot_type', '=', $request->lot_type);
        }

        if($request->property_type) {
            $auctions = $auctions->whereIn('property_type', $request->property_type);
        }

        if($request->status == 1) {
            $auctions = $auctions->where('in_archive', '=', 1);
        }
        elseif($request->status) {
            $auctions = $auctions->where('status', '=', $request->status);
        }
        else {
            $auctions = $auctions->where('status', '!=', 0);
        }

        if($request->price_from)
        {
            $auctions = $auctions->where('starting_price', '>=', $request->price_from);
        }

        if($request->price_to)
        {
            $auctions = $auctions->where('starting_price', '<=', $request->price_to);
        }

        if($request->date_start)
        {
            $auctions = $auctions->where('data_start', '>=', Carbon::parse($request->date_start)->format('Y-m-d'));
        }

        if($request->date_end)
        {
            $auctions = $auctions->where('date_end', '<=', Carbon::parse($request->date_end)->format('Y-m-d'));
        }

        if($request->region)
        {
            $auctions = $auctions->where('region', '=', $request->region);
        }

        if($request->city)
        {
            $auctions = $auctions->where('city', 'like', '%'.$request->city.'%');
        }

        if($request->title)
        {
            $auctions = $auctions->where('title', 'like', '%'.$request->title.'%')->orWhere('id', '=', $request->title);
        }

        if($request->q)
        {
            $auctions = $auctions->where('title', 'like', '%'.$request->q.'%')->orWhere('id', '=', $request->q);
        }

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

        $categories = Cat::roots()->get();
        $currentCategory = Cat::find($request->category);

        return view('auction.search', ['auctions' => $auctions, 'categories' => $categories, 'currentCategory' => $currentCategory, 'request' => $request]);

    }

    /**
     * Обрабатываем стандартный и расширенный поиск для категории "Недвижимость"
     */
    public function getRealEstateQuery(Request $request)
    {
        $auctions = Auction::query();
        $auctions = $auctions->where('category', '=', $request->category);

        if($request->lot_type) {
            $auctions = $auctions->where('lot_type', '=', $request->lot_type);
        }

        if($request->lot_number) {
            $auctions = $auctions->where('id', '=', $request->lot_number);
        }

        if($request->lot_user) {
            $searchTerms = explode(' ', $request->lot_user);

            $query = User::query();
            foreach($searchTerms as $searchTerm){
                $query->where(function($q) use ($searchTerm){
                    $q->where('first_name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('last_name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('legal_entity', 'like', '%'.$searchTerm.'%');
                });
            }

            $users = $query->get();
            
            // Массив для ID обнаруженных пользователей
            $users_id = [];

            // Если есть пользователи, соответствующие запросу
            if($users->count() > 0) {
                // Перебираем каждого пользователя
                foreach ($users as $user) {
                    // Добавляем ID пользователя в массив $users_id
                    array_push($users_id, $user->id);
                }
            }

            // Применяем фильтрацию по совпадению с ID в массиве $users_id
            $auctions = $auctions->whereIn('user', $users_id);
        }

        if($request->property_material) {
                $auctions = $auctions->where('property_material', '=', $request->property_material);
            }
            if($request->property_purpose) {
                $auctions = $auctions->where('property_purpose', '=', $request->property_purpose);
            }
            if($request->property_floors_from) {
                $auctions = $auctions->where('property_floors', '<=', $request->property_floors_from);
            }
            if($request->property_floors_to) {
                $auctions = $auctions->where('property_floors', '>=', $request->property_floors_to);
            }
            if($request->property_totalarea_from) {
                $auctions = $auctions->where('property_totalarea', '>=', $request->property_totalarea_from);
            }
            if($request->property_totalarea_to) {
                $auctions = $auctions->where('property_totalarea', '<=', $request->property_totalarea_to);
            }
            if($request->property_areas_from) {
                $auctions = $auctions->where('property_areas', '>=', $request->property_areas_from);
            }
            if($request->property_areas_to) {
                $auctions = $auctions->where('property_areas', '<=', $request->property_areas_to);
            }
            if($request->property_livingarea_from) {
                $auctions = $auctions->where('property_livingarea', '>=', $request->property_livingarea_from);
            }
            if($request->property_livingarea_to) {
                $auctions = $auctions->where('property_livingarea', '<=', $request->property_livingarea_to);
            }

        if($request->price_from)
        {
            $auctions = $auctions->where('starting_price', '>=', $request->price_from);
        }

        if($request->price_to)
        {
            $auctions = $auctions->where('starting_price', '<=', $request->price_to);
        }

        if($request->title)
        {
            $auctions = $auctions->where('title', 'like', '%'.$request->title.'%')->orWhere('id', '=', $request->title);
        }

        if($request->region) {
            $auctions = $auctions->where('region', '=', $request->region);
        }
        if($request->city) {
            $auctions = $auctions->where('city', 'like', '%'.$request->city.'%');
        }

        if($request->property_type) {
            $auctions = $auctions->whereIn('property_type', $request->property_type);
        }

        if($request->date_start)
        {
            $auctions = $auctions->where('data_start', '>=', Carbon::parse($request->date_start)->format('Y-m-d'));
        }

        if($request->date_end)
        {
            $auctions = $auctions->where('date_end', '<=', Carbon::parse($request->date_end)->format('Y-m-d'));
        }

        $auctions = $auctions->paginate(10);
        $categories = Cat::roots()->get();
        $currentCategory = Cat::find($request->category);

        return view('auction.search', ['auctions' => $auctions, 'categories' => $categories, 'currentCategory' => $currentCategory, 'request' => $request]);
    }

    /**
     * Обрабатываем стандартный и расширенный поиск для категории "Авто"
     */
    public function getAutoQuery(Request $request)
    {
        $auctions = Auction::query();
        $auctions = $auctions->where('category', '=', $request->category);
        if($request->lot_type) {
            $auctions = $auctions->where('lot_type', '=', $request->lot_type);
        }

        if($request->lot_number) {
            $auctions = $auctions->where('id', '=', $request->lot_number);
        }

        if($request->lot_user) {
            $searchTerms = explode(' ', $request->lot_user);

            $query = User::query();
            foreach($searchTerms as $searchTerm){
                $query->where(function($q) use ($searchTerm){
                    $q->where('first_name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('last_name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('legal_entity', 'like', '%'.$searchTerm.'%');
                });
            }

            $users = $query->get();
            
            // Массив для ID обнаруженных пользователей
            $users_id = [];

            // Если есть пользователи, соответствующие запросу
            if($users->count() > 0) {
                // Перебираем каждого пользователя
                foreach ($users as $user) {
                    // Добавляем ID пользователя в массив $users_id
                    array_push($users_id, $user->id);
                }
            }

            // Применяем фильтрацию по совпадению с ID в массиве $users_id
            $auctions = $auctions->whereIn('user', $users_id);
        }

        if($request->price_from)
        {
            $auctions = $auctions->where('starting_price', '>=', $request->price_from);
        }

        if($request->price_to)
        {
            $auctions = $auctions->where('starting_price', '<=', $request->price_to);
        }

        if($request->auto_mark) {
            $auctions = $auctions->where('auto_mark', '=', $request->auto_mark);
        }
        if($request->auto_model)
        {
            $auctions = $auctions->where('auto_model', 'like', '%'.$request->auto_model.'%');
        }
        if($request->auto_year_from) {
            $auctions = $auctions->where('auto_year', '>=', $request->auto_year_from);
        }
        if($request->auto_year_to) {
            $auctions = $auctions->where('auto_year', '<=', $request->auto_year_to);
        }
        if($request->auto_transmission) {
            $auctions = $auctions->where('auto_transmission', '=', $request->auto_transmission);
        }
        if($request->auto_drive) {
            $auctions = $auctions->where('auto_drive', '=', $request->auto_drive);

        }
        if($request->auto_fuel) {
            $auctions = $auctions->where('auto_fuel', '=', $request->auto_fuel);
        }
        if($request->auto_doors) {
            $auctions = $auctions->where('auto_doors', '=', $request->auto_doors);
        }

        if($request->lot_DebtorName) {
            $auctions = $auctions->where('lot_DebtorName', 'like', '%'.$request->lot_DebtorName.'%');
        }

        if($request->lot_EDRPOU) {
            $auctions = $auctions->where('lot_EDRPOU', '=', $request->lot_EDRPOU);
        }

        if($request->region)
        {
            $auctions = $auctions->where('region', '=', $request->region);
        }

        if($request->title)
        {
            $auctions = $auctions->where('title', 'like', '%'.$request->title.'%')->orWhere('id', '=', $request->title);
        }

        if($request->property_type) {
            $auctions = $auctions->whereIn('property_type', $request->property_type);
        }

        if($request->date_start)
        {
            $auctions = $auctions->where('data_start', '>=', Carbon::parse($request->date_start)->format('Y-m-d'));
        }

        if($request->date_end)
        {
            $auctions = $auctions->where('date_end', '<=', Carbon::parse($request->date_end)->format('Y-m-d'));
        }

        $auctions = $auctions->paginate(10);
        $categories = Cat::roots()->get();
        $currentCategory = Cat::find($request->category);

        return view('auction.search', ['auctions' => $auctions, 'categories' => $categories, 'currentCategory' => $currentCategory, 'request' => $request]);
    }

    /**
     * Обрабатываем стандартный и расширенный поиск для категории "Строительные материалы"
     */
    public function getBuildQuery(Request $request)
    {
        $auctions = Auction::query();
        $auctions = $auctions->where('category', '=', $request->category);
        if($request->lot_type) {
            $auctions = $auctions->where('lot_type', '=', $request->lot_type);
        }
        if($request->region) {
            $auctions = $auctions->where('region', '=', $request->region);
        }
        if($request->title) {
            $auctions = $auctions->where('title', 'like', '%'.$request->title.'%')->orWhere('id', '=', $request->title);
        }
        if($request->city) {
            $auctions = $auctions->where('city', 'like', '%'.$request->city.'%');
        }
        if($request->lot_DebtorName) {
            $auctions = $auctions->where('lot_DebtorName', 'like', '%'.$request->lot_DebtorName.'%');
        }
        if($request->lot_EDRPOU) {
            $auctions = $auctions->where('lot_EDRPOU', '=', $request->lot_EDRPOU);
        }
        if($request->property_type) {
            $auctions = $auctions->whereIn('property_type', $request->property_type);
        }
        if($request->price_from) {
            $auctions = $auctions->where('starting_price', '<=', $request->price_from);
        }
        if($request->price_to) {
            $auctions = $auctions->where('starting_price', '<=', $request->price_to);
        }
        if($request->date_start) {
            $auctions = $auctions->where('data_start', '>=', Carbon::parse($request->date_start)->format('Y-m-d'));
        }
        if($request->date_end) {
            $auctions = $auctions->where('date_end', '<=', Carbon::parse($request->date_end)->format('Y-m-d'));
        }
        if($request->build_materials_col_from) {
            $auctions = $auctions->where('build_materials_col', '>=', $request->build_materials_col_from);
        }
        if($request->build_materials_col_to) {
            $auctions = $auctions->where('build_materials_col', '<=', $request->build_materials_col_to);
        }
        if($request->build_materials_weight_from) {
            $auctions = $auctions->where('build_materials_weight', '>=', $request->build_materials_weight_from);
        }
        if($request->build_materials_weight_to) {
            $auctions = $auctions->where('build_materials_weight', '<=', $request->build_materials_weight_to);
        }
        if($request->build_materials_width_from) {
            $auctions = $auctions->where('build_materials_width', '>=', $request->build_materials_width_from);
        }
        if($request->build_materials_width_to) {
            $auctions = $auctions->where('build_materials_width', '<=', $request->build_materials_width_to);
        }
        if($request->lot_number) {
            $auctions = $auctions->where('id', '=', $request->lot_number);
        }
        if($request->lot_user) {
            $searchTerms = explode(' ', $request->lot_user);

            $query = User::query();
            foreach($searchTerms as $searchTerm){
                $query->where(function($q) use ($searchTerm){
                    $q->where('first_name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('last_name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('legal_entity', 'like', '%'.$searchTerm.'%');
                });
            }

            $users = $query->get();
            
            // Массив для ID обнаруженных пользователей
            $users_id = [];

            // Если есть пользователи, соответствующие запросу
            if($users->count() > 0) {
                // Перебираем каждого пользователя
                foreach ($users as $user) {
                    // Добавляем ID пользователя в массив $users_id
                    array_push($users_id, $user->id);
                }
            }

            // Применяем фильтрацию по совпадению с ID в массиве $users_id
            $auctions = $auctions->whereIn('user', $users_id);
        }
        $auctions = $auctions->paginate(10);
        $categories = Cat::roots()->get();
        $currentCategory = Cat::find($request->category);

        return view('auction.search', ['auctions' => $auctions, 'categories' => $categories, 'currentCategory' => $currentCategory, 'request' => $request]);

    }

    /**
     * Обрабатываем стандартный и расширенный поиск для категории "Производственное оборудование"
     */
    public function getEquipmentQuery(Request $request)
    {
        $auctions = Auction::query();
        $auctions = $auctions->where('category', '=', $request->category);
        if($request->lot_type) {
            $auctions = $auctions->where('lot_type', '=', $request->lot_type);
        }
        if($request->region) {
            $auctions = $auctions->where('region', '=', $request->region);
        }
        if($request->title) {
            $auctions = $auctions->where('title', 'like', '%'.$request->title.'%')->orWhere('id', '=', $request->title);
        }
        if($request->city) {
            $auctions = $auctions->where('city', 'like', '%'.$request->city.'%');
        }
        if($request->lot_DebtorName) {
            $auctions = $auctions->where('lot_DebtorName', 'like', '%'.$request->lot_DebtorName.'%');
        }
        if($request->lot_EDRPOU) {
            $auctions = $auctions->where('lot_EDRPOU', '=', $request->lot_EDRPOU);
        }
        if($request->property_type) {
            $auctions = $auctions->whereIn('property_type', $request->property_type);
        }
        if($request->price_from) {
            $auctions = $auctions->where('starting_price', '<=', $request->price_from);
        }
        if($request->price_to) {
            $auctions = $auctions->where('starting_price', '<=', $request->price_to);
        }
        if($request->date_start) {
            $auctions = $auctions->where('data_start', '>=', Carbon::parse($request->date_start)->format('Y-m-d'));
        }
        if($request->date_end) {
            $auctions = $auctions->where('date_end', '<=', Carbon::parse($request->date_end)->format('Y-m-d'));
        }
        if($request->equipment_model) {
            $auctions = $auctions->where('equipment_model', '=', $request->equipment_model);
        }
        if($request->equipment_year) {
            $auctions = $auctions->where('equipment_year', '=', $request->equipment_year);
        }
        if($request->equipment_power) {
            $auctions = $auctions->where('equipment_power', '=', $request->equipment_power);
        }
        if($request->lot_number) {
            $auctions = $auctions->where('id', '=', $request->lot_number);
        }
        if($request->lot_user) {
            $searchTerms = explode(' ', $request->lot_user);

            $query = User::query();
            foreach($searchTerms as $searchTerm){
                $query->where(function($q) use ($searchTerm){
                    $q->where('first_name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('last_name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('legal_entity', 'like', '%'.$searchTerm.'%');
                });
            }

            $users = $query->get();
            
            // Массив для ID обнаруженных пользователей
            $users_id = [];

            // Если есть пользователи, соответствующие запросу
            if($users->count() > 0) {
                // Перебираем каждого пользователя
                foreach ($users as $user) {
                    // Добавляем ID пользователя в массив $users_id
                    array_push($users_id, $user->id);
                }
            }

            // Применяем фильтрацию по совпадению с ID в массиве $users_id
            $auctions = $auctions->whereIn('user', $users_id);
        }
        $auctions = $auctions->paginate(10);
        $categories = Cat::roots()->get();
        $currentCategory = Cat::find($request->category);

        return view('auction.search', ['auctions' => $auctions, 'categories' => $categories, 'currentCategory' => $currentCategory, 'request' => $request]);

    }

    /**
     * Обрабатываем стандартный и расширенный поиск для категории "Техника и мебель"
     */
    public function getStuffQuery(Request $request) {
        $auctions = Auction::query();
        $auctions = $auctions->where('category', '=', $request->category);
        if($request->lot_type) {
            $auctions = $auctions->where('lot_type', '=', $request->lot_type);
        }
        if($request->region) {
            $auctions = $auctions->where('region', '=', $request->region);
        }
        if($request->title) {
            $auctions = $auctions->where('title', 'like', '%'.$request->title.'%')->orWhere('id', '=', $request->title);
        }
        if($request->city) {
            $auctions = $auctions->where('city', 'like', '%'.$request->city.'%');
        }
        if($request->lot_DebtorName) {
            $auctions = $auctions->where('lot_DebtorName', 'like', '%'.$request->lot_DebtorName.'%');
        }
        if($request->lot_EDRPOU) {
            $auctions = $auctions->where('lot_EDRPOU', '=', $request->lot_EDRPOU);
        }
        if($request->property_type) {
            $auctions = $auctions->whereIn('property_type', $request->property_type);
        }
        if($request->price_from) {
            $auctions = $auctions->where('starting_price', '<=', $request->price_from);
        }
        if($request->price_to) {
            $auctions = $auctions->where('starting_price', '<=', $request->price_to);
        }
        if($request->date_start) {
            $auctions = $auctions->where('data_start', '>=', Carbon::parse($request->date_start)->format('Y-m-d'));
        }
        if($request->date_end) {
            $auctions = $auctions->where('date_end', '<=', Carbon::parse($request->date_end)->format('Y-m-d'));
        }
        if($request->lot_number) {
            $auctions = $auctions->where('id', '=', $request->lot_number);
        }
        if($request->lot_user) {
            $searchTerms = explode(' ', $request->lot_user);

            $query = User::query();
            foreach($searchTerms as $searchTerm){
                $query->where(function($q) use ($searchTerm){
                    $q->where('first_name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('last_name', 'like', '%'.$searchTerm.'%')
                    ->orWhere('legal_entity', 'like', '%'.$searchTerm.'%');
                });
            }

            $users = $query->get();
            
            // Массив для ID обнаруженных пользователей
            $users_id = [];

            // Если есть пользователи, соответствующие запросу
            if($users->count() > 0) {
                // Перебираем каждого пользователя
                foreach ($users as $user) {
                    // Добавляем ID пользователя в массив $users_id
                    array_push($users_id, $user->id);
                }
            }

            // Применяем фильтрацию по совпадению с ID в массиве $users_id
            $auctions = $auctions->whereIn('user', $users_id);
        }
        if($request->stuff_brand) {
            $auctions = $auctions->where('stuff_brand', '=', $request->stuff_brand);
        }
        if($request->stuff_model) {
            $auctions = $auctions->where('stuff_model', '=', $request->stuff_model);
        }
        if($request->stuff_year) {
            $auctions = $auctions->where('stuff_year', '=', $request->stuff_year);
        }
        if($request->stuff_diagonal) {
            $auctions = $auctions->where('stuff_diagonal', '=', $request->stuff_diagonal);
        }

        $auctions = $auctions->paginate(10);
        $categories = Cat::roots()->get();
        $currentCategory = Cat::find($request->category);

        return view('auction.search', ['auctions' => $auctions, 'categories' => $categories, 'currentCategory' => $currentCategory, 'request' => $request]);
    }

}
