<h2>Розпочато аукціон №{{ $auction_id }}</h2>

<p>{{ $first_name }} {{ $last_name }}, ви є учасником аукціону <a href="{{ action('AuctionsController@getAuctionPage', ['id' => $auction_id]) }}" target="_blank">{{ $auction_title }}</a>, який щойно розпочався. Тепер ви можете робити ставки і стежити за ставками інших учасників.</p>

<p>З повагою, система електронних торгів UACE.</p>