<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h4 class="modal-title" id="myModalLabel">Редагування категорії: {{ $category->name }}</h4>
</div>
<form id="CategoryEdit" enctype="multipart/form-data">
    <div class="modal-body">
        <div class="ajaxstatus"></div>

        {!! csrf_field() !!}

        <div class="form-group">
            <label>Назва</label>
            <input type="text" class="form-control" name="name" value="{{ $category->name }}">
        </div>

        <div class="form-group">
            <label>Зображення</label>
            <input type="file" name="image">
        </div>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Закрити</button>
        <button type="button" class="send_new_fields btn btn-primary" data-loading-text="Оновлюємо дані...">Зберегти зміни</button>
    </div>
</form>

<script>
    $('.send_new_fields').on('click', function(e){
        //var form = $('#CategoryEdit');
        var data = new FormData($('#CategoryEdit')[0]);

        var _button = $(this);
        _button.button('loading');
        $.ajax({
            url: '{{ action('CategoriesController@postEditCategory', ['id' => $category->id]) }}',             // указываем URL и
            type: 'POST',
            dataType: "json",                     // тип загружаемых данных
            data: data,
            cache: false,
            contentType: false,
            processData: false,
            success: function (data, textStatus) { // вешаем свой обработчик на функцию success
                console.log(data);
                $('.ajaxstatus').html('<div class="alert alert-success">' + data.responseText + '</div>');
                _button.button('reset');
            }
        });
    })
</script>
