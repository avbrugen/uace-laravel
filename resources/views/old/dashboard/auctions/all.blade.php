@extends('dashboard.layout')
@section('content')

    <div class="container-fluid">
        <h2 class="sub-header">Аукционы</h2>

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th width="300">Заголовок</th>
                <th>Категория</th>
                <th>Местонахождение</th>
                <th>Статус</th>
                <th>Стартовая цена</th>
                <th>Пользователь</th>
                <th>Дата аукциона</th>
                <th>Дата добавления</th>
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
                    <td>{{ trans('theme.regions.'. $auction->region) }}@if($auction->city) м. {{ $auction->city }} @endif</td>
                    <td><span @if($auction->status == 0)style="color: red" @endif>{{ trans('theme.statuses.'. $auction->status) }}</span></td>
                    <td>{{ number_format($auction->starting_price, 2, ',', ' ') }} грн. </td>
                    <td><a href="/dashboard/users/search?s={{ $auction->curuser[0]->email }}">{{ $auction->curuser[0]->first_name }} {{ $auction->curuser[0]->last_name }}</a></td>
                    <td>{{ Carbon\Carbon::parse($auction->data_start)->format('d.m.Y') }}</td>
                    <td>{{ Carbon\Carbon::parse($auction->created_at)->format('d.m.Y H:i') }}</td>
                    <td><a href="{{ action('DashboardController@getEditLot', ['id' => $auction->id]) }}">Редактировать</a><br><a href="{{ action('DashboardController@getAuctionBidders', ['id' => $auction->id]) }}">Заявки ({{ $auction->bidders->count() }})</a></td>

                </tr>
            @endforeach

            </tbody>
        </table>

    </div>


@endsection