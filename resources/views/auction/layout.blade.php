<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Товарною біржою «Українська агропромислова» створена проста та прозора система електронних торгів, що унеможливлює прояви будь-якої корупції та створює чесні правила на ринку біржової торгівлі."/>
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{url('//uace.com.ua/favicon.ico')}}" type="image/x-icon" />
    <link rel="stylesheet" href="{{asset('//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css')}}" />
    <link rel="stylesheet" href="{{url('//uace.com.ua/static/css/main.css')}}" />
    <link rel="stylesheet" href="{{url('//uace.com.ua/static/css/auctions.css')}}" />
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,400italic,700,700italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,300,100,700&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,400italic,300italic,300,600,600italic,700,700italic,800,800italic&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    @yield('head')

    <!--[if lt IE 9]>
	  <script src="{{url('//uace.com.ua/static/js/html5shiv.min.js')}}"></script>
	  <script src="{{url('//uace.com.ua/static/js/respond.min.js')}}"></script>
	<![endif]-->

</head>

<body class="lang-{{App::getLocale()}}"@if(Session::has('YaMetrikaReachGoal') || Session::has('gAnalyticsReachGoal')) onload="yaCounter33833349.reachGoal('{{ Session::get('YaMetrikaReachGoal') }}'); @if(Session::has('gAnalyticsReachGoal'))ga('send', 'event', 'Request', '{{ Session::get('gAnalyticsReachGoal') }}');@endif"@endif>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-70780724-1', 'auto');
  ga('send', 'pageview');

</script>

@if(Auth::check() && Auth::user()->is_admin == 1)
    @include('adminbar')
@endif

<header id="auctions_top">
    <div class="container">
        <div class="row">
            <div class="col-xs-5 col-md-3 col-lg-2">
                <a href="/"><div class="logo"></div></a>
            </div>
            <div class="hidden-xs col-sm-7 col-md-6 col-lg-4">
                <div class="top_title">@lang('theme.sitename')</div>
            </div>
            <div class="col-xs-2 col-md-3 col-lg-2 col_social hidden-xs">
                <div class="soc_buttons clearfix">

                    <a href="{{ $globalSiteSettings['twitter_link'] }}" target="_blank" class="soc_button rss"></a>
                    <a href="{{ $globalSiteSettings['fb_link'] }}" target="_blank" class="soc_button fb"></a>
                    <a href="{{ $globalSiteSettings['vk_link'] }}" target="_blank" class="soc_button vk"></a>
                </div>
            </div>
            <div class="col-xs-4 col_contacts visible-lg">
                <div class="contacts">@lang('theme.contacts')<br>тел. @lang('theme.phone')<br>E-mail: <a href="mailto:info@uace.com.ua">info@uace.com.ua</a></div>
            </div>
        </div>
    </div>
</header>

<div id="nav-container" class="container">
<nav id="new_res_menu" class="navbar navbar-default @if(Auth::check()) auth @else no-auth @endif">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand visible-xs" href="/">UACE</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav nav_left">
              <li><a href="/auctions">Торги</a></li>
              <li><a href="/documents#c">Документи</a></li>
              <li><a href="/contacts#c">Контакти</a></li>
              <li class="visible-md visible-sm visible-xs"><a href="/auction/search#c">Пошук</a></li>
              <li class="visible-lg">
                <form class="navbar-form navbar-left" @yield('search_param') role="search">
                  <div class="form-group">
                    <input type="text" form="search" name="q" @if(isset($request) && $request->q) value="{{ $request->q }}" @endif class="form-control" placeholder="Пошук...">
                  </div>
                </form>
              </li>
              <li>@if(Auth::check())<a href="{{action('AuctionsController@getAddLot')}}">Подати оголошення</a>@else<a href="#" data-toggle="modal" data-target="#LoginModal">Подати оголошення</a>@endif</li>
              @if(Auth::check())
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="reg"></i>Профіль <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                            <li style="padding: 3px 20px;color: #222;font-size: 15px;">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</li>
                            <li class="divider"></li>
                            <li><a href="{{ action('AuctionsController@getEdit') }}">Змінити інформацію</a></li>
                            <li><a href="{{ action('Auth\AuthController@getLogout') }}">Вийти</a></li>
                        </ul>
              </li>
               @else
              <li class="login"><a href="#" data-toggle="modal" data-target="#LoginModal"><i class="login"></i>Вхід</a></li>
              <li class="reg"><a href="{{action('AuctionsController@getRegister')}}"><i class="reg"></i>Реєстрація</a></li>
              @endif
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
</div>

