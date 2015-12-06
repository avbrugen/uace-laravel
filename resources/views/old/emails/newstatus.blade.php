<h2>Вітаємо, {{ $first_name }} {{ $last_name }}!</h2>
<p>Адміністрація змінила статус Вашої заявки на участь в аукціоні №{{ $auction_id }}.</p>
<p><b>Інформація про заявку</b></p>
<p>
    Назва лоту: <a href="{{ action('AuctionsController@getAuctionPage', ['id' => $auction_id]) }}">{{ $auction_title }}</a><br/>
    Дата початку аукціону: {{ $auction_start }}<br/>
    Статус заявки на участь: <b>{{ $new_status }}</b>
</p>