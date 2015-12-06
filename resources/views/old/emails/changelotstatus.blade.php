<h2>Вітаємо, {{ $first_name }} {{ $last_name }}!</h2>
<p>Адміністрація перевірила Ваш лот «<a href="{{ action('AuctionsController@getAuctionPage', ['id' => $lot_id]) }}">{{ $lot_title }}</a>», і надала йому статус: <b>{{ trans('theme.statuses.'.$status_id) }}</b>. Тепер лот доступний для подачі заявки на участь у торгах.
