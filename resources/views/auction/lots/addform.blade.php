

<form id="AddLot" method="post" enctype="multipart/form-data" action>

    <input type="hidden" name="_token" value="{{ csrf_token()}}"/>

        @foreach($errors->all(':message') as $message)
            <div class="alert alert-danger">{{ $message }}</div>
        @endforeach

    <div class="row">
        <div class="col-xs-12 col-md-6">

            <div class="form-group @if($errors->has('lot_title'))has-error @endif">
                <label for="lot_title">Назва лоту <span class="label-required">*</span></label>
                <input type="text" name="lot_title" class="form-control input-lg" id="lot_title" placeholder="" value="{{{ old('lot_title') }}}">
            </div>

        </div>
        <div class="col-xs-12 col-md-6">

            <div class="form-group @if($errors->has('lot_category'))has-error @endif">
                <label for="lot_category">Категорія лоту <span class="label-required">*</span></label>
                <select id="SelectCategory" class="form-control input-lg" name="lot_category">
                    <option value>Не обрано</option>
                    <? $cats = \App\Cat::roots()->get(); ?>
                    @foreach($cats as $category)
                        <option @if(old('lot_category') == $category->id)selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

        </div>
    </div>

    <div class="row load_children" style="display: none">
        <div class="col-xs-12">
            <div class="form-group @if($errors->has('lot_type'))has-error @endif">
                <div id="loadChildren"></div>
            </div>
        </div>
    </div>

    <!-- Нерухомість -->
    <div id="Category-1" class="category_group" style="margin: 40px 0 30px 0;display: none">

        <div class="row">
            <div class="col-xs-6">

                <div class="form-group @if($errors->has('property_material'))has-error @endif">
                    <label for="property_material">Матеріал будівлі</label>
                    <select class="form-control input-lg" name="property_material">
                        <option value>Не обрано</option>
                        @foreach(trans('theme.property_material') as $val => $property_material)
                            <option value="{{ $val }}" @if(old('property_material') == $val)selected @endif>{{ $property_material }}</option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="col-xs-6">

                <div class="form-group @if($errors->has('property_purpose'))has-error @endif">
                    <label>Цільове призначення</label>
                    <select class="form-control input-lg" name="property_purpose">
                        <option value>Не обрано</option>
                        @foreach(trans('theme.property_purpose') as $val => $property_purpose)
                            <option value="{{ $val }}" @if(old('property_purpose') == $val)selected @endif>{{ $property_purpose }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('property_floors'))has-error @endif">
                    <label for="property_floors">Поверховість</label>
                    <input type="text" name="property_floors" class="form-control input-lg" id="property_floors" value="{{{ old('property_floors')}}}">
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('property_areas'))has-error @endif">
                    <label for="property_areas">Кiмнат/примiщень</label>
                    <input type="text" name="property_areas" class="form-control input-lg" id="property_areas" value="{{{ old('property_areas') }}}">
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('property_totalarea'))has-error @endif">
                    <label for="property_totalarea">Загальна площа, кв.м <span class="label-required">*</span></label>
                    <input type="text" name="property_totalarea" class="form-control input-lg" id="property_totalarea" value="{{{ old('property_totalarea') }}}">
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('property_livingarea'))has-error @endif">
                    <label for="property_livingarea">Житлова площа, кв.м <span class="label-required">*</span></label>
                    <input type="text" name="property_livingarea" class="form-control input-lg" id="property_livingarea" value="{{{ old('property_livingarea') }}}">
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('plot_size'))has-error @endif">
                    <label id="label_plot_size" for="plot_size">Розмір земельної ділянки <span style="display: none" class="label-required">*</span></label>
                    <input type="text" name="plot_size" class="form-control input-lg" id="plot_size" value="{{{ old('plot_size') }}}">
                </div>
            </div>

        </div>

    </div>

    <!-- Автомобілі -->
    <div id="Category-4" class="category_group" style="margin: 40px 0 30px 0;display: none">
        <div class="row">
            <div class="col-xs-6 col-md-3">
                <div class="form-group @if($errors->has('auto_mark'))has-error @endif">
                    <label for="auto_mark">Марка <span class="label-required">*</span></label>
                    <select class="form-control" name="auto_mark" id="auto_mark">
                        <option value>Не обрано</option>
                        @foreach(trans('theme.auto_mark') as $k => $auto_mark)
                            <option value="{{ $k }}" @if(old('auto_mark') == $k)selected @endif>{{ $auto_mark }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-md-3">
                <div class="form-group @if($errors->has('auto_model'))has-error @endif">
                    <label for="auto_model">Модель <span class="label-required">*</span></label>
                    <input type="text" name="auto_model" class="form-control" id="auto_model" value="{{{ old('auto_model') }}}">
                </div>
            </div>
            <div class="col-xs-6 col-md-3">
                <div class="form-group @if($errors->has('auto_year'))has-error @endif">
                    <label for="auto_year">Pік випуску <span class="label-required">*</span></label>
                    <select class="form-control" name="auto_year" id="auto_year">
                        <option value="">Не обрано</option>
                        @foreach(trans('theme.auto_year') as $auto_year)
                            <option value="{{ $auto_year }}" @if(old('auto_year') == $auto_year)selected @endif>{{ $auto_year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-md-3">

                <div class="form-group @if($errors->has('auto_potencia'))has-error @endif">
                    <label for="auto_potencia">Об'єм двигуна</label>
                    <input type="text" name="auto_potencia" class="form-control" value="{{{ old('auto_potencia') }}}">
                </div>

            </div>

        </div>
        <div class="row">
            <div class="col-xs-6 col-md-3">
                <div class="form-group @if($errors->has('auto_transmission'))has-error @endif">
                    <label for="auto_transmission">Коробка передач <span class="label-required">*</span></label>
                    <select class="form-control" name="auto_transmission" id="auto_transmission">
                        <option value="">Не обрано</option>
                        @foreach(trans('theme.auto_transmission') as $k => $auto_transmission)
                            <option value="{{ $k }}" @if(old('auto_transmission') == $k)selected @endif>{{ $auto_transmission }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-md-3">
                <div class="form-group @if($errors->has('auto_drive'))has-error @endif">
                    <label for="auto_drive">Тип привода <span class="label-required">*</span></label>
                    <select class="form-control" name="auto_drive" id="auto_drive">
                        <option value>Не обрано</option>
                        @foreach(trans('theme.auto_drive') as $k => $auto_drive)
                            <option value="{{ $k }}" @if(old('auto_drive') == $k)selected @endif>{{ $auto_drive }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-md-3">
                <div class="form-group @if($errors->has('auto_fuel'))has-error @endif">
                    <label for="auto_fuel">Тип пального <span class="label-required">*</span></label>
                    <select class="form-control" name="auto_fuel" id="auto_fuel">
                        <option value>Не обрано</option>
                        @foreach(trans('theme.auto_fuel') as $k => $auto_fuel)
                            <option value="{{ $k }}" @if(old('auto_drive') == $k)selected @endif>{{ $auto_fuel }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-6 col-md-3">
                <div class="form-group @if($errors->has('auto_doors'))has-error @endif">
                    <label for="auto_doors">Кількість дверей <span class="label-required">*</span></label>
                    <select class="form-control" name="auto_doors" id="auto_doors">
                        <option value>Не обрано</option>
                        <option value="2" @if(old('auto_drive') == 2)selected @endif>2</option>
                        <option value="3" @if(old('auto_drive') == 3)selected @endif>3</option>
                        <option value="4" @if(old('auto_drive') == 4)selected @endif>4</option>
                        <option value="5" @if(old('auto_drive') == 5)selected @endif>5</option>
                    </select>
                </div>
            </div>

            <div class="col-xs-4 col-md-3">

                <div class="form-group @if($errors->has('auto_mileage'))has-error @endif">
                    <label for="auto_mileage">Пробіг, тис. км.</label>
                    <input type="number" name="auto_mileage" class="form-control" value="{{{ old('auto_mileage') }}}">
                </div>

            </div>

            <div class="col-xs-4 col-md-3">

                <div class="form-group @if($errors->has('lot_debtorname'))has-error @endif">
                    <label>ПІБ боржника/Назва</label>
                    <input type="text" name="lot_debtorname" class="form-control" value="{{{ old('lot_debtorname') }}}">
                </div>

            </div>

            <div class="col-xs-4 col-md-3">

                <div class="form-group @if($errors->has('lot_edrpou'))has-error @endif">
                    <label>ЄДРПОУ</label>
                    <input type="number" name="lot_edrpou" class="form-control" value="{{{ old('lot_edrpou') }}}">
                </div>

            </div>
        </div>
    </div>

    <? $auction = null; ?>
    <!-- Будівельні матеріали -->
    <div id="Category-39" class="category_group" style="margin: 40px 0 30px 0;display: none">
        @include('dashboard.fields.build')
    </div>

    <!-- Виробниче обладнання -->
    <div id="Category-6" class="category_group" style="margin: 40px 0 30px 0;display: none">
        @include('dashboard.fields.equipment')
    </div>

    <!-- Техніка та меблі -->
    <div id="Category-30" class="category_group" style="margin: 40px 0 30px 0;display: none">
        @include('dashboard.fields.stuff')
    </div>

    <!-- Корпоративні права -->
    <div id="Category-37" class="category_group" style="margin: 40px 0 30px 0;display: none">
        @include('dashboard.fields.corporate')
    </div>

    <div class="row" style="margin-top: 30px;">
        <div id="upload_main" class="col-xs-12 col-md-3">
            <div class="form-group">
                <label for="lot_title">Основне зображення <span class="label-required">*</span></label>
                <div class="dropzone" id="main_image"></div>
            </div>
        </div>

        <div class="col-xs-12 col-md-9">
            <div class="form-group">
                <label for="lot_title">Додаткові зображення</label>
                <div class="dropzone" id="more_image"></div>
            </div>
        </div>

        @if($errors->has('lot_image'))
            <div class="col-xs-12">
                <div class="alert alert-danger">Потрібно завантажити хоча б основне зображення!</div>
            </div>
        @endif

    </div>

    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                <label for="more_information">Додаткові відомості</label>
                <textarea class="form-control" rows="4" name="more_information">{{{ old('more_information') }}}</textarea>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label for="about">Відомості про майно, його склад, характеристики, опис</label>
                <textarea class="form-control" rows="4" name="more_about">{{{ old('more_about') }}}</textarea>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-6 col-md-3">
            <div class="form-group @if($errors->has('region'))has-error @endif">
                <label for="region">Область <span class="label-required">*</span></label>
                <select class="form-control input-lg" name="region">
                    <option value>Не обрано</option>
                    @foreach(trans('theme.regions') as $key => $region)
                        <option value="{{ $key }}" @if($key == old('region')) selected @endif>{{ $region }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-6 col-md-3">
            <div class="form-group @if($errors->has('city'))has-error @endif">
                <label for="city">Місцезнаходження <span class="label-required">*</span></label>
                <input type="text" name="city" class="form-control input-lg" id="city" value="{{{ old('city') }}}">
            </div>
        </div>
        <div class="col-xs-6 col-md-3">
            <div class="form-group">
                <label>Тип майна</label>
                <select class="form-control input-lg" name="property_type">
                    <option value>Не обрано</option>
                    @foreach(trans('theme.property_type') as $val => $property_type)
                        <option value="{{ $val }}" @if($val == old('property_type')) selected @endif>{{ $property_type }}</option>
                    @endforeach
                </select>

            </div>
        </div>
        <div class="col-xs-6 col-md-3">
            <div class="form-group @if($errors->has('data_start'))has-error @endif">
                <label for="data_start">Дата початку аукціону <span class="label-required">*</span></label>
                <input type="text" name="data_start" class="form-control input-lg" id="data_start" placeholder="" value="{{{ old('data_start') }}}">
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-6 col-md-3">
            <label for="guarantee_fee">Гарантійний внесок <span class="label-required">*</span></label>
            <div class="form-group @if($errors->has('guarantee_fee'))has-error @endif">
                <input type="text" name="guarantee_fee" class="form-control input-lg" id="guarantee_fee" placeholder="" value="{{{ old('guarantee_fee') }}}">
            </div>
        </div>
        <div class="col-xs-6 col-md-2">
            <div class="form-group">
                <label for="starting_price" id="starting_price_lable">Стартова ціна <span class="label-required">*</span></label>
                <div class="form-group @if($errors->has('starting_price'))has-error @endif">
                    <input type="text" name="starting_price" class="form-control input-lg" id="starting_price" placeholder="" value="{{{ old('starting_price') }}}" @if(old('negotiable_price')) disabled @endif>
                </div>
            </div>
        </div>
        <div class="col-xs-4 col-md-2">
            <div class="form-group">
                <label for="bid_price">Крок аукціону <span class="label-required">*</span></label>
                <div class="form-group @if($errors->has('bid_price'))has-error @endif">
                    <input type="text" name="bid_price" class="form-control input-lg" id="bid_price" placeholder="" value="{{{ old('bid_price') }}}">
                </div>
            </div>
        </div>
        <div class="col-xs-2 col-md-2">
            <div class="form-group">
                <label>Валюта</label>
                <select class="form-control input-lg" name="currency">
                    <option value="UAH" @if(old('currency') == 'UAH') selected @endif>ГРН</option>
                    <option value="USD" @if(old('currency') == 'USD') selected @endif>USD</option>
                    <option value="EUR" @if(old('currency') == 'EUR') selected @endif>EUR</option>
                </select>
            </div>
        </div>
        <div class="col-xs-6 col-md-3">
            <div class="form-group @if($errors->has('date_end'))has-error @endif">
                <label for="date_end">Дата завершення аукціону <span class="label-required">*</span></label>
                <input type="text" name="date_end" class="form-control input-lg" id="date_end" placeholder="" value="{{{ old('date_end') }}}">
            </div>
        </div>

    </div>

        <div class="row" style="margin-bottom: 30px">
            <div class="col-xs-12 col-md-5" style="margin-top: 10px">
                <div class="row">
                    <div class="col-xs-3">
                        <label>Вкладення</label>
                    </div>
                    <div class="col-xs-9">
                        <input type="file" name="documents[]" multiple>
                    </div>
                </div>

            </div>

            <div class="col-xs-12 col-md-3">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="free_sale" id="free_sale" value="1" @if(old('free_sale') == 1) checked @endif>
                        Вільний продаж
                    </label>
                </div>
            </div>

            <div class="col-xs-12 col-md-2 possible-bargain" style="display: none">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="possible_bargain" id="possible_bargain" value="1" @if(old('possible_bargain')) checked @endif>
                        Можливий торг
                    </label>
                </div>
            </div>

            <div class="col-xs-12 col-md-2 negotiable-price" style="display: none">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="negotiable_price" id="negotiable_price" id="negotiable_price" value="1" @if(old('negotiable_price')) checked @endif>
                        Ціна договірна
                    </label>
                </div>
            </div>
            
        </div>

    <button type="submit" class="btn btn-primary btn-lg">Подати оголошення</button>

</form>
<script>var maxfiles = {{ $globalSiteSettings['max_more_files'] }};</script>
<script src="{{asset('//uace.com.ua/static/js/addform.js')}}"></script>
<script>
$(document).ready(function() {

    $('#possible_bargain').on('change', function() {
        if($(this).is(':checked')) {
            $('#negotiable_price').prop('checked', false); 
            $('#starting_price').prop('disabled', false);
        }
    });

    $('#negotiable_price').on('change', function() {
        if($(this).is(':checked')) {
            $('#possible_bargain').prop('checked', false); 
            $('#starting_price').prop('disabled', true);
        } else {
            $('#starting_price').prop('disabled', false);
        }
    });
    @if(old('free_sale') == 1)
    $('#data_start').prop('disabled', true);
    $('#bid_price').prop('disabled', true);
    $('#date_end').prop('disabled', true);
    $('#guarantee_fee').prop('disabled', true);
    $('#starting_price_lable').text('Вартість');
    $('.possible-bargain').show();
    $('.negotiable-price').show();
    @endif
    
  });
</script>