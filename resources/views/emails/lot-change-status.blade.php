<h2>Вітаємо, {{ $first_name }} {{ $last_name }}!</h2>
<p>Адміністрація змінила статус вашого лота «<a href="{{ action('AuctionsController@getAuctionPage', ['id' => $lot_id]) }}">{{ $lot_title }}</a>» на: <b>{{ $status }}</b>.
<p>З повагою, система електронних торгів <a href="http://uace.com.ua/auctions">UACE</a>.</p>
