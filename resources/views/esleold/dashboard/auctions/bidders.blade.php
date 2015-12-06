@extends('dashboard.layout')
@section('content')

    <div class="container-fluid">
        <h2 class="sub-header">Участники лота №{{ $auction->id }}</h2>

        <table class="table">
            <thead>
            <tr>
                <th>ID пользователя</th>
                <th width="400">Ф.И.О.</th>
                <th>Номер телефона</th>
                <th>Тип оплаты</th>
                <th>Статус</th>
                <th>Дата подачи</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($auction->bidders as $bidder)

                <tr>
                    <td>{{ $bidder->user_id }}</td>
                    <td>{{ $bidder->first_name }} {{ $bidder->last_name }} {{ $bidder->middle_name }}</td>
                    <td>{{ $bidder->phone }}</td>
                    <td>{{ trans('theme.payment_type.'.$bidder->payment_type) }}</td>
                    <td><span @if($bidder->status == 0)style="color: red;"@elseif($bidder->status == 1)style="color: green;"@elseif($bidder->status == 2)style="color: #007fff;"@endif>{{ trans('theme.bidder_status.'.$bidder->status) }}</span></td>
                    <td>{{ $bidder->created_at }}</td>
                    <td><a class="open_bidder_info" href="#" data-toggle="modal" data-target="#myModal" data-bidder-id="{{ $bidder->id }}">Просмотреть</a></td>
                </tr>

            @endforeach


            </tbody>
        </table>


        <div id="data">

        </div>

    </div>

    <script>
        $('.open_bidder_info').on('click', function(){
            var _this = $(this);
            $.ajax({
                url: '/dashboard/auctions/{{ $auction->id }}/bidders/'+ _this.data('bidder-id') +'/edit',             // указываем URL и
                dataType : "html",                     // тип загружаемых данных
                success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                    $('#DataBidder').html(data);
                }
            });
        });
    </script>


    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content"  id="DataBidder">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Название модали</h4>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary">Сохранить изменения</button>
                </div>
            </div>
        </div>
    </div>


@endsection