@extends('auction.layout')
@section('title')Аукцион - @lang('theme.sitename_title')@endsection

@section('head')
    <script src="/static/js/jquery.bxslider.min.js"></script>
@endsection

@section('content')
    <div class="container">
        <div id="auction_single">
            <h1>{{ $auction->title }} @if(Auth::check() &&  Auth::user()->is_admin == 1) <a href="{{ action('DashboardController@getEditLot', ['id' => $auction->id]) }}" class="label label-primary" style="font-size: 11px; vertical-align: middle">Редагувати</a> @endif </h1>
            <div class="row">
                <div class="col-xs-5">
                    <?
                    $images = \App\Uploads::where('auction_id', '=', $auction->id)->get();
                    ?>


                    <div id="carousel" class="carousel slide" data-ride="carousel">
                        <!-- Indicators -->
                        <!-- Wrapper for slides -->
                        <div class="carousel-inner">
                            <div class="item active">
                                <img src="{{ $auction->img }}" alt="{{ $auction->title }}" class="img-responsive">
                            </div>
                            @foreach($images as $image)

                                <div class="item">
                                    <img src="{{ $image->image }}" alt="{{ $auction->title }}" class="img-responsive">
                                </div>
                            @endforeach

                        </div>

                        @if($images->count() > 0)
                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#carousel" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                        @endif
                    </div>

                    <script>
                        $(document).ready(function(){
                            $('.bxslider').bxSlider();
                        });
                    </script>

                    @if($auction->status == 2)
                        <div class="timer_row row">
                            <div class="col-xs-4">
                                До початку аукціону
                            </div>
                            <div class="col-xs-8">
                                <div id="auction_timer" class="timer">

                                    <div><p class="timer-day">02</p>днів</div>
                                    <div><p class="timer-hours">13</p>годин</div>
                                    <div><p class="timer-minutes">47</p>хвилин</div>
                                    <div><p class="timer-sec">21</p>секунд</div>
                                </div>
                            </div>
                        </div>

                        <script>
                            function get_timer_179(string_179) {  var date_new_179 = string_179; var date_t_179 = new Date(date_new_179); var date_179 = new Date();  var timer_179 = date_t_179 - date_179;    if(date_t_179 > date_179) {   var day_179 = parseInt(timer_179/(60*60*1000*24));    if(day_179 < 10) {      day_179 = "0" + day_179;    }   day_179 = day_179.toString();   var hour_179 = parseInt(timer_179/(60*60*1000))%24;   if(hour_179 < 10) {     hour_179 = "0" + hour_179;    }   hour_179 = hour_179.toString();   var min_179 = parseInt(timer_179/(1000*60))%60;   if(min_179 < 10) {      min_179 = "0" + min_179;    }   min_179 = min_179.toString();   var sec_179 = parseInt(timer_179/1000)%60;    if(sec_179 < 10) {      sec_179 = "0" + sec_179;    }   sec_179 = sec_179.toString();     timethis_179 = day_179 + " : " + hour_179 + " : " + min_179 + " : " + sec_179;    $(".timer .timer-day").text(day_179);    $(".timer .timer-hours").text(hour_179);    $(".timer .timer-minutes").text(min_179);   $(".timer .timer-sec").text(sec_179); } else {    $(".timer .timer-day").text("00");   $(".timer .timer-hours").text("00");    $(".timer .timer-minutes").text("00");    $(".timer .timer-sec").text("00");  }  }
                            function getfrominputs_179(){ string_179 = "{{ Carbon\Carbon::parse($auction->data_start)->format('m/d/Y H:i') }}";  get_timer_179(string_179);  setInterval(function(){   get_timer_179(string_179);  },1000);}
                            $(document).ready(function(){  getfrominputs_179();});
                        </script>

                    @elseif($auction->status == 3)
                    <div class="timer_row row">
                        <div class="col-xs-4">
                            До закінчення аукціону
                        </div>
                        <div class="col-xs-8">
                            <div id="auction_timer" class="timer">

                                <div><p class="timer-day">02</p>днів</div>
                                <div><p class="timer-hours">13</p>годин</div>
                                <div><p class="timer-minutes">47</p>хвилин</div>
                                <div><p class="timer-sec">21</p>секунд</div>
                            </div>
                        </div>
                    </div>

                        <script>
                            function get_timer_179(string_179) {  var date_new_179 = string_179; var date_t_179 = new Date(date_new_179); var date_179 = new Date();  var timer_179 = date_t_179 - date_179;    if(date_t_179 > date_179) {   var day_179 = parseInt(timer_179/(60*60*1000*24));    if(day_179 < 10) {      day_179 = "0" + day_179;    }   day_179 = day_179.toString();   var hour_179 = parseInt(timer_179/(60*60*1000))%24;   if(hour_179 < 10) {     hour_179 = "0" + hour_179;    }   hour_179 = hour_179.toString();   var min_179 = parseInt(timer_179/(1000*60))%60;   if(min_179 < 10) {      min_179 = "0" + min_179;    }   min_179 = min_179.toString();   var sec_179 = parseInt(timer_179/1000)%60;    if(sec_179 < 10) {      sec_179 = "0" + sec_179;    }   sec_179 = sec_179.toString();     timethis_179 = day_179 + " : " + hour_179 + " : " + min_179 + " : " + sec_179;    $(".timer .timer-day").text(day_179);    $(".timer .timer-hours").text(hour_179);    $(".timer .timer-minutes").text(min_179);   $(".timer .timer-sec").text(sec_179); } else {    $(".timer .timer-day").text("00");   $(".timer .timer-hours").text("00");    $(".timer .timer-minutes").text("00");    $(".timer .timer-sec").text("00");  }  }
                            function getfrominputs_179(){ string_179 = "{{ Carbon\Carbon::parse($auction->date_end)->format('m/d/Y H:i') }}";  get_timer_179(string_179);  setInterval(function(){   get_timer_179(string_179);  },1000);}
                            $(document).ready(function(){  getfrominputs_179();});
                        </script>


                    @elseif($auction->status > 3)
                        <div class="text-center">
                            <p style="font-size: 18px;font-family: "PT Sans";">Аукціон завершено</p>
                            <div class="row"><a href="{{ action('AuctionsController@getProtocol', ['id' => $auction->id]) }}" class="btn btn-primary btn-lg">Отримати протокол</a></div>
                        </div>
                        @endif

                    <style>
                        #carousel {
                            height: 300px;
                            overflow: hidden;
                        }


                        .timer_row {
                            padding: 30px 0 0 0;
                        }

                        .timer_row .col-xs-4 {
                            text-align: right;
                            font-size: 21px;
                            font-family: "PT Sans";
                            font-weight: 600;
                            line-height: 23px;
                            padding: 5px 0 0 0;
                        }

                        #auction_timer {
                            text-align: center;
                            font-family: "PT Sans";
                        }

                        #auction_timer h5 {
                            margin: 15px 0 15px 0;
                            font-size: 17px;
                        }

                        #auction_timer>div {
                            display: inline-block;
                        }

                        #auction_timer>div p {
                            box-shadow: 1px 1px 1px rgba(4, 4, 4, 0.35);
                            background-image: linear-gradient(bottom, #3A3A3A 50%, #444444 50%);
                            background-image: -o-linear-gradient(bottom, #3A3A3A 50%, #444444 50%);
                            background-image: -moz-linear-gradient(bottom, #3A3A3A 50%, #444444 50%);
                            background-image: -webkit-linear-gradient(bottom, #3A3A3A 50%, #444444 50%);
                            background-image: -ms-linear-gradient(bottom, #3A3A3A 50%, #444444 50%);
                            background-image: -webkit-gradient( linear, left bottom, left top, color-stop(0.5, #3A3A3A), color-stop(0.5, #444444) );
                            border-radius: 4px;
                            color: #fff;
                            width: 60px;
                            text-align: center;
                            line-height: 60px;
                            margin: 0 3px;
                            font-size: 30px;
                        }


                    </style>

                </div>
                <div class="col-xs-7">
                    <table class="table auction_info_table table-condensed">
                        <tbody>
                        <tr>
                            <td>Стан аукціону:</td>
                            <td>{{ trans('theme.statuses.'.$auction->status) }}</td>
                        </tr>
                        <tr>
                            <td>Дата закінчення подання заявок:</td>
                            <td>{{ Carbon\Carbon::parse($auction->data_start)->format('d.m.Y в H:i') }}</td>
                        </tr>
                        <tr>
                            <td>Дата початку аукціону:</td>
                            <td>{{ Carbon\Carbon::parse($auction->data_start)->format('d.m.Y в H:i') }}</td>
                        </tr>
                        <tr>
                            <td>Дата завершення аукціону:</td>
                            <td>{{ Carbon\Carbon::parse($auction->date_end)->format('d.m.Y в H:i') }}</td>
                        </tr>
                        <tr>
                            <td><b>Стартова ціна продажу:</b></td>
                            <td>{{ number_format($auction->starting_price, 2, ',', ' ') }} грн. </td>
                        </tr>
                        </tbody>
                    </table>

                    <table class="table auction_info_table table-condensed">
                        <tbody>
                        <tr>
                            <td>Розмір гарантійного внеску:</td>
                            <td>{{ number_format($auction->guarantee_fee, 2, ',', ' ') }} грн.</td>
                        </tr>
                        <tr>
                            <td>Крок аукціону:</td>
                            <td>{{ number_format($auction->bid_price, 2, ',', ' ') }} грн.</td>
                        </tr>
                        <tr>
                            <td>Місцезнаходження майна:</td>
                            <td>{{ trans('theme.regions.'.$auction->region) }}@if($auction->city), м. {{ $auction->city }} @endif</td>
                        </tr>
                        <tr>
                            <td>Дата публікації:</td>
                            <td>{{ Carbon\Carbon::parse($auction->created_at)->format('d.m.Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td>Продавець:</td>
                            <td>@if($auction->curuser[0]->legal_entity) <a href="{{ action('AuctionsController@getUserLots', ['id' => $auction->curuser[0]->id]) }}">{{ $auction->curuser[0]->legal_entity }}</a> @else <a href="{{ action('AuctionsController@getUserLots', ['id' => $auction->curuser[0]->id]) }}">{{ $auction->curuser[0]->first_name }} {{ $auction->curuser[0]->last_name }}</a>@endif
                                 <a class="label label-primary" href="{{ action('AuctionsController@getUserLots', ['id' => $auction->curuser[0]->id]) }}" style="margin: 0 0 0 5px;font-weight: 400">Всі лоти продавця</a></td>
                        </tr>
                        </tbody>
                    </table>

                    <div id="padZeroes"></div>

                    <script>
                        $('#padZeroes').countdown({until: new Date({{ Carbon\Carbon::parse($auction->data_start)->format('Y, m, d') }}), padZeroes: true});
                    </script>

                    @if($haveBidder == 0 and $auction->status == 2)
                        <div class="row">
                            <div class="col-xs-3">
                                <a href="{{ action('BiddersController@getAddBidder', ['id' => $auction->id]) }}" class="btn btn-primary btn-lg">Подати заявку</a>
                            </div>
                            <div class="col-xs-9">
                                <script type="text/javascript">(function(w,doc) {
                                        if (!w.__utlWdgt ) {
                                            w.__utlWdgt = true;
                                            var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
                                            s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                                            s.src = ('https:' == w.location.protocol ? 'https' : 'http')  + '://w.uptolike.com/widgets/v1/uptolike.js';
                                            var h=d[g]('body')[0];
                                            h.appendChild(s);
                                        }})(window,document);
                                </script>
                                <div style="padding: 5px 0 0px 20px" data-background-alpha="0.0" data-buttons-color="#ffffff" data-counter-background-color="#ffffff" data-share-counter-size="12" data-top-button="false" data-share-counter-type="common" data-share-style="13" data-mode="share" data-like-text-enable="false" data-hover-effect="scale" data-mobile-view="true" data-icon-color="#ffffff" data-orientation="horizontal" data-text-color="#000000" data-share-shape="rectangle" data-sn-ids="fb.vk.tw.ok.gp.ps.mr." data-share-size="30" data-background-color="#ffffff" data-preview-mobile="false" data-mobile-sn-ids="fb.vk.tw.wh.ok.gp." data-pid="1425301" data-counter-background-alpha="1.0" data-following-enable="false" data-exclude-show-more="false" data-selection-enable="true" class="uptolike-buttons" ></div>
                            </div>
                        </div>
                    {{-- Проверка, имеет ли аукцион статус "Відбуваються торги" --}}
                    @elseif($auction->status == 3)

                        <div class="row">
                            <div class="col-xs-3">
                                @if(!Auth::check())
                                    {{-- Если пользователь не авторизован, при нажатии открываем окно для входа --}}
                                    <a href="#" data-toggle="modal" data-target="#LoginModal" class="btn btn-primary btn-lg">Зробити ставку</a>
                                @else
                                    <?php
                                    // Запрос к списку участников (проверка, имеет ли текущий авторизованных пользователь статус Допущен до аукциона)
                                    // Вовзращает: 1 - если текущий пользователь успешно допущен (его заявка одобрена администрацией)
                                    // или 0 - если заявка не допущена или пользователь не подавал её вовсе
                                    $ee = \App\Bidders::where(['user_id' => Auth::user()->id, 'auction_id' => $auction->id, 'status' => 1])->get();
                                    ?>

                                    @if($ee->count() == 1)
                                        <a href="#" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#doBet">Зробити ставку</a>
                                    @endif

                                @endif{{-- Auth::check --}}
                            </div>
                            <div class="col-xs-9">
                                <script type="text/javascript">(function(w,doc) {
                                        if (!w.__utlWdgt ) {
                                            w.__utlWdgt = true;
                                            var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
                                            s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                                            s.src = ('https:' == w.location.protocol ? 'https' : 'http')  + '://w.uptolike.com/widgets/v1/uptolike.js';
                                            var h=d[g]('body')[0];
                                            h.appendChild(s);
                                        }})(window,document);
                                </script>
                                <div style="padding: 5px 0 0px 20px" data-background-alpha="0.0" data-buttons-color="#ffffff" data-counter-background-color="#ffffff" data-share-counter-size="12" data-top-button="false" data-share-counter-type="common" data-share-style="13" data-mode="share" data-like-text-enable="false" data-hover-effect="scale" data-mobile-view="true" data-icon-color="#ffffff" data-orientation="horizontal" data-text-color="#000000" data-share-shape="rectangle" data-sn-ids="fb.vk.tw.ok.gp.ps.mr." data-share-size="30" data-background-color="#ffffff" data-preview-mobile="false" data-mobile-sn-ids="fb.vk.tw.wh.ok.gp." data-pid="1425301" data-counter-background-alpha="1.0" data-following-enable="false" data-exclude-show-more="false" data-selection-enable="true" class="uptolike-buttons" ></div>
                            </div>
                        </div>

                    @else
                        <script type="text/javascript">(function(w,doc) {
                                if (!w.__utlWdgt ) {
                                    w.__utlWdgt = true;
                                    var d = doc, s = d.createElement('script'), g = 'getElementsByTagName';
                                    s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
                                    s.src = ('https:' == w.location.protocol ? 'https' : 'http')  + '://w.uptolike.com/widgets/v1/uptolike.js';
                                    var h=d[g]('body')[0];
                                    h.appendChild(s);
                                }})(window,document);
                        </script>
                        <div data-background-alpha="0.0" data-buttons-color="#ffffff" data-counter-background-color="#ffffff" data-share-counter-size="12" data-top-button="false" data-share-counter-type="common" data-share-style="13" data-mode="share" data-like-text-enable="false" data-hover-effect="scale" data-mobile-view="true" data-icon-color="#ffffff" data-orientation="horizontal" data-text-color="#000000" data-share-shape="rectangle" data-sn-ids="fb.vk.tw.ok.gp.ps.mr." data-share-size="30" data-background-color="#ffffff" data-preview-mobile="false" data-mobile-sn-ids="fb.vk.tw.wh.ok.gp." data-pid="1425301" data-counter-background-alpha="1.0" data-following-enable="false" data-exclude-show-more="false" data-selection-enable="true" class="uptolike-buttons" ></div>




                    @endif{{-- $auction->status == 3 --}}



                </div>
            </div>


            <div id="tabs">


                @if($Bets->count() > 0)

                <!-- Modal -->
                <div class="modal fade" id="doBet" tabindex="-1" role="dialog" aria-labelledby="doBet" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Підтвердження</h4>
                            </div>
                            <div class="modal-body">
                                Ви впевнені, що хочете підвищити останню ставку в {{ number_format($Bets[0]->bet, 2, ',', ' ') }} грн. ще на {{ number_format($auction->bid_price, 2, ',', ' ') }} грн.? Сума Вашої ставки складе {{ number_format($Bets[0]->bet + $auction->bid_price, 2, ',', ' ') }} грн.
                            </div>
                            <div class="modal-footer">
                                <a href="{{ action('AuctionsController@getAddBet', ['id' => $auction->id]) }}" type="button" class="btn btn-primary">Підтвердити</a>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Скасувати</button>
                            </div>
                        </div>
                    </div>
                </div>
                @elseif($auction->status == 3)
                        <!-- Modal -->
            <div class="modal fade" id="doBet" tabindex="-1" role="dialog" aria-labelledby="doBet" aria-hidden="true">
                <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Підтвердження</h4>
                    </div>
                    <div class="modal-body">
                        Ви впевнені, що хочете підвищити ціну {{ number_format($auction->starting_price, 2, ',', ' ') }} грн. ще на {{ number_format($auction->bid_price, 2, ',', ' ') }} грн.? Сума Вашої ставки складе {{ number_format($auction->starting_price + $auction->bid_price, 2, ',', ' ') }} грн.
                    </div>
                    <div class="modal-footer">
                        <a href="{{ action('AuctionsController@getAddBet', ['id' => $auction->id]) }}" type="button" class="btn btn-primary">Підтвердити</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Скасувати</button>
                    </div>
                </div>
            </div>
        </div>
                    @endif





                <ul class="nav nav-tabs nav-justified">
                    <li class="active"><a href="#features" data-toggle="tab">Характеристика лоту</a></li>
                    <li><a href="#info" data-toggle="tab">Інформація про лот</a></li>
                    <li><a href="#downloads" data-toggle="tab">Вкладення</a></li>
                    <li><a href="#bidders" data-toggle="tab">Заявки на участь</a></li>
                    <li><a href="#priceoffers" data-toggle="tab">Цінові пропозиції</a></li>
                    <li><a href="#downloads" data-toggle="tab">Порядок та умови</a></li>
                </ul>

                <div class="tab-content">

                        @if($auction->category == 1)
                            @include('auction.lots.inc.property')
                        @elseif($auction->category == 4)
                            @include('auction.lots.inc.auto')
                            @else
                        <div class="tab-pane active" id="features">
                            <div id="auction_more" class="row">
                                <div class="col-xs-6">
                                    <div class="col">
                                        <table class="table">
                                            <tbody>

                                            <tr>
                                                <td>Номер лоту</td>
                                                <td>{{ $auction->id }}</td>
                                            </tr>

                                            <tr>
                                                <td>Тип</td>
                                                <td>{{ $cat = \App\Cat::find($auction->lot_type)->name  }}</td>
                                            </tr>

                                            @if($auction->build_materials_col)
                                            <tr>
                                                <td>Кількість тис. шт.</td>
                                                <td>{{ $auction->build_materials_col }}</td>
                                            </tr>
                                            @endif

                                            @if($auction->build_materials_weight)
                                            <tr>
                                                <td>Маса, кг</td>
                                                <td>{{ $auction->build_materials_weight }}</td>
                                            </tr>
                                            @endif

                                            @if($auction->build_materials_width)
                                            <tr>
                                                <td>Ширина</td>
                                                <td>{{ $auction->build_materials_width }}</td>
                                            </tr>
                                            @endif

                                            @if($auction->equipment_brand)
                                                <tr>
                                                    <td>Виробник</td>
                                                    <td>{{ trans('theme.equipment_brand.'.$auction->equipment_brand) }}</td>
                                                </tr>
                                            @endif

                                            @if($auction->equipment_model)
                                                <tr>
                                                    <td>Модель</td>
                                                    <td>{{ trans('theme.equipment_model.'.$auction->equipment_model) }}</td>
                                                </tr>
                                            @endif

                                            @if($auction->equipment_year)
                                                <tr>
                                                    <td>Рік</td>
                                                    <td>{{ $auction->equipment_year }}</td>
                                                </tr>
                                            @endif

                                            @if($auction->equipment_power)
                                                <tr>
                                                    <td>Потужність</td>
                                                    <td>{{ $auction->equipment_power }} кВт</td>
                                                </tr>
                                            @endif


                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="col">

                                        <h4>Додаткові відомості:</h4>
                                        <p>{!! nl2br(e($auction->more_information)) !!} </p>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="info">
                            <div id="auction_more">
                                <div class="col">
                                    <h4>Відомості про майно, його склад, характеристики, опис </h4>
                                    <p>{!! nl2br(e($auction->more_about)) !!} </p>
                                </div></div>
                        </div>
                        @endif




                            <div class="tab-pane" id="bidders">
                                <div id="auction_more">
                                    <div class="col">

                                        @if($Bidders->bidders->count() > 0)
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th>Номер учасника</th>
                                                    <th>Дата подачі заявки</th>
                                                    <th>Статус</th>
                                                </tr>
                                                </thead>
                                                <tbody>

                                            @foreach($Bidders->bidders as $bidder)
                                                    <tr>
                                                        <td>Учасник {{ $bidder->user_id }}</td>
                                                        <td>{{ $bidder->created_at }}</td>
                                                        <td>{{ trans('theme.bidder_status.'.$bidder->status) }}</td>
                                                    </tr>
                                            @endforeach

                                                </tbody>
                                            </table>

                                            <a href="{{ action('AuctionsController@getProtocol', ['id' => $auction->id]) }}" class="btn btn-warning">Отримати протокол</a>
                                        @else
                                            Заявок немає
                                        @endif
                                    </div></div>
                            </div>

                            <div class="tab-pane" id="priceoffers">
                                <div id="auction_more">
                                    <div class="col">
                                        @if($auction->status == 2)Аукціон ще не почався @else

                                @if($Bets->count() > 0)

                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>ID учасника</th>
                                            <th>Дата ставки</th>
                                            <th>Цена</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($Bets as $bet)
                                            <tr>
                                                <td><span style="color: #ec971f;">{{ $bet->user_id }}</span></td>
                                                <td>{{ $bet->created_at }}</td>
                                                <td>{{ number_format($bet->bet, 2, ',', ' ') }} грн. </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>

                                    @else

                                                Пропозицій ще не надходило

                                    @endif

                                        @endif
                                    </div>
                                </div>
                            </div>

                </div>

            </div><!--/tabs-->


        </div>

    </div>
@endsection