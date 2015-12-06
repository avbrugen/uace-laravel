<h2>Вітаємо, {{ $first_name }} {{ $last_name }}!</h2>

<p>Вы победили в аукционе «<a href="{{ action('AuctionsController@getAuctionPage', ['id' => $auction_id]) }}">{{ $auction_title }}</a>».<br/>
    Предложенная цена: {{ number_format($win_cost, 2, ',', ' ') }} грн.</p>
