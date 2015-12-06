<h2>Сегодня начинается аукцион №{{ $auction_id }}</h2>
<p><b>Інформація</b></p>
<p>
    Название: {{ $auction_title }}<br/>
    Ссылка: {{ action('AuctionsController@getAuctionPage', ['id' => $auction_id]) }}</p>