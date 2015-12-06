@extends('dashboard.layout')
@section('content')

    <div class="container-fluid">

        <h2 class="sub-header">Аукціони</h2>

        @include('dashboard.auctions.search-form')

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th width="300">Заголовок</th>
                <th>Категорія</th>
                <th>Місцезнаходження</th>
                <th>Статус</th>
                <th>Ціна</th>
                <th>Користувач</th>
                <th>Дата аукціону</th>
                <th>Дата додавання</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            <? $cats = \App\Cat::all(); ?>

            @foreach($auctions as $auction)
                <tr>
                    <td>{{ $auction->id }}</td>
                    <td>{{ $auction->title }}</td>
                    <td>{{ $cats->find($auction->category)->name }}</td>
                    <td>{{ trans('theme.regions.'. $auction->region) }}@if($auction->city), {{ $auction->city }} @endif</td>
                    <td>
                        @if($auction->free_sale)
                            <span @if($auction->status == 0)style="color: red" @endif>{{ trans('theme.statuses_free.'. $auction->status) }}</span>
                        @else
                            <span @if($auction->status == 0)style="color: red" @endif>{{ trans('theme.statuses.'. $auction->status) }}</span>
                        @endif
                    </td>
                    <td>@if($auction->negotiable_price) Договірна @else {{ number_format($auction->starting_price, 2, ',', ' ') }} {{ trans('theme.currency.'.$auction->currency) }} @if($auction->possible_bargain)<br/>(можливий торг) @endif @endif</td>
                    <td><a href="/dashboard/users/search?s={{ $auction->curuser[0]->email }}">{{ $auction->curuser[0]->first_name }} {{ $auction->curuser[0]->last_name }}</a></td>
                    <td>@if($auction->free_sale) - @else{{ Carbon\Carbon::parse($auction->data_start)->format('d.m.Y') }}@endif</td>
                    <td>{{ Carbon\Carbon::parse($auction->created_at)->format('d.m.Y H:i') }}</td>
                    <td>
                        <a href="{{action('AuctionsController@getAuctionPageBySlug', ['id' => $auction->id, 'slug' => $auction->slug])}}">Переглянути</a><br>
                        <a href="{{ action('DashboardController@getEditLot', ['id' => $auction->id]) }}">Редагувати</a><br>
                        <a class="delete_lot" href="{{ action('DashboardController@getDeleteLot', ['id' => $auction->id]) }}">Видалити</a><br>
                        @if(!$auction->free_sale)<a href="{{ action('DashboardController@getAuctionBidders', ['id' => $auction->id]) }}">Заявки ({{ $auction->bidders->count() }})</a>@endif
                    </td>

                </tr>
            @endforeach

            </tbody>
        </table>

        <?php echo $auctions->appends($_GET)->render(); ?>

        <script>
            $('.delete_lot').on('click', function(){
                if (confirm("Ви підтверджуєте видалення лота? Його неможливо буде відновити.")) {
                    return true;
                } else {
                    return false;
                }
            });

        </script>

    </div>


@endsection