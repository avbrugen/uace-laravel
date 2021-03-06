<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Протокол</title>
    <link rel="stylesheet" href="{{asset('static/css/bootstrap.css')}}" />
</head>
<body>


<div class="container">
<?
    $inBidders = null;
    $bidders = \App\Auction::with('bidders')->with('curuser')->find($auction_id);

    ?>

    @if(Auth::check())
        <? $inBidders = \App\Bidders::where(['user_id' => Auth::user()->id, 'auction_id' => $auction_id, 'status' => 1])->get(); ?>
        @endif


@if($inBidders && $inBidders->count() == 1)

        @if($bidders->bidders->count() > 0)
            <table class="table" style="margin-top: 60px">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>П. І. Б.</th>
                    <th>Дата подачі заявки</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>

                @foreach($bidders->bidders as $bidder)
                    <tr>
                        <? $user = \App\User::find($bidder->user_id); ?>
                        <td>{{ $bidder->user_id }}</td>
                        <td>{{ $user->last_name }} {{ $user->first_name }} {{ $user->middle_name }}</td>
                        <td>{{ $bidder->created_at }}</td>
                        <td>{{ trans('theme.bidder_status.'.$bidder->status) }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>

        @endif

    @else

        @if($bidders->bidders->count() > 0)
            <table class="table" style="margin-top: 60px">
                <thead>
                <tr>
                    <th>ID учасника</th>
                    <th>Дата подачі заявки</th>
                    <th>Статус</th>
                </tr>
                </thead>
                <tbody>

                @foreach($bidders->bidders as $bidder)
                    <tr>
                        <td>{{ $bidder->user_id }}</td>
                        <td>{{ $bidder->created_at }}</td>
                        <td>{{ trans('theme.bidder_status.'.$bidder->status) }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>

        @endif


    @endif


</div>

</body>
</html>


