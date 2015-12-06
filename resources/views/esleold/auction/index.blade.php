@extends('auction.layout')
@section('title')Система електронних торгів - @lang('theme.sitename_title')@endsection

@section('content')

    @include('auction.categories.list')

    <div class="container">

        <div class="search_note">Для більш швидкого вибору скористайтеся пошуком</div>

        <div class="auction_main row">
            <div class="col-md-3">
                @include('auction.categories.filters')
                @include('auction.widget-lastlots')
            </div>
            <div class="col-md-9">
                <div class="row search_by_title row-min">
                    <div class="col-xs-6">
                        <div class="input">
                            <input type="text" class="form-control" @if($request && $request->title)value="{{ $request->title }}"@endif form="search" name="title" placeholder="Пошук за найменуванням">
                        </div>
                    </div>
                    <div class="col-xs-5">
                        <div class="input">
                            <select class="form-control" name="region" form="search">
                                <option value>Область</option>
                                @foreach(trans('theme.regions') as $key => $region)
                                    <option value="{{ $key }}" @if($request && $request->region == $key) selected @endif>{{ $region }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-1">
                        <button type="submit" form="search" class="btn btn-warning btn-lg"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>

                <ul class="nav nav-tabs nav-customized nav-justified">
                    <li class="@if($status_id == 2)active @endif" ><a href="/auctions"><i class="icon icon1"></i>Майбутні торги</a></li>
                    <li class="@if($status_id == 3)active @endif"><a href="/auctions/now"><i class="icon icon2"></i>Відбуваються торги</a></li>
                    <li class="@if($status_id == 1)active @endif"><a href="/auctions/archive"><i class="icon icon3"></i>Архів</a></li>
                </ul>
<div id="auctions">
    <div class="row">

        <form action class="form-horizontal clearfix sortBy">

            <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3">Відображати по:</label>
            <div class="col-md-8">
                <select class="form-control" name="items_per_page" onchange="this.form.submit()">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
            </div>
            </div>

            <div class="col-md-6">
            <div class="form-group">
                <label class="col-md-3 two">Сортувати:</label>
                <div class="col-md-9">
                    <select class="form-control" name="sortBy" onchange="this.form.submit()">
                        <option value="lowcost" @if($request && $request->sortBy == 'lowcost') selected @endif>Від найдешевших до найдорожчих</option>
                        <option value="topcost" @if($request && $request->sortBy != 'lowcost') selected @endif>Від найдорожчих до найдешевших</option>
                    </select>
                </div>
            </div>
            </div>
        </form>

        @if($auctions->count() > 0)
                @foreach($auctions as $auction)
                        <div class="auction_item clearfix">
                        <div class="col-md-4"><img src="{{ $auction->img_min }}" alt="{{ $auction->title }}" class="img-responsive"></div>
                        <div class="col-md-8">
                            <h2><a href="{{action('AuctionsController@getAuctionPage', ['id' => $auction->id])}}">{{ $auction->title }}</a></h2>
                            <div class="row auction_info">
                                <div class="col-xs-7">
                                    <p><i class="icon icon-1"></i>Регіон: <b>{{ trans('theme.regions.'.$auction->region) }}</b></p>
                                    <p><i class="icon icon-2"></i>Номер лоту: <b>{{ $auction->id }}</b></p>
                                    <p><i class="icon icon-3"></i>Гарантійний внесок: <b>{{ $auction->guarantee_fee }} грн.</b></p>
                                    <p><i class="icon icon-4"></i>Стан аукціону: <b>{{ trans('theme.statuses.'.$auction->status) }}</b></p>
                                    <div class="buttons" style="padding-top: 10px">
                                        <a href="{{action('AuctionsController@getAuctionPage', ['id' => $auction->id])}}" class="btn btn-primary">Переглянути лот</a>
                                        @if($auction->status == 2)<a href="{{ action('BiddersController@getAddBidder', ['id' => $auction->id]) }}" class="btn btn-warning">Подати заявку</a>@endif
                                        {{-- Проверка, имеет ли аукцион статус "Відбуваються торги" --}}
                                        @if($auction->status == 3)

                                            @if(!Auth::check())
                                                {{-- Если пользователь не авторизован, при нажатии открываем окно для входа --}}
                                                <a href="#" data-toggle="modal" data-target="#LoginModal" class="btn btn-warning">Зробити ставку</a>
                                            @else
                                                <?php
                                                // Запрос к списку участников (проверка, имеет ли текущий авторизованных пользователь статус Допущен до аукциона)
                                                // Вовзращает: 1 - если текущий пользователь успешно допущен (его заявка одобрена администрацией)
                                                // или 0 - если заявка не допущена или пользователь не подавал её вовсе
                                                $ee = \App\Bidders::where(['user_id' => Auth::user()->id, 'auction_id' => $auction->id, 'status' => 1])->get();
                                                ?>

                                                @if($ee->count() == 1)
                                                    <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#doBet">Зробити ставку</a>
                                                @endif

                                            @endif{{-- Auth::check --}}

                                        @endif{{-- $auction->status == 3 --}}
                                    </div>
                                </div>
                                <div class="col-xs-5">
                                    <p class="b"><i class="icon icon-5"></i>Стартова ціна:</p>
                                    <p class="price"><span>{{ number_format($auction->starting_price, 2, ',', ' ') }} грн. </span></p>
                                    <p class="date_start"><span><i class="icon icon-6"></i>Дата аукціону:</span><b>{{ Carbon\Carbon::parse($auction->data_start)->format('d.m.Y в H:i') }}</b></p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
<div class="clearfix">
    <?php echo $auctions->appends($_GET)->render(); ?>

        @if($request && $request->items_per_page  > $auctions->count() )
            Аукціони з {{ $auctions->currentPage() *  $auctions->perPage() - $auctions->perPage() + 1}} по {{ $auctions->currentPage() *  $auctions->perPage() }} із {{ $auctions->total()}} аукціонів
        @elseif($auctions->total() > 10)
            Аукціони з {{ $auctions->currentPage() *  $auctions->perPage() - $auctions->perPage() + 1}} по {{ $auctions->currentPage() *  $auctions->perPage() }} із {{ $auctions->total()}} аукціонів
        @else
            Аукціони з {{ $auctions->currentPage() *  $auctions->perPage() - $auctions->perPage() + 1}} по {{ $auctions->total()  }} із {{ $auctions->total()}} аукціонів
        @endif

</div>
        @else
            Пошук не дав результатів
        @endif
    </div>
</div>

            </div>
        </div>

    </div>

@endsection