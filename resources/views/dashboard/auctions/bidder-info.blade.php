<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Заявка на участь №{{ $bidder->id }}</h4>
</div>
<form id="BidderEdit" action="/dashboard/auctions/{{ $auction_id }}/bidders/{{ $bidder->id }}/edit">
<div class="modal-body">

    <div class="ajaxstatus"></div>

    {!! csrf_field() !!}

    <div class="form-group">
        <label>Прізвище</label>
        <input type="text" class="form-control" name="last_name" value="{{ $bidder->last_name }}">
    </div>

    <div class="form-group">
        <label>Ім'я</label>
        <input type="text" class="form-control" name="first_name" value="{{ $bidder->first_name }}">
    </div>

    <div class="form-group">
        <label>По батькові</label>
        <input type="text" class="form-control" name="middle_name" value="{{ $bidder->middle_name }}">
    </div>

    <div class="form-group">
        <label>Номер телефону</label>
        <input type="text" class="form-control" name="phone" value="{{ $bidder->phone }}">
    </div>

    @if($bidder->dop_phone)<div class="form-group">
        <label>Додаткові номери</label>
        <input type="text" class="form-control" name="dop_phone" value="{{ $bidder->dop_phone }}">
    </div>@endif

    <div class="form-group">
        <label>Статус</label>
        <select name="bidder_status" class="form-control">
            @foreach(trans('theme.bidder_status') as $key => $val)
                <option value="{{ $key }}" @if($key == $bidder->status)selected @endif>{{ $val }}</option>
            @endforeach
        </select>
        <p class="help-block">Учасник отримає повідомлення про зміну статусу</p>
    </div>

    <div class="form-group">
        <label>Прикрепленные файлы:</label>
        @if($bidder->file1)<p><a href="{{ $bidder->file1 }}" target="_blank"><i class="glyphicon glyphicon-file" style="margin-right: 5px"></i>Квитанція про сплату гарантійного внеску</a></p>@endif
        @if($bidder->file2)<p><a href="{{ $bidder->file2 }}" target="_blank"><i class="glyphicon glyphicon-file" style="margin-right: 5px"></i>Скан паспорту</a></p>@endif
        @if($bidder->file3)<p><a href="{{ $bidder->file3 }}" target="_blank"><i class="glyphicon glyphicon-file" style="margin-right: 5px"></i>Копія виписки з ЄДР (для ФОП)</a></p>@endif
        @if($bidder->file4)<p><a href="{{ $bidder->file4 }}" target="_blank"><i class="glyphicon glyphicon-file" style="margin-right: 5px"></i>Копія індивідуального податкового номеру</a></p>@endif
    </div>

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="location.reload();">Закрити</button>
    <button type="button" class="send_new_fields btn btn-primary" data-loading-text="Оновлюємо дані...">Зберегти зміни</button>
</div>
</form>

<script>
    $('.send_new_fields').on('click', function(e){
        var form = $('#BidderEdit').serialize();
        var _button = $(this);
        _button.button('loading');
        $.ajax({
            url: '/dashboard/auctions/{{ $auction_id }}/bidders/{{ $bidder->id }}/edit',             // указываем URL и
            method: 'POST',
            dataType: "json",                     // тип загружаемых данных
            data: form,
            success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                console.log(data);
                $('.ajaxstatus').html('<div class="alert alert-success">' + data.responseText + '</div>');
                _button.button('reset');
            }
        });
    })
</script>
