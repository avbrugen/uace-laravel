<h2>Вітаємо, {{ $first_name }} {{ $last_name }}!</h2>

<p>Ви перемогли в аукціоні «<a href="{{ action('AuctionsController@getAuctionPage', ['id' => $auction_id]) }}">{{ $auction_title }}</a>».<br/>
    Запропонована ціна: {{ number_format($win_cost, 2, ',', ' ') }} {{ trans('theme.currency.'.$auction_cyr) }}</p>
