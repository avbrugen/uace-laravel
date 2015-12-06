<h2>Аукціон №{{ $auction_id }} завершено</h2>

<p>Аукцион «<a href="{{ action('AuctionsController@getAuctionPage', ['id' => $auction_id]) }}">{{ $auction_title }}</a>» завершен.</p>
@if($auction_status == 7)
    <h4>Победитель аукциона</h4>
    <p>И.Ф.О.: {{ $win_last_name }} {{ $win_first_name }} {{ $win_middle_name }}<br>
        Email: {{ $win_email }}<br>
        Телефон: {{ $win_phone }}<br>
        Сума: {{ number_format($win_cost, 2, ',', ' ') }} грн.
    </p>
@endif

@if($auction_status == 8)
    <p>К сожалению, не было зафиксировано ни одной ставки. Аукцион завершается со статусом «{{ trans('theme.statuses.8') }}».</p>
@endif