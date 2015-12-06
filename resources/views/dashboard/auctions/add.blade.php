@extends('dashboard.layout')
@section('content')

    <div class="container-fluid">
        <h2 class="sub-header">Добавить лот</h2>

        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif

        <?php
        $regions = array(
                1 => "Винницкая область",
                "Волынская область",
                "Днепропетровская область",
                "Донецкая область",
                "Житомирская область",
                "Закарпатская область",
                "Запорожская область",
                "Ивано-Франковская область",
                "Киевская область",
                "Кировоградская область",
                "Крым",
                "Луганская область",
                "Львовская область",
                "Николаевская область",
                "Одесская область",
                "Полтавская область",
                "Ровенская область",
                "Сумская область",
                "Тернопольская область",
                "Харьковская область",
                "Херсонская область",
                "Хмельницкая область",
                "Черкасская область",
                "Черниговская область",
                "Черновицкая область"
        );

            $statuses = array(
                1 => "Архив",
                    "Регистрация участников",
                    "Происходят торги",
                    "Подписание протокола",
                    "Ожидание уплаты",
                    "Составление акта",
                    "Торги состоялись",
                    "Торги не состоялись",
                    "Торги остановлены",
                    "Торги прекращены"
            )
        ?>

        <form method="post" action style="margin-top: 20px">
            <div class="row">
                <div class="col-xs-6">
                    <div class="form-group">
                        <label for="title">Заголовок лота</label>
                        <input type="text" name="title" class="form-control input-lg" id="title" placeholder="Будівля центру сімейного дозвілля">
                    </div>
                    <div class="form-group">
                        <label for="region">Регион</label>
                        <select class="form-control input-lg" name="region">
                            @foreach($regions as $key => $region)
                                <option value="{{ $key }}">{{ $region }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="number">Номет лота</label>
                        <input type="text" name="number" class="form-control input-lg" id="number" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="status">Статус</label>
                        <select class="form-control input-lg" name="status">
                            @foreach($statuses as $key => $status)
                                <option value="{{ $key }}">{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="guarantee_fee">Гарантийный взнос</label>
                        <div class="input-group input-group-lg">
                            <input type="text" name="guarantee_fee" class="form-control" id="guarantee_fee" placeholder="">
                            <span class="input-group-addon">грн.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="starting_price">Стартовая цена</label>
                        <div class="input-group input-group-lg">
                            <input type="text" name="starting_price" class="form-control" id="starting_price" placeholder="">
                            <span class="input-group-addon">грн.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bid_price">Шаг аукциона</label>
                        <div class="input-group input-group-lg">
                            <input type="text" name="bid_price" class="form-control" id="bid_price" placeholder="">
                            <span class="input-group-addon">грн.</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="data_start">Дата аукциона</label>
                        <input type="date" name="data_start" class="form-control input-lg" id="data_start" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="img">Фотография лота</label>
                        <input type="file" name="img" id="img">
                    </div>
                </div>
            </div>
        </form>


    </div>


@endsection