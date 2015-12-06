<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pages;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

class PageController extends Controller
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
    public function getPage($slug)
    {
        try {
            $page = Pages::where(['slug' => $slug])->firstOrFail();
            return view('page', ['page' => $page]);
        }
        catch (\Exception $e) {
            return redirect('/');
        }

    }

    public function getContactPage() {
        $page = Pages::where(['slug' => 'contacts'])->firstOrFail();
        return view('contacts', ['page' => $page]);
    }

    public function getPageWithTheme(){
        $path = Route::getCurrentRoute()->getPath();
        $page = Pages::where(['slug' => $path])->firstOrFail();
        return view($path, ['page' => $page]);
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
