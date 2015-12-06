@extends('auction.layout')
@section('title')Система електронних торгів - @lang('theme.sitename_title')@endsection

@section('content')

    @include('auction.categories.list')

    <div class="container">

        <div class="search_note">Для більш швидкого вибору скористайтеся пошуком</div>

        <div class="auction_main row">
            <div class="hidden-sm hidden-xs col-md-3">
                @include('auction.categories.filters')
                @include('auction.widget-lastlots')
            </div>
            <div class="col-xs-12 col-md-9">


<div id="auctions">
    <div class="row">

<ul>
    <li><a href="/">Головна</a></li>
    @foreach($pages as $page)
    <li><a href="{{action('PageController@getPage', ['slug' => $page->slug])}}">{{ $page->title }}</a></li>
    @endforeach
</ul>

<ul>
    <li><a href="#" class="open_sp" data-target="#sp_news">Новини</a>
        <ul id="sp_news" class="hidden">
           @foreach($news as $post)
            <li><a href="{{action('NewsController@getArticle', ['slug' => $post->slug])}}">{{ $post->title }}</a></li>
            @endforeach
        </ul>
    </li>
</ul>
   
<ul>
    <li><a href="#" class="open_sp" data-target="#sp_ogoloshenia">Оголошення</a>
        <ul id="sp_ogoloshenia" class="hidden">
           @foreach($ogoloshenia as $post)
            <li><a href="{{action('NewsController@getArticle', ['slug' => $post->slug])}}">{{ $post->title }}</a></li>
            @endforeach
        </ul>
    </li>
</ul>


<ul>
    <li><a href="/auctions">Система електронних торгів</a>
        <ul>
           @foreach($categories as $category)
            <li><a href="{{ action('CategoriesController@index', ['id' => $category->id]) }}">{{ $category->name }}</a>
                <ul>
                    <? $auctions = App\Auction::where('category', '=', $category->id)->where('status', '>', 0)->get(); ?>
                    @foreach($auctions as $auction)
                        <li><a href="{{action('AuctionsController@getAuctionPageBySlug', ['id' => $auction->id, 'slug' => $auction->slug])}}">{{ $auction->title }}</a></li>
                    @endforeach
                </ul>
            </li>
            @endforeach
        </ul>
    </li>
</ul>

    </div>
</div>

            </div>
        </div>

    </div>
    
<script>
$('.open_sp').on('click', function() {
    sp = $(this).data('target');
    if($(sp).hasClass('hidden')) {
        $(sp).removeClass('hidden');
    } else {
        $(sp).addClass('hidden');
    }
    return false;
});
</script>

@endsection