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
                            <input type="text" class="form-control" form="search" name="title" placeholder="Пошук за найменуванням">
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

                <div id="auctions">

                            <h4 style="margin-bottom: 30px;margin-top: 0px;">Лоти продавця: @if($user->legal_entity){{ $user->legal_entity }}@else{{ $user->first_name }} {{ $user->last_name }}@endif</h4>

                    <div class="row">
                        @foreach($lots as $auction)
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
                                <?php echo $lots->appends($_GET)->render(); ?>

                                @if($request && $request->items_per_page  > $lots->count() )
                                    Аукціони з {{ $lots->currentPage() *  $lots->perPage() - $lots->perPage() + 1}} по {{ $lots->currentPage() *  $lots->perPage() }} із {{ $lots->total()}} аукціонів
                                @elseif($lots->total() > 10)
                                    Аукціони з {{ $lots->currentPage() *  $lots->perPage() - $lots->perPage() + 1}} по {{ $lots->currentPage() *  $lots->perPage() }} із {{ $lots->total()}} аукціонів
                                @else
                                    Аукціони з {{ $lots->currentPage() *  $lots->perPage() - $lots->perPage() + 1}} по {{ $lots->total()  }} із {{ $lots->total()}} аукціонів
                                @endif

                            </div>
                    </div>
                </div>

            </div>
        </div>

    </div>



@endsection