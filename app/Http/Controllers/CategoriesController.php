<?php

namespace App\Http\Controllers;
use App\Auction;
use App\Settings;
use Baum\Node;
use App\Cat;
use App\Categories;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class CategoriesController extends Controller
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
     * Выводит список категорий аукционов
     */

    public function getCategories() {
        $cats = Categories::all();
        $categories = Cat::roots()->get();
        return view('dashboard.auctions.categories', ['categories' => $cats, 'cats' => $categories]);
    }

    /**
     * Возвращает страницу редактирования категории
     */
    public function getEditCategory($id)
    {
        $category = Cat::find($id);
        return view('dashboard.ajax.category-edit', ['category' => $category]);
    }

    /**
     * Обрабатывает запрос об изменении категории
     */
    public function postEditCategory(Request $request, $id)
    {
        $category = Cat::find($id);
        $category->name = $request->name;

        if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = str_random(10);
            $extension = $file->getClientOriginalExtension();
            $surl = Config::get('app.url');
            $imgurl = $surl.'/uploads/'.$filename.'.'.$extension;
            Image::make($request->file('image'))->fit(300, 267)->save(public_path().'/uploads/'.$filename.'.'.$extension);
            $category->image = $imgurl;
        }

        $category->save();
        return response()->json(['status' => 'success', 'responseText' => 'Данные успешно обновлены'], 200);
    }

    /*
     * Добавление категории
     */
    public function postAddCategory(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);

        if($request->parent == 0)
        {
            $root = Cat::create(['name' => $request->name]);
        }
        else
        {
            $root = Cat::find($request->parent);
            $child = Cat::create(['name' => $request->name]);
            $child->makeChildOf($root);
        }

        Session::flash('success', 'Категория «' . $request->name . '» успешно создана.');
        return redirect()->back();
    }

    /*
     *
     */
    public function getChildrensCategory($id)
    {
        $categories = Cat::find($id);
        $categories = $categories->children()->get();
        return view('dashboard.ajax.category-childrens', ['categories' => $categories]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index($id, Request $request)
    {
        $auctions = Auction::query();
        $auctions = $auctions->where('category', '=', $id);
        $auctions = $auctions->where('status', '>', 0);

        if($request->sortBy == 'lowcost') {
            $auctions = $auctions->orderBy('starting_price', 'asc');
        }
        elseif($request->sortBy == 'topcost') {
            $auctions = $auctions->orderBy('starting_price', 'desc');
        }
        elseif($request->sortBy == 'new') {
            $auctions = $auctions->orderBy('created_at', 'desc');
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
        $currentCategory = Cat::find($id);
        return view('auction.categories.index', ['auctions' => $auctions, 'categories' => $categories, 'currentCategory' => $currentCategory, 'request' => $request]);
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
