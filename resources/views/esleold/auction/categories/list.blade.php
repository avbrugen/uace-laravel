<div id="auction_categories" class="container">

    <div class="auction_choose_title">Придбавайте товари за ціною нижче ринкової. Виберіть аукціон</div>
    <div id="categories" class="row clearfix">
        <? $i = 0; ?>
        @foreach($categories as $category)
            <? $i++ ?>
            <div class="category_item @if($currentCategory && $category->id == $currentCategory->id)selected @endif">
                <a href="{{ action('CategoriesController@index', ['id' => $category->id]) }}">
                    <img src="{{ $category->image }}" alt="" class="img-responsive">
                    <h3>{{ $category->name }}</h3>
                </a>
            </div>

            @if($currentCategory && $i == 8 && $currentCategory->id == 1)
                <div class="current_category_filters col-md-12">
                    <form class="row search_small" action="{{ action('SearchController@getRealEstateQuery') }}">
                        <div class="col-md-3">

                            <input type="hidden" name="category" value="1">

                            <div class="form-group">
                                <select class="form-control" name="lot_type">
                                    <option value>Тип</option>
                                    @foreach($currentCategory->getDescendants() as $type)
                                        <option @if($request && $request->lot_type == $type->id)selected @endif value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="property_material">
                                    <option value>Матеріал</option>
                                    @foreach(trans('theme.property_material') as $val => $property_material)
                                        <option value="{{ $val }}" @if($request && $request->property_material == $val) selected @endif>{{ $property_material }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="property_purpose">
                                    <option value>Цільове призначення</option>
                                    @foreach(trans('theme.property_purpose') as $val => $property_purpose)
                                        <option value="{{ $val }}" @if($request && $request->property_purpose == $val) selected @endif>{{ $property_purpose }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <div class="col-md-3">

                            <div class="form-group">
                                <select class="form-control" name="region">
                                    <option value>Область</option>
                                    @foreach(trans('theme.regions') as $key => $region)
                                        <option value="{{ $key }}" @if($request && $request->region == $key) selected @endif>{{ $region }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="text" name="city" placeholder="Місто" @if($request && $request->city)value="{{ $request->city }}"@endif class="form-control">
                            </div>

                        </div>
                        <div class="col-md-3">

                            <h3>Пошук в:</h3>

                            @foreach(trans('theme.property_type') as $val => $property_type)
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="property_type[]" value="{{ $val }}" @if($request && $request->property_type && in_array($val, $request->property_type)) checked @endif>{{ $property_type }}
                                </label>
                            </div>
                            @endforeach

                        </div>

                        <div class="col-md-3 text-center">
                            <button type="submit" class="btn btn-warning btn-lg">Показати результати</button>
                            <a class="open_search_full" href="#" style="color: #000; text-decoration: underline;margin-top: 10px;display: block;">Розгорнутий пошук</a>
                        </div>
                    </form>
                    <form class="row search_full" action="{{ action('SearchController@getRealEstateQuery') }}" style="display: none">
                        <div class="col-md-3">

                            <input type="hidden" name="category" value="1">

                            <div class="form-group">
                                <select class="form-control" name="lot_type">
                                    <option value>Тип</option>
                                    @foreach($currentCategory->getDescendants() as $type)
                                        <option @if($request && $request->lot_type == $type->id)selected @endif value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="property_material">
                                    <option value>Матеріал</option>
                                    @foreach(trans('theme.property_material') as $val => $property_material)
                                        <option value="{{ $val }}" @if($request && $request->property_material == $val) selected @endif>{{ $property_material }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="property_purpose">
                                    <option value>Цільове призначення</option>
                                    @foreach(trans('theme.property_purpose') as $val => $property_purpose)
                                        <option value="{{ $val }}" @if($request && $request->property_purpose == $val) selected @endif>{{ $property_purpose }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="region">
                                    <option value>Область</option>
                                    @foreach(trans('theme.regions') as $key => $region)
                                        <option value="{{ $key }}" @if($request && $request->region == $key) selected @endif>{{ $region }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <input type="text" name="city" placeholder="Місто" @if($request && $request->city)value="{{ $request->city }}"@endif class="form-control">
                            </div>

                        </div>

                        <div class="col-md-3">

                            <h3>Пошук в:</h3>

                            <div class="form-group">
                            @foreach(trans('theme.property_type') as $val => $property_type)
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="property_type[]" value="{{ $val }}" @if($request && $request->property_type && in_array($val, $request->property_type)) checked @endif>{{ $property_type }}
                                    </label>
                                </div>
                            @endforeach
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

                        </div>

                        <div class="col-md-3">

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Кiлькiсть поверхiв</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="row row-min">
                                        <div class="col-xs-6">
                                            <input type="number" @if($request && $request->property_floors_from)value="{{ $request->property_floors_from }}"@endif class="form-control no-spin-button"  name="property_floors_from" placeholder="Від">
                                        </div>
                                        <div class="col-xs-6">
                                            <input type="number" @if($request && $request->property_floors_to)value="{{ $request->property_floors_to }}"@endif class="form-control no-spin-button" name="property_floors_to" placeholder="До">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Кiмнат/примiщень</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="row row-min">
                                        <div class="col-xs-6">
                                            <input type="number" @if($request && $request->property_areas_from)value="{{ $request->property_areas_from }}"@endif class="form-control no-spin-button"  name="property_areas_from" placeholder="Від">
                                        </div>
                                        <div class="col-xs-6">
                                            <input type="number" @if($request && $request->property_areas_to)value="{{ $request->property_areas_to }}"@endif class="form-control no-spin-button" name="property_areas_to" placeholder="До">
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Загальна площа</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="row row-min">
                                        <div class="col-xs-6">
                                            <input type="number" @if($request && $request->property_totalarea_from)value="{{ $request->property_totalarea_from }}"@endif class="form-control no-spin-button"  name="property_totalarea_from" placeholder="Від">
                                        </div>
                                        <div class="col-xs-6">
                                            <input type="number" @if($request && $request->property_totalarea_to)value="{{ $request->property_totalarea_to }}"@endif class="form-control no-spin-button" name="property_totalarea_to" placeholder="До">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label>Житлова площа</label>
                                </div>
                                <div class="col-md-8">
                                    <div class="row row-min">
                                        <div class="col-xs-6">
                                            <input type="number" @if($request && $request->property_livingarea_from)value="{{ $request->property_livingarea_from }}"@endif class="form-control no-spin-button"  name="property_livingarea_from" placeholder="Від">
                                        </div>
                                        <div class="col-xs-6">
                                            <input type="number" @if($request && $request->property_livingarea_to)value="{{ $request->property_livingarea_to }}"@endif class="form-control no-spin-button" name="property_livingarea_to" placeholder="До">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-3 text-center">

                            <div class="form-group">
                                <input type="text" name="lot_number" @if($request && $request->lot_number)value="{{ $request->lot_number }}"@endif placeholder="Номер лота" class="form-control">
                            </div>

                            <div class="form-group">
                                <input type="text" name="" placeholder="Номер заявки" class="form-control">
                            </div>

                            <div class="form-group">
                                <input type="text" name="lot_user_number" @if($request && $request->lot_user_number)value="{{ $request->lot_user_number }}"@endif placeholder="Код замовника" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-warning btn-lg">Показати результати</button>
                            <a class="open_search_small" href="#" style="color: #000; text-decoration: underline;margin-top: 10px;display: block;">Звичайний пошук</a>

                        </div>

                    </form>
                    <script>
                        $('.open_search_full').on('click', function()
                        {
                            $('.search_small').hide();
                            $('.search_full').show();
                            return false;
                        });

                        $('.open_search_small').on('click', function()
                        {
                            $('.search_small').show();
                            $('.search_full').hide();
                            return false;
                        });
                    </script>
                </div>
                @endif

            @if($currentCategory && $i == 8 && $currentCategory->id == 4)
                    <div class="current_category_filters col-md-12">
                        <form class="row search_small" action="{{ action('SearchController@getAutoQuery') }}">
                            <div class="col-md-3">

                                <input type="hidden" name="category" value="4">

                                <div class="form-group">
                                    <select class="form-control" name="lot_type">
                                        <option value>Тип авто</option>
                                        @foreach($currentCategory->getDescendants() as $type)
                                            <option @if($request && $request->lot_type == $type->id)selected @endif value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select class="form-control" name="auto_mark" id="auto_mark">
                                        <option value>Марка</option>
                                        @foreach(trans('theme.auto_mark') as $k => $auto_mark)
                                            <option value="{{ $k }}">{{ $auto_mark }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="auto_model" class="form-control" id="auto_model" placeholder="Модель">
                                </div>

                            </div>
                            <div class="col-md-3">

                                <div class="form-group">
                                    <select class="form-control" name="region">
                                        <option value>Область</option>
                                        @foreach(trans('theme.regions') as $key => $region)
                                            <option value="{{ $key }}" @if($request && $request->region == $key) selected @endif>{{ $region }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="city" placeholder="Місто" @if($request && $request->city)value="{{ $request->city }}"@endif class="form-control">
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Pік випуску</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row row-min">
                                            <div class="col-xs-6">
                                                <input type="number" @if($request && $request->auto_year_from)value="{{ $request->auto_year_from }}"@endif class="form-control no-spin-button"  name="auto_year_from" placeholder="З">
                                            </div>
                                            <div class="col-xs-6">
                                                <input type="number" @if($request && $request->auto_year_to)value="{{ $request->auto_year_to }}"@endif class="form-control no-spin-button" name="auto_year_to" placeholder="По">

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-3">

                                <h3>Пошук в:</h3>

                                @foreach(trans('theme.property_type') as $val => $property_type)
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="property_type[]" value="{{ $val }}" @if($request && $request->property_type && in_array($val, $request->property_type)) checked @endif>{{ $property_type }}
                                        </label>
                                    </div>
                                @endforeach

                            </div>

                            <div class="col-md-3 text-center">
                                <button type="submit" class="btn btn-warning btn-lg">Показати результати</button>
                                <a class="open_search_full" href="#" style="color: #000; text-decoration: underline;margin-top: 10px;display: block;">Розгорнутий пошук</a>
                            </div>
                        </form>
                        <form class="row search_full" action="{{ action('SearchController@getAutoQuery') }}" style="display: none">
                            <div class="col-md-3">

                                <input type="hidden" name="category" value="4">

                                <div class="form-group">
                                    <select class="form-control" name="lot_type">
                                        <option value>Тип авто</option>
                                        @foreach($currentCategory->getDescendants() as $type)
                                            <option @if($request && $request->lot_type == $type->id)selected @endif value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <select class="form-control" name="auto_mark" id="auto_mark">
                                        <option value>Марка</option>
                                        @foreach(trans('theme.auto_mark') as $k => $auto_mark)
                                            <option value="{{ $k }}">{{ $auto_mark }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="auto_model" class="form-control" id="auto_model" placeholder="Модель">
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Pік випуску</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row row-min">
                                            <div class="col-xs-6">
                                                <input type="number" @if($request && $request->auto_year_from)value="{{ $request->auto_year_from }}"@endif class="form-control no-spin-button"  name="auto_year_from" placeholder="З">
                                            </div>
                                            <div class="col-xs-6">
                                                <input type="number" @if($request && $request->auto_year_to)value="{{ $request->auto_year_to }}"@endif class="form-control no-spin-button" name="auto_year_to" placeholder="По">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <select class="form-control" name="region">
                                        <option value>Область</option>
                                        @foreach(trans('theme.regions') as $key => $region)
                                            <option value="{{ $key }}" @if($request && $request->region == $key) selected @endif>{{ $region }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input type="text" name="city" placeholder="Місто" @if($request && $request->city)value="{{ $request->city }}"@endif class="form-control">
                                </div>

                            </div>

                            <div class="col-md-3">

                                <h3>Пошук в:</h3>

                                <div class="form-group">
                                    @foreach(trans('theme.property_type') as $val => $property_type)
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="property_type[]" value="{{ $val }}" @if($request && $request->property_type && in_array($val, $request->property_type)) checked @endif>{{ $property_type }}
                                            </label>
                                        </div>
                                    @endforeach
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

                                <div class="form-group">
                                    <input type="text" name="lot_DebtorName" class="form-control" placeholder="ПІБ боржника/Назва">
                                </div>

                                <div class="form-group">
                                    <input type="text" name="lot_EDRPOU" class="form-control" placeholder="ЄДРПОУ">
                                </div>

                            </div>

                            <div class="col-md-3">

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Ціна лота, грн</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row row-min">
                                            <div class="col-xs-6">
                                                <input type="number" @if($request && $request->price_from)value="{{ $request->price_from }}"@endif class="form-control no-spin-button" name="price_from" placeholder="Від">
                                            </div>
                                            <div class="col-xs-6">
                                                <input type="number" @if($request && $request->price_to)value="{{ $request->price_to }}"@endif class="form-control no-spin-button" name="price_to" placeholder="До">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Об'єм двигуна</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row row-min">
                                            <div class="col-xs-6">
                                                <input type="number" @if($request && $request->price_from)value="{{ $request->price_from }}"@endif class="form-control no-spin-button" name="price_from" placeholder="Від">
                                            </div>
                                            <div class="col-xs-6">
                                                <input type="number" @if($request && $request->price_to)value="{{ $request->price_to }}"@endif class="form-control no-spin-button" name="price_to" placeholder="До">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label>Пробіг, тис. км.</label>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row row-min">
                                            <div class="col-xs-6">
                                                <input type="number" @if($request && $request->property_areas_from)value="{{ $request->property_areas_from }}"@endif class="form-control no-spin-button"  name="property_areas_from" placeholder="Від">
                                            </div>
                                            <div class="col-xs-6">
                                                <input type="number" @if($request && $request->property_areas_to)value="{{ $request->property_areas_to }}"@endif class="form-control no-spin-button" name="property_areas_to" placeholder="До">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <select class="form-control" name="auto_transmission" id="auto_transmission">
                                        <option value="">Коробка передач</option>
                                        @foreach(trans('theme.auto_transmission') as $k => $auto_transmission)
                                            <option value="{{ $k }}">{{ $auto_transmission }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div class="row row-min">
                                        <div class="col-xs-6">
                                            <select class="form-control" name="auto_drive" id="auto_drive">
                                                <option value>Тип привода</option>
                                                @foreach(trans('theme.auto_drive') as $k => $auto_drive)
                                                    <option value="{{ $k }}">{{ $auto_drive }}</option>
                                                @endforeach
                                            </select>                                        </div>
                                        <div class="col-xs-6">
                                            <select class="form-control" name="auto_fuel" id="auto_fuel">
                                                <option value>Тип пального</option>
                                                @foreach(trans('theme.auto_fuel') as $k => $auto_fuel)
                                                    <option value="{{ $k }}">{{ $auto_fuel }}</option>
                                                @endforeach
                                            </select>                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <select class="form-control" name="auto_doors">
                                        <option value>Кількість дверей</option>
                                        <option value="2" @if($request && $request->auto_doors == 2) selected @endif>2</option>
                                        <option value="3" @if($request && $request->auto_doors == 3) selected @endif>3</option>
                                        <option value="4" @if($request && $request->auto_doors == 4) selected @endif>4</option>
                                        <option value="5" @if($request && $request->auto_doors == 5) selected @endif>5</option>
                                    </select>
                                </div>

                            </div>

                            <div class="col-md-3 text-center">

                                <div class="form-group">
                                    <input type="text" name="lot_number" @if($request && $request->lot_number)value="{{ $request->lot_number }}"@endif placeholder="Номер лота" class="form-control">
                                </div>

                                <div class="form-group">
                                    <input type="text" name="" placeholder="Номер заявки" class="form-control">
                                </div>

                                <div class="form-group">
                                    <input type="text" name="lot_user_number" @if($request && $request->lot_user_number)value="{{ $request->lot_user_number }}"@endif placeholder="Код замовника" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-warning btn-lg">Показати результати</button>
                                <a class="open_search_small" href="#" style="color: #000; text-decoration: underline;margin-top: 10px;display: block;">Звичайний пошук</a>

                            </div>

                        </form>
                        <script>
                            $('.open_search_full').on('click', function()
                            {
                                $('.search_small').hide();
                                $('.search_full').show();
                                return false;
                            });

                            $('.open_search_small').on('click', function()
                            {
                                $('.search_small').show();
                                $('.search_full').hide();
                                return false;
                            });
                        </script>
                    </div>
                @endif

        @endforeach
    </div>

</div>

<style>
    .current_category_filters {
        border: 4px solid #FC0;
        margin: 0 8px 20px 8px;
        padding: 30px 20px 20px;
    }

    .current_category_filters label {
        font-size: 15px;
    }

    .current_category_filters .checkbox label {
        font-size: 14px;
    }

    .current_category_filters h3 {
        font-family: "Roboto Slab";
        margin-top: 0;
    }

    .current_category_filters .col-md-3, .current_category_filters .col-md-2 {
        padding-left: 25px;
        padding-right: 25px;
    }
</style>