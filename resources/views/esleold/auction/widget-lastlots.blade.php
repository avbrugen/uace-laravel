<div id="last_lots">
    <h3>Останні надходження</h3>
    <? $wg = \App\Auction::where('status', '>', 0)->orderBy('created_at', 'desc')->take(3)->get(); ?>

    @foreach($wg as $item)
    <div class="item clearfix">
        <a href="{{action('AuctionsController@getAuctionPage', ['id' => $item->id])}}">
        <div class="image"><img src="{{ $item->img_min }}" alt=""></div>
        <div class="info">
            <h2>{{ $item->title }}</h2>
            <div class="cost">Стартова ціна: <span>{{ number_format($item->starting_price, 2, ',', ' ') }} грн. </span></div>
        </div>
        </a>
    </div>
    @endforeach
</div>

<style>
    #last_lots {
        margin-top: 30px;
    }

    #last_lots .item {
        margin-top: 20px;
    }

    #last_lots .item .image {
        height: 150px;
        overflow: hidden;
    }

    #last_lots .item .image img {
        width: 100%;
    }

    #last_lots .item .cost {
        font-size: 15px;
    }

    #last_lots .item .cost span {
        color: #ffcc00;
        font-size: 17px;
        font-weight: 600;
    }

    #last_lots h3 {
        font-family: "Roboto Slab";
        font-size: 22px;
        border-bottom: 1px solid #ff9900;
        padding-bottom: 10px;
    }

    #last_lots .item .info {
        background-color: #515151;
        padding: 15px;
        font-family: "PT Sans";
        color: #fff;
    }

    #last_lots .item .info h2 {
        margin: 0;
        font-size: 18px;
        font-weight: bold;
    }
</style>