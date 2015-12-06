<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\News;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class NewsController extends Controller
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
    public function index()
    {
        $news = News::where(['category' => 0])->orderBy('id', 'desc')->get();
        //$news = $news->sortByDesc('id');
        return view('news', ['articles' => $news]);
    }

    public function getOgoloshenia()
    {
        $news = News::where(['category' => 1])->where('date_publish', '<=', Carbon::parse(Carbon::now())->format('Y-m-d H:i'))->orderBy('date_publish', 'desc')->get();
        $news = $news->sortByDesc('created_at');
        return view('ogoloshenia', ['articles' => $news]);
    }

    public function getArticle($slug) {
        try {
            $article = News::where('slug', '=', $slug)->firstOrFail();
            return view('news-single', ['post' => $article]);
        }
        catch (\Exception $e) {
            return redirect('/news');
        }
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
