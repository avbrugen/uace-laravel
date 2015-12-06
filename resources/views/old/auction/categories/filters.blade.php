<form action="/auction/search" id="search" method="get">

    <div class="form-group">
        <label>Категорія:</label>
        <select class="form-control" name="category">
            <option value>Всі</option>
            @foreach($categories as $category)
                <option @if($currentCategory && $category->id == $currentCategory->id)selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

@if($currentCategory && $currentCategory->getDescendants()->count() > 0)
    <div class="form-group">
        <label>Тип:</label>
        <select class="form-control" name="lot_type">
            <option value>Всі</option>
            @foreach($currentCategory->getDescendants() as $type)
                <option @if($request && $request->lot_type == $type->id)selected @endif value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
        </select>
    </div>
    @endif

    <div class="form-group">
        <label>Стан аукціону:</label>
        <select class="form-control" name="status">
            <option value>Не обрано</option>
            @foreach(trans('theme.statuses_front') as $key => $status)
                <option @if($request && $request->status == $key)selected @endif value="{{ $key }}">{{ $status }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Ціна лота, грн</label>
        <div class="row row-min">
            <div class="col-xs-6">
                <input type="number" @if($request && $request->price_from)value="{{ $request->price_from }}"@endif class="form-control no-spin-button" name="price_from" placeholder="Від">
            </div>
            <div class="col-xs-6">
                <input type="number" @if($request && $request->price_to)value="{{ $request->price_to }}"@endif class="form-control no-spin-button" name="price_to" placeholder="До">
            </div>
        </div>
    </div>

    <div class="form-group">
        <label>Дата проведення аукціону:</label>
        <div class="row row-min">
            <div class="col-xs-6">
                <input type="date" @if($request && $request->date_start)value="{{ $request->date_start }}"@endif class="form-control no-spin-button" name="date_start" placeholder="Від">
            </div>
            <div class="col-xs-6">
                <input type="date" @if($request && $request->date_end)value="{{ $request->date_end }}"@endif class="form-control no-spin-button" name="date_end" placeholder="До">
            </div>
        </div>
    </div>

@if($currentCategory && $currentCategory->id == 1)
    <hr>
        <div class="form-group">
            <label>Матеріал будівлі</label>
            <select class="form-control" name="property_material">
                <option value>Всі</option>
                @foreach(trans('theme.property_material') as $val => $property_material)
                    <option value="{{ $val }}" @if($request && $request->property_material == $val) selected @endif>{{ $property_material }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Кiлькiсть поверхiв</label>
            <div class="row row-min">
                <div class="col-xs-6">
                    <input type="number" @if($request && $request->property_floors_from)value="{{ $request->property_floors_from }}"@endif class="form-control no-spin-button"  name="property_floors_from" placeholder="Від">
                </div>
                <div class="col-xs-6">
                    <input type="number" @if($request && $request->property_floors_to)value="{{ $request->property_floors_to }}"@endif class="form-control no-spin-button" name="property_floors_to" placeholder="До">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Кiмнат/примiщень</label>
            <div class="row row-min">
                <div class="col-xs-6">
                    <input type="number" @if($request && $request->property_areas_from)value="{{ $request->property_areas_from }}"@endif class="form-control no-spin-button"  name="property_areas_from" placeholder="Від">
                </div>
                <div class="col-xs-6">
                    <input type="number" @if($request && $request->property_areas_to)value="{{ $request->property_areas_to }}"@endif class="form-control no-spin-button" name="property_areas_to" placeholder="До">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Загальна площа</label>
            <div class="row row-min">
                <div class="col-xs-6">
                    <input type="number" @if($request && $request->property_totalarea_from)value="{{ $request->property_totalarea_from }}"@endif class="form-control no-spin-button"  name="property_totalarea_from" placeholder="Від">
                </div>
                <div class="col-xs-6">
                    <input type="number" @if($request && $request->property_totalarea_to)value="{{ $request->property_totalarea_to }}"@endif class="form-control no-spin-button" name="property_totalarea_to" placeholder="До">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Житлова площа</label>
            <div class="row row-min">
                <div class="col-xs-6">
                    <input type="number" @if($request && $request->property_livingarea_from)value="{{ $request->property_livingarea_from }}"@endif class="form-control no-spin-button"  name="property_livingarea_from" placeholder="Від">
                </div>
                <div class="col-xs-6">
                    <input type="number" @if($request && $request->property_livingarea_to)value="{{ $request->property_livingarea_to }}"@endif class="form-control no-spin-button" name="property_livingarea_to" placeholder="До">
                </div>
            </div>
        </div>

    <hr>
@endif

@if($currentCategory && $currentCategory->id == 4)
        <hr>
        <div class="form-group">
            <label for="auto_mark">Марка</label>
            <select class="form-control" name="auto_mark">
                <option value>Не обрано</option>
                @foreach(trans('theme.auto_mark') as $k => $auto_mark)
                    <option value="{{ $k }}" @if($request && $request->auto_mark == $k) selected @endif>{{ $auto_mark }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Модель</label>
            <input type="text" name="auto_model" @if($request && $request->auto_model)value="{{ $request->auto_model }}"@endif class="form-control">
        </div>

        <div class="form-group">
            <label>Pік випуску</label>
            <div class="row row-min">
                <div class="col-xs-6">
                    <input type="number" @if($request && $request->auto_year_from)value="{{ $request->auto_year_from }}"@endif class="form-control no-spin-button"  name="auto_year_from" placeholder="З">
                </div>
                <div class="col-xs-6">
                    <input type="number" @if($request && $request->auto_year_to)value="{{ $request->auto_year_to }}"@endif class="form-control no-spin-button" name="auto_year_to" placeholder="По">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Коробка передач</label>
            <select class="form-control" name="auto_transmission">
                <option value="">Не обрано</option>
                @foreach(trans('theme.auto_transmission') as $k => $auto_transmission)
                    <option value="{{ $k }}" @if($request && $request->auto_transmission == $k) selected @endif>{{ $auto_transmission }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Тип привода</label>
            <select class="form-control" name="auto_drive">
                <option value>Не обрано</option>
                @foreach(trans('theme.auto_drive') as $k => $auto_drive)
                    <option value="{{ $k }}" @if($request && $request->auto_drive == $k) selected @endif>{{ $auto_drive }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="auto_fuel">Тип пального</label>
            <select class="form-control" name="auto_fuel">
                <option value>Не обрано</option>
                @foreach(trans('theme.auto_fuel') as $k => $auto_fuel)
                    <option value="{{ $k }}" @if($request && $request->auto_fuel == $k) selected @endif>{{ $auto_fuel }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="auto_doors">Кількість дверей</label>
            <select class="form-control" name="auto_doors">
                <option value>Не обрано</option>
                <option value="2" @if($request && $request->auto_doors == 2) selected @endif>2</option>
                <option value="3" @if($request && $request->auto_doors == 3) selected @endif>3</option>
                <option value="4" @if($request && $request->auto_doors == 4) selected @endif>4</option>
                <option value="5" @if($request && $request->auto_doors == 5) selected @endif>5</option>
            </select>
        </div>


        <hr>
@endif

    <div class="form-group">
        <label for="region">Область</label>
        <select class="form-control" name="region">
            <option value>Всі</option>
            @foreach(trans('theme.regions') as $key => $region)
                <option value="{{ $key }}" @if($request && $request->region == $key) selected @endif>{{ $region }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="city">Місто</label>
        <input type="text" name="city" @if($request && $request->city)value="{{ $request->city }}"@endif class="form-control">
    </div>

    <button type="submit" class="btn btn-warning btn-lg">Показати результати</button>

</form>

<style>
    hr {
        border-top: 1px solid #DBDAD5;
    }

    .no-spin-button {
        -moz-appearance: textfield;
    }
    .no-spin-button::-webkit-inner-spin-button {
        display: none;
    }
</style>