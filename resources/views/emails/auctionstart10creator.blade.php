<h2>Аукціон №{{ $auction_id }} розпочнеться через 10 хвилин!</h2>

<p>{{ $first_name }} {{ $last_name }}, ви є власником аукціону <a href="{{ action('AuctionsController@getAuctionPage', ['id' => $auction_id]) }}" target="_blank">{{ $auction_title }}</a>. Оповіщаємо, що торги почнуться через 10 хвилин.</p>

<p>З повагою, система електронних торгів UACE.</p>