<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{asset('static/css/bootstrap.css')}}" />
    <link rel="stylesheet" href="{{asset('static/css/main.css')}}" />
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon" />
    @yield('head')

</head>
<body class="lang-{{App::getLocale()}}">

@if(Auth::check() && Auth::user()->is_admin == 1)
    <div class="navbar navbar-inverse" role="navigation" style="margin-bottom: 0px;">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">UACE</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/dashboard">Админ-панель</a></li>
                    <li><a href="{{action('DashboardController@getAddNews')}}">Добавить новость</a></li>
                    <!--<li><a href="#">Profile</a></li>-->
                    <li><a href="/auth/logout">Выход</a></li>
                </ul>
                <!--<form class="navbar-form navbar-right">
                    <input type="text" class="form-control" placeholder="Search...">
                </form>-->
            </div>
        </div>
    </div>
@endif

<div id="link_to_auction">
    <div class="container">
        <a href="/auctions">@lang('theme.link_auction')</a>
    </div>
</div>

<header id="top_header">
    <div class="container">
        <div class="row">
            <div class="col-xs-3 col-md-3 col-lg-3">
                <div class="logo"></div>
            </div>
            <div class="col-xs-5 col-md-5 col-lg-4 col_info">
                <h1>@lang('theme.sitename')</h1>
                <div class="contacts">@lang('theme.contacts')<br>тел. @lang('theme.phone')<br>E-mail: <a href="mailto:info@uace.com.ua">info@uace.com.ua</a></div>
            </div>
            <div class="col-xs-3 col-md-3 col-lg-2 col_social">
                <div class="soc_buttons clearfix">
                    <a href="#" class="soc_button rss"></a>
                    <a href="#" class="soc_button fb"></a>
                    <a href="{{Config::get('app.vkurl')}}" target="_blank" class="soc_button vk"></a>
                </div>
            </div>
            <div class="col-lg-3 choice_lang">
                <div class="row">
                    <div class="col-xs-4"><a href="{{ url('lang/ukr')  }}" class="lang ukr"><i></i>Укр.</a></div>
                    <div class="col-xs-4"><a href="#" class="lang eng"><i></i>Англ.</a></div>
                    <div class="col-xs-4"><a href="{{ url('lang/ru')  }}" class="lang ru"><i></i>Рус.</a></div>
                </div>
                <form id="search" method="get">
                    <input type="text" name="s" placeholder="@lang('theme.search_placeholder')" class="search-input">
                </form>
            </div>
        </div>
    </div>
</header>

<section id="top_image">

</section>

<div class="container">
<div class="row">
    <aside id="aside-left" class="col-xs-3 col-md-3">
        <ul class="nav nav-pills nav-stacked sidebar-nav">
            <li><a href="/">@lang('theme.about')</a></li>
            <li><a href="/poslugi">@lang('theme.services')</a></li>
            <li><a href="/auctions">@lang('theme.auction')</a></li>
            <li><a href="/ogoloshenia">@lang('theme.ads')</a></li>
            <li><a href="/documents">@lang('theme.doc')</a></li>
            <li><a href="/news">@lang('theme.news')</a></li>
            <li><a href="/contacts">@lang('theme.cont')</a></li>
        </ul>
    </aside>
    <div class="col-xs-6 col-md-6">
        <article id="page" class="content">
            @yield('content')
        </article>
    </div>
    <div class="col-xs-3 col-md-3 col_sidebar">
        <aside id="sidebar">
            <object class="informer" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0" width="100" height="100">
                <param name="movie" value="http://i1.i.ua/finance/informer_cur_nbu.swf?langID=0" /><param name="quality" value="high" />
                <param name="bgcolor" value="#ffffff" />
                <embed src="http://i1.i.ua/finance/informer_cur_nbu.swf?langID=0" quality="high" bgcolor="#ffffff" width="100" height="100" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
            </object>
            <!-- код конвертера валют -->
            <style>
                #IUAcurrency {min-width: 135px; width: 135px;}
                #IUAcurrency * {font-family: Arial; font-size: 11px; margin: 0; padding: 0;}
                #IUAcurrency table {border-collapse: collapse; background: #FFF099; width: 100%; border: 1px solid #FFF090;}
                #IUAcurrency td {padding: 5px 5px 0 5px; text-align: center;}
                #IUAcurrency a {font-weight: bold; text-transform: uppercase; color: #000000; text-decoration: underline;}
                #IUAcurrency textarea {width: 97%;}
                #IUAcurrency select {width: 100%;}
                #IUAcurrency input {width: 100%; margin-bottom: 5px;}
            </style>
            <form id="IUAcurrency" method="POST" action="http://finance.i.ua/converter/" target="_blank"><table id="IUAcurrencyBody"><tr><td colspan="2"><a href="http://finance.i.ua/converter/" target="_blank" id="IUAcurrencyTitle">КОНВЕРТЕР ВАЛЮТ</a></td></tr><tr><td colspan="2"><select name="operation"><option value = "0">Хочу продать</option><option value="1">Хочу купить</option></select></td></tr><tr><td style="width: 40%"><input type="text" name="sum" value="0.00" style="margin: 0; font-size: 13px;" onblur="if (this.value == '') {this.value = '0.00'; };" onfocus="if (this.value == '0.00') this.value='';" /></td><td style="width: 40%"><select name="money"><option value="1">UAH</option><option value="840" selected>USD</option><option value="978">EUR</option><option value="643">RUB</option></select></td></tr><tr><td colspan="2"><input type="submit" value="Конвертировать"/></td></tr></table></form><!-- /код конвертера валют -->
            <a href="#" class="uace_button">Послуги наших партнерів</a>
            <a href="/question" class="uace_button question"><img src="/static/images/question-icon.png">Задати питання</a>
        </aside>

    </div>
</div>
</div>

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
                <a href="#" class="go_auction">@lang('theme.link_auction') »</a>
                <div class="created">@lang('theme.created')<br><a href="http://lid.labirinth.org/" target="_blank"><img src="{{'/static/images/l.png'}}"></a></div>
            </div>
        </div>
    </div>
</footer>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function(){
        $(function() {
            // Highlight the active nav link.
            var url = window.location.pathname;
            var filename = url.substr(url.lastIndexOf('/') + 1);
            $('.sidebar-nav a[href$="' + filename + '"]').parent().addClass("active");
        });
    });

</script>
</body>
</html>