<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'DashboardController@SiteIndex');

//Роуты, доступные только администраторам
Route::group(['middleware' => ['auth', 'ifadmin']], function () {

    //Главная страница ПУ
    Route::get('dashboard', ['uses' => 'DashboardController@index']);

    //Управление страницами
    Route::get('dashboard/pages', ['uses' => 'DashboardController@getPages']);
    Route::get('dashboard/pages/{id}/edit', ['uses' => 'DashboardController@getEditPage']);
    Route::post('dashboard/pages/{id}/edit', ['uses' => 'DashboardController@postEditPage']);
    Route::get('dashboard/pages/add', ['uses' => 'DashboardController@getAddPage']);
    Route::post('dashboard/pages/add', ['uses' => 'DashboardController@postAddPage']);

    //Управление новостями
    Route::get('dashboard/news', ['uses' => 'DashboardController@getNews']);
    Route::get('dashboard/news/add', ['uses' => 'DashboardController@getAddNews']);
    Route::post('dashboard/news/add', ['uses' => 'DashboardController@postAddNews']);
    Route::get('dashboard/news/{id}/edit', ['uses' => 'DashboardController@getEditNews']);
    Route::post('dashboard/news/{id}/edit', ['uses' => 'DashboardController@postEditNews']);
    Route::get('dashboard/news/delete/{id}', ['uses' => 'DashboardController@getDeleteNews']);

    //Категории аукционов
    Route::get('dashboard/auctions/categories', ['uses' => 'CategoriesController@getCategories']);
    Route::post('dashboard/auctions/categories/add', ['uses' => 'CategoriesController@postAddCategory']);
    Route::get('dashboard/auctions/categories/edit-{id}', ['uses' => 'CategoriesController@getEditCategory']);
    Route::post('dashboard/auctions/categories/edit-{id}', ['uses' => 'CategoriesController@postEditCategory', 'nocsrf' => true]);

    // Редактирование название прикрепленного документа
    Route::get('dashboard/auctions/rename-file-{id}', ['uses' => 'DashboardController@getRenameFile']);
    Route::post('dashboard/auctions/rename-file-{id}', ['uses' => 'DashboardController@postRenameFile']);

    // Страница зарегистрированных пользователей
    Route::get('dashboard/users', ['uses' => 'DashboardController@getUsers']);
    Route::get('dashboard/users/search', ['uses' => 'DashboardController@searchUsers']);

    // Поиск по записям
    Route::get('dashboard/news/search', ['uses' => 'DashboardController@searchPost']);

    Route::get('dashboard/auctions', ['uses' => 'DashboardController@getAuctions']);
    Route::get('dashboard/auctions/add', ['uses' => 'DashboardController@getAddAuction']);
    Route::get('dashboard/auctions/edit/{id}', ['uses' => 'DashboardController@getEditLot']);
    Route::get('dashboard/auctions/{id}/delete', ['uses' => 'DashboardController@getDeleteLot']);
    Route::post('dashboard/auctions/edit/{id}', ['uses' => 'DashboardController@postUpdateLot']);
    Route::get('dashboard/auctions/{id}/bidders', ['uses' => 'DashboardController@getAuctionBidders']);
    Route::get('dashboard/auctions/{id}/bidders/{bidder_id}/edit', ['uses' => 'DashboardController@getAuctionBidderEdit']);
    Route::post('dashboard/auctions/{id}/bidders/{bidder_id}/edit', ['uses' => 'DashboardController@postAuctionBidderEdit']);
    Route::get('dashboard/auctions/search', ['uses' => 'DashboardController@getSearchAuctions']);

    // Файловый менеджер
    Route::get('dashboard/filemanager', ['uses' => 'DashboardController@getFileManager']);

    // Настройки сайта
    Route::get('dashboard/settings', ['uses' => 'DashboardController@getSettings']);
    Route::post('dashboard/settings', ['uses' => 'DashboardController@postSettings']);


    Route::get('auction/helpers/statuses-free', function() {
        return view('dashboard.ajax.get-statuses-free');
    });

    Route::get('auction/helpers/statuses-default', function() {
        return view('dashboard.ajax.get-statuses');
    });

});

Route::get('sitemap.xml', 'AuctionsController@getSitemap');
Route::get('sitemap', 'AuctionsController@getSitemapPage');

