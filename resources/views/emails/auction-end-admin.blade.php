<h2>Аукціон №{{ $auction_id }} завершено</h2>

<p>Аукціон «<a href="{{ action('AuctionsController@getAuctionPage', ['id' => $auction_id]) }}">{{ $auction_title }}</a>» завершено.</p>
@if($auction_status == 7)
    <h4>Переможець аукціону</h4>
    <p>И.Ф.О.: {{ $win_last_name }} {{ $win_first_name }} {{ $win_middle_name }}<br>
        Email: {{ $win_email }}<br>
        Телефон: {{ $win_phone }}<br>
        Сума: {{ number_format($win_cost, 2, ',', ' ') }} {{ trans('theme.currency.'.$auction_cyr) }}
    </p>
@endif

@if($auction_status == 8)
    <p>На жаль, не було зафіксовано жодної ставки. Аукціон завершується зі статусом «{{ trans('theme.statuses.8') }}».</p>
@endif