<div id="auctions_counts">
    <div class="container">


<?
    $statistic = \Illuminate\Support\Facades\Cache::remember('statistic', 10, function() use ($globalSiteSettings)
    {
        $statistic = [];
        $receivedUSD = \App\Auction::where('currency', '=', 'USD')->get();
        $receivedUAH = \App\Auction::where('currency', '=', 'UAH')->get();
        $receivedEUR = \App\Auction::where('currency', '=', 'EUR')->get();
        $receivedUSD_sum = $receivedUSD->sum('starting_price') * $globalSiteSettings['usd_cyr'];
        $receivedEUR_sum = $receivedEUR->sum('starting_price') * $globalSiteSettings['eur_cyr'];
        $receivedUAH_sum = $receivedUAH->sum('starting_price');
        $statistic['receivedCount'] = $receivedUSD->count() + $receivedUAH->count() + $receivedEUR->count();
        $statistic['receivedSum'] = $receivedUSD_sum + $receivedEUR_sum + $receivedUAH_sum;

        $conductedUSD = \App\Auction::where('currency', '=', 'USD')->where('status', '=', 7)->get();
        $conductedUAH = \App\Auction::where('currency', '=', 'UAH')->where('status', '=', 7)->get();
        $conductedEUR = \App\Auction::where('currency', '=', 'EUR')->where('status', '=', 7)->get();
        $conductedUSD_sum = $conductedUSD->sum('starting_price') * $globalSiteSettings['usd_cyr'];
        $conductedEUR_sum = $conductedEUR->sum('starting_price') * $globalSiteSettings['eur_cyr'];
        $conductedUAH_sum = $conductedUAH->sum('starting_price');
        $statistic['conductedCount'] = $conductedUSD->count() + $conductedUAH->count() + $conductedEUR->count();
        $statistic['conductedSum'] = $conductedUSD_sum + $conductedEUR_sum + $conductedUAH_sum;

        return $statistic;

    });
?>

<div class="auctions_stat">
        <div class="text-center col col-md-6 col-xs-12">Отримано {{ $statistic['receivedCount']  }} заявок на суму: <span>{{ number_format($statistic['receivedSum'], 0, ',', ' ') }} грн</span></div>
        <div class="text-center col col-md-6 col-xs-12">Проведено {{ $statistic['conductedCount'] }} торгів на суму: <span>{{ number_format($statistic['conductedSum'], 0, ',', ' ') }} грн</span></div>
  </div>

    </div>
</div>

@yield('content')

<footer id="main_footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-4 col-md-3">
                <div class="logo"></div>
                <div class="copyright">@lang('theme.copyright')</div>
            </div>
            <div class="col-xs-5 col-md-3 hidden-md">
                <div class="col_name">@lang('theme.bottom_nav')</div>
                <div class="nav_links">
                    <div class="row">
                        <div class="col-xs-6"><a href="/">@lang('theme.about')</a><br><a href="/poslugi#c">@lang('theme.services')</a><br><a href="/contacts#c">@lang('theme.cont')</a><br><a href="/sitemap#c">@lang('theme.sitemap')</a></div>
                        <div class="col-xs-6"><a href="/ogoloshenia#c">@lang('theme.ads')</a><br><a href="/documents#c">@lang('theme.doc')</a><br><a href="/news#c">@lang('theme.news')</a></div>
                    </div>
                </div>
            </div>
            <div class="hidden-xs hidden-sm col-xs-4 col-md-4 col-lg-3">
                <div class="col_name">@lang('theme.bottom_cont')</div>
                <div class="contacts">
                    <div class="adress"><i></i>@lang('theme.contacts')</div>
                    <div class="phone"><i></i>@lang('theme.phone_footer')</div>
                    <div class="email"><i></i>E-mail: <a href="mailto:info@uace.com.ua">info@uace.com.ua</a></div>
                    <div class="working-time"><i></i>пн-пт 09.00 - 18.00</div>
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
<a href="/question#c" id="get_question" class="hidden-xs hidden-sm">Задати питання</a>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter33833349 = new Ya.Metrika({
                    id:33833349,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/33833349" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

</body>
</html>