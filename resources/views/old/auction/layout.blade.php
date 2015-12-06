<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=1170px, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon" />
    <link rel="stylesheet" href="{{asset('static/css/bootstrap.css')}}" />
    <link rel="stylesheet" href="{{asset('static/css/main.css')}}" />
    <link rel="stylesheet" href="{{asset('static/css/auctions.css')}}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    @yield('head')
</head>

<body class="lang-{{App::getLocale()}}">

@if(Auth::check() && Auth::user()->is_admin == 1)
    @include('adminbar')
@endif

<header id="auctions_top">
    <div class="container">
        <div class="row">
            <div class="col-xs-2">
                <a href="/auctions"><div class="logo"></div></a>
            </div>
            <div class="col-xs-4">
                <div class="top_title">@lang('theme.sitename')</div>
            </div>
            <div class="col-xs-2 col_social ">
                <div class="soc_buttons clearfix">
                    <a href="#" class="soc_button rss"></a>
                    <a href="#" class="soc_button fb"></a>
                    <a href="http://vk.com/some" target="_blank" class="soc_button vk"></a>
                </div>
            </div>
            <div class="col-xs-4 col_contacts">
                <div class="contacts">@lang('theme.contacts')<br>тел. @lang('theme.phone')<br>E-mail: <a href="mailto:info@uace.com.ua">info@uace.com.ua</a></div>
            </div>
        </div>
    </div>
</header>

<div id="nav-container" class="container">
    <div class="row">
    <nav id="nav-auctions" class="navbar" role="navigation">
        <div class="navbar-header">

        </div>
        <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="border"><a href="/auctions">Торги</a></li>
                <li class="border"><a href="/documents">Документы</a></li>
                <li class="border"><a href="/contacts">Контакти</a></li>
            </ul>
            <form class="navbar-search" role="search" action="/auctions">
                <input id="search_text" form="search" type="text" name="title" class="form-control" placeholder="Пошук...">
            </form>
            <ul class="nav navbar-nav">
                <li class="border">
                    @if(Auth::check())
                    <a href="{{action('AuctionsController@getAddLot')}}">Подати оголошення</a></li>
                @else
                    <a href="#" data-toggle="modal" data-target="#LoginModal">Подати оголошення</a></li>
                    @endif
            </ul>
            <ul class="nav navbar-nav nav-login">
                @if(Auth::check())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="reg"></i>Профіль <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li style="padding: 3px 20px;color: #222;font-size: 15px;">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</li>
                            <li class="divider"></li>
                            <li><a href="{{ action('AuctionsController@getEdit') }}">Изменить данные</a></li>
                            <li><a href="{{ action('Auth\AuthController@getLogout') }}">Выйти</a></li>
                        </ul>
                    </li>
                @else
                <li><a href="#" data-toggle="modal" data-target="#LoginModal"><i class="login"></i>Вхід</a></li>
                <li><a href="{{action('AuctionsController@getRegister')}}"><i class="reg"></i>Реєстрація</a></li>
                @endif
            </ul>
        </div>
    </nav>
    </div>
</div>

<div id="auctions_counts">
    <div class="container">
    <div class="row">
        <? $auction_count = \App\Auction::all(); ?>
        <? $auction_count2 = \App\Auction::where('status', '=', 7)->get(); ?>
        <div class="col-xs-6 count">Отримано {{ $auction_count->count() }} заявок на сумму: <span>{{ number_format($auction_count->sum('starting_price'), 0, ',', ' ') }} грн</span></div>
        <div class="col-xs-6 count">Проведено {{ $auction_count2->count() }} торгів на сумму: <span>{{ number_format($auction_count2->sum('final_price'), 0, ',', ' ') }} грн</span></div>
    </div>
    </div>
</div>

@yield('content')

<footer id="main_footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-3 col-md-3">
                <div class="logo"></div>
                <div class="copyright">@lang('theme.copyright')</div>
            </div>
            <div class="col-xs-3 col-md-3 visible-lg">
                <div class="col_name">@lang('theme.bottom_nav')</div>
                <div class="nav_links">
                    <div class="row">
                        <div class="col-xs-6"><a href="/">@lang('theme.about')</a><br><a href="/poslugi">@lang('theme.services')</a><br><a href="/contacts">@lang('theme.cont')</a></div>
                        <div class="col-xs-6"><a href="/ogoloshenia">@lang('theme.ads')</a><br><a href="/documents">@lang('theme.doc')</a><br><a href="/news">@lang('theme.news')</a></div>
                    </div>
                </div>
            </div>
            <div class="col-xs-4 col-md-4 col-lg-3">
                <div class="col_name">@lang('theme.bottom_cont')</div>
                <div class="contacts">
                    <div class="adress"><i></i>@lang('theme.contacts')</div>
                    <div class="phone"><i></i>@lang('theme.phone_footer')</div>
                    <div class="email"><i></i>E-mail: <a href="mailto:info@uace.com.ua">info@uace.com.ua</a></div>
                </div>
            </div>
            <div class="col-xs-3 col-md-3 col_last">
                <div class="created">@lang('theme.created')<br><a href="http://lid.labirinth.org/" target="_blank"><img src="{{'/static/images/l.png'}}"></a></div>
            </div>
        </div>
    </div>
</footer>

@include('auction.modals')

<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<a href="/question" id="get_question">Задати питання</a>
</body>
</html>