// Поиск для разных категорий
Route::get('auction/search', ['uses' => 'SearchController@getQuery']);
Route::get('auction/search/realestate', ['uses' => 'SearchController@getRealEstateQuery']);
Route::get('auction/search/auto', ['uses' => 'SearchController@getAutoQuery']);
Route::get('auction/search/build', ['uses' => 'SearchController@getBuildQuery']);
Route::get('auction/search/equipment', ['uses' => 'SearchController@getEquipmentQuery']);
Route::get('auction/search/stuff', ['uses' => 'SearchController@getStuffQuery']);

// Роуты аукциона
Route::get('auction/{id}-{slug}', ['uses' => 'AuctionsController@getAuctionPageBySlug']);
Route::get('auction/{id}', ['uses' => 'AuctionsController@getAuctionPage']);
Route::get('auction/{id}/add', ['uses' => 'BiddersController@getAddBidder']);
Route::post('auction/{id}/add', ['uses' => 'BiddersController@postAddBidder']);
Route::get('auction/{id}/bet', ['uses' => 'AuctionsController@getAddBet']);
Route::get('auction/{id}/protocol', ['uses' => 'AuctionsController@getProtocol']);

// Категория аукциона
Route::get('auction/category/{id}', ['uses' => 'CategoriesController@index']);

// Подгрузка дочерних категорий
Route::get('auction/helpers/childrens-{id}', ['uses' => 'CategoriesController@getChildrensCategory']);
Route::get('auction/helper/bets-{id}', ['uses' => 'BiddersController@ajaxGetBets']);

// Изменение данных пользователя
Route::get('auctions/profile/edit', ['middleware' => 'auth', 'uses' => 'AuctionsController@getEdit']);
Route::post('auctions/profile/edit', ['middleware' => 'auth', 'uses' => 'AuctionsController@postEdit']);

// Добавление лота
Route::get('auctions/add', ['middleware' => 'auth', 'uses' => 'AuctionsController@getAddLot']);
Route::post('auctions/add', ['middleware' => 'auth', 'uses' => 'AuctionsController@postAddLot']);

Route::post('auctions/upload/delete', ['middleware' => 'auth', 'nocsrf' => true, 'uses' => 'AuctionsController@postImageDelete']);
Route::post('auctions/upload/delete-file', ['middleware' => 'auth', 'nocsrf' => true, 'uses' => 'AuctionsController@postFileDelete']);
Route::post('auctions/upload/', ['middleware' => 'auth', 'uses' => 'AuctionsController@postImagesUpload']);

Route::get('auctions', ['uses' => 'AuctionsController@index']);
Route::get('auctions/now', ['uses' => 'AuctionsController@now']);
Route::get('auctions/archive', ['uses' => 'AuctionsController@archive']);

// Страница со списком лотов пользователя
Route::get('auctions/profile/{id}/lots', ['uses' => 'AuctionsController@getUserLots']);

Route::post('forms/question', ['uses' => 'FormsController@question']);
Route::post('forms/get-seller', ['uses' => 'FormsController@getSeller']);

Route::get('news', 'NewsController@index');
Route::get('post/{slug}', 'NewsController@getArticle');
Route::get('ogoloshenia', 'NewsController@getOgoloshenia');

Route::get('lang/{locale}', function ($locale) {

    // Проверяем, что у пользователя выбран доступный язык
    if (in_array($locale, \Config::get('app.locales'))) {
        Session::put('locale', $locale); // Устанавливаем его в сессии
    }

    return redirect()->back(); // Возвращаем пользователя назад

});

Route::get('chan2', function()
{
    return Carbon\Carbon::parse(Carbon\Carbon::now())->addMinutes(10)->format('Y-m-d H:i');

});

Route::group(['prefix'=>'uploader','nocsrf' => true],function(){
    Route::match(['get','post'],'/','DashboardController@upload');
});

// Роуты аутентификации
Route::get('auth/login',  'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Роуты регистрации
Route::post('auth/register', 'Auth\AuthController@postRegister');
Route::get('auctions/register', 'AuctionsController@getRegister');
//Route::get('auth/register', 'Auth\AuthController@getRegister');

// Роуты запроса ссылки для сброса пароля
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Роуты сброса пароля
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

// Роуты статических страниц
Route::get('contacts', 'PageController@getContactPage');
Route::get('question', 'PageController@getPageWithTheme');
Route::get('{slug}', 'PageController@getPage');