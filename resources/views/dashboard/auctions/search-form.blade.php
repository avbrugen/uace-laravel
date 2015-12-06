<form action="{{ action('DashboardController@getSearchAuctions') }}" method="get" class="row" style="margin-top: 25px">
    <div class="col-xs-2 form-group">
        <input type="text" name="title" class="form-control" value="@if(isset($request)){{ $request->title }}@endif" placeholder="Пошук за назвою та ID">
    </div>

    <div class="col-xs-2 form-group">
        <select class="form-control" name="category">
            <option value>Категорія</option>
            <? $categories = App\Cat::roots()->get(); ?>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @if(isset($request) && $request->category == $category->id) selected @endif>{{ $category->name }}</option>
            @endforeach
        </select>

    </div>

    <div class="col-xs-2 form-group">
        <select class="form-control" name="status">
            @if(isset($request) && $request->status == 'del')
                <option value="del" @if(isset($request) && $request->status == 'del') selected @endif>Статус</option>
                @foreach(trans('theme.statuses') as $key => $status)
                    <option value="{{ $key }}">{{ $status }}</option>
                @endforeach
            @else
                <option value="del">Статус</option>
                @foreach(trans('theme.statuses') as $key => $status)
                    <option value="{{ $key }}" @if(isset($request) && $request->status == $key) selected @endif>{{ $status }}</option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="col-xs-2 form-group">
        <input type="number" class="form-control no-spin-button" name="price_from" @if(isset($request)) value="{{ $request->price_from }}" @endif placeholder="Ціна від">
    </div>

    <div class="col-xs-2 form-group">
        <input type="number" class="form-control no-spin-button" name="price_to" @if(isset($request)) value="{{ $request->price_to }}" @endif placeholder="Ціна до">
    </div>

    <div class="col-xs-2 form-group">
        <select class="form-control" name="region">
            <option value>Область</option>
            @foreach(trans('theme.regions') as $key => $region)
                <option value="{{ $key }}" @if(isset($request) && $request->region == $key) selected @endif>{{ $region }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-xs-2 form-group">
        <input type="text" name="city" class="form-control" @if(isset($request)) value="{{ $request->city }}" @endif placeholder="Місцезнаходження">
    </div>

    <div class="col-xs-2 form-group">
        <select class="form-control" name="items_per_page">
            <option value>Відображати по</option>
            <option value="10" @if(isset($request) && $request->items_per_page == 10) selected @endif>10</option>
            <option value="25" @if(isset($request) && $request->items_per_page == 25) selected @endif>25</option>
            <option value="50" @if(isset($request) && $request->items_per_page == 50) selected @endif>50</option>
        </select>
    </div>

    <div class="col-xs-2 form-group">
        <select class="form-control" name="sortBy">
            <option value>Сортувати</option>
            <option value="lowcost" @if(isset($request) && $request->items_per_page == 'lowcost') selected @endif>Від найдешевших до найдорожчих</option>
            <option value="topcost" @if(isset($request) && $request->items_per_page == 'topcost') selected @endif>Від найдорожчих до найдешевших</option>
        </select>
    </div>

    <div class="col-xs-2 form-group">
        <div class="checkbox">
            <label>
                <input type="checkbox" @if(isset($request) && $request->free_sale == 1) checked @endif name="free_sale" id="free_sale" value="1">
                Вільний продаж
            </label>
        </div>
    </div>

    <div class="col-xs-2 form-group">
        <button type="submit" class="btn btn-warning">Показати результати</button>
    </div>

</form>