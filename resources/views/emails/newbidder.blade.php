<h2>Новая заявка на проверку!</h2>
<p>К лоту <a href="{{ action('AuctionsController@getAuctionPage', ['id' => $lot_id]) }}">№{{ $lot_id }}</a> добавлена <a href="{{ action('DashboardController@getAuctionBidders', ['id' => $lot_id]) }}">новая заявка</a> на участие. Пожалуйста, проверьте её.</p>
<p><b>Информация о участнике</b></p>
<p>
    ID: {{ $lot_id }}<br/>
    Назва: {{ $lot_title }}<br/>
    Категорія: {{ $lot_category }}<br/>
    Місцезнаходження майна: {{ trans('theme.regions.'. $lot_region) }}, м. {{ $lot_city }}<br/>
    Стартова ціна продажу: {{ $starting_price }}</p>
<p><b>Інформація про користувача</b></p>
<p>Ім'я та прізвище: {{ $first_name }} {{ $last_name }}<br/>
    E-mail: {{ $email }}<br/>
    @if($phone)
        Номер телефону: {{ $phone }}
    @endif
</p>