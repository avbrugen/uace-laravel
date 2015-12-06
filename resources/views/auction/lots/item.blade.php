@foreach($auctions as $auction)
<div class="auction_item item-{{ $auction->id }} clearfix">
    <div class="item_image col-sm-4 col-xs-5 col-md-4"><a href="{{action('AuctionsController@getAuctionPageBySlug', ['id' => $auction->id, 'slug' => $auction->slug])}}"><img src="{{ $auction->img_min }}" alt="{{ $auction->title }}" class="img-responsive"></a></div>
    <div class="col-sm-8 col-xs-7">
        <h2><a href="{{action('AuctionsController@getAuctionPageBySlug', ['id' => $auction->id, 'slug' => $auction->slug])}}">{{ $auction->title }}</a></h2>
        <div class="row auction_info">
            <div class="col-xs-12 col-sm-7">
                <p><i class="icon icon-1"></i>Регіон: <b>{{ trans('theme.regions.'.$auction->region) }}</b></p>
                <p><i class="icon icon-2"></i>Номер лоту: <b>{{ $auction->id }}</b></p>
                @if(!$auction->free_sale)<p><i class="icon icon-3"></i>Гарантійний внесок: <b>{{ $auction->guarantee_fee }} {{ trans('theme.currency.'.$auction->currency) }}</b></p>@endif
                @if($auction->free_sale)<p><i class="icon icon-4"></i>Стан: <b>@if($auction->status == 3) Вільний продаж @else {{ trans('theme.statuses_free.'.$auction->status) }} @endif</b></p>@else
                <p><i class="icon icon-4"></i>Стан аукціону: <b>{{ trans('theme.statuses.'.$auction->status) }}</b></p>@endif
            </div>
            <div class="col-xs-12 col-sm-5">
                @if($auction->free_sale)<p class="b"><i class="icon icon-5"></i>Ціна продажу: 
                    <p class="price"><span>@if($auction->negotiable_price)договірна@else{{ number_format($auction->starting_price, 2, ',', ' ') }} {{ trans('theme.currency.'.$auction->currency) }} @endif</span></p>
                </p>
                <p>@if($auction->possible_bargain) Можливий торг @endif</p>
                @else

                <p class="b"><i class="icon icon-5"></i>Стартова ціна: <p class="price"><span>{{ number_format($auction->starting_price, 2, ',', ' ') }} {{ trans('theme.currency.'.$auction->currency) }}</span></p></p>@endif
                @if(!$auction->free_sale)<p class="date_start"><span><i class="icon icon-6"></i>Дата аукціону:</span><b>{{ Carbon\Carbon::parse($auction->data_start)->format('d.m.Y в H:i') }}</b></p>@endif
            </div>
        </div>
        <div class="buttons" @if($auction->free_sale)style="margin-top: 10px"@endif>
                    <a href="{{action('AuctionsController@getAuctionPageBySlug', ['id' => $auction->id, 'slug' => $auction->slug])}}" class="btn btn-primary">Переглянути лот</a>
                    @if(!$auction->free_sale)
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
                    @endif
                </div>
    </div>
</div>
@endforeach