<h2>Вітаємо, у систему UACE доданий новий лот!</h2>
<p>Перевірте, будь ласка, дані лота і укріпіть його <a href="{{ action('DashboardController@getEditLot', ['id' => $lot_id]) }}">в панелі управління</a>.</p>
<p><b>Інформація про лот</b></p>
<p>
    ID: {{ $lot_id }}<br/>
    Назва: {{ $lot_title }}<br/>
    Категорія: {{ $lot_category }}<br/>
    Місцезнаходження майна: {{ trans('theme.regions.'. $lot_region) }}, {{ $lot_city }}<br/>
    @if($negotiable_price)Ціна: договірна@elseЦіна: {{ $starting_price }}@endif</p>
<p><b>Інформація про користувача</b></p>
<p>Ім'я та прізвище: {{ $first_name }} {{ $last_name }}<br/>
E-mail: {{ $email }}<br/>
@if($phone)
        Номер телефону: {{ $phone }}
@endif
</p>