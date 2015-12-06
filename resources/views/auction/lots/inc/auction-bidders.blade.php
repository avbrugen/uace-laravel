<div id="load_bets">
@if($auction->status == 2)
    Аукціон ще не почався
@else
@if($Bets->count() > 0)
    <table class="table">
        <thead>
        <tr>
            <th>ID учасника</th>
            <th>Дата ставки</th>
            <th>Цена</th>
        </tr>
        </thead>
        <tbody>
        @foreach($Bets as $bet)
        <tr>
            <td>@if(Auth::check() && Auth::user()->id == $bet->user_id)
                    <span style="color: green;">@if(Auth::user()->legal_entity) {{ Auth::user()->legal_entity }} @else {{ Auth::user()->first_name }} {{ Auth::user()->last_name }} @endif</span>
                @else <span style="color: #ec971f;">Учасник №{{ $bet->user_id }}</span>@endif</td>
            <td>{{ $bet->created_at }}</td>
            <td>{{ number_format($bet->bet, 2, ',', ' ') }} {{ trans('theme.currency.'.$auction->currency) }} </td>
        </tr>
        @endforeach
        </tbody>
    </table>
@else
    Пропозицій ще не надходило
@endif

<script>
    function getBidders() {
        $.ajax({
            url: '/auction/helper/bets-{{ $auction->id }}',
            type: 'GET',
            data: 'currency={{ $auction->currency }}',
            dataType: "html",
            success: function(data){
                $('#load_bets').html(data);
            }
        });
    };
    setInterval(function(){getBidders();},10000);
</script>

@endif
</div>