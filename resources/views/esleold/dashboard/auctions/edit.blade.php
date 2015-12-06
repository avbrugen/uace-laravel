@extends('dashboard.layout')

@section('content')
    <script src="/static/js/dropzone.js"></script>
    <link rel="stylesheet" href="/static/css/dropzone.css">
    <script src="/static/js/moment-with-locales.min.js"></script>
    <script src="/static/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="/static/css/bootstrap-datetimepicker.min.css">

<script>
    @if($auction->category)$(document).ready(function(){
        $('#Category-{{ $auction->category }}').show();
    });
    @endif
</script>
<div class="container">

<form id="AddLot" method="post" action style="margin-top: 50px;">
    {!! csrf_field() !!}
    <div class="form-group @if($errors->has('lot_title'))has-error @endif">
        <label for="lot_title">Назва лоту</label>
        <input type="text" name="lot_title" class="form-control input-lg" id="lot_title" placeholder="" value="{{ $auction->title }}">
    </div>

    <div class="form-group @if($errors->has('lot_category'))has-error @endif">
        <label for="lot_category">Категорія лоту</label>
        <select id="SelectCategory" class="form-control input-lg" name="lot_category">
            <option value>Не обрано</option>
            <? $cats = \App\Cat::roots()->get(); ?>
            @foreach($cats as $category)
                <option @if($category->id == $auction->category)selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="load_children">
            <div class="form-group @if($errors->has('lot_type'))has-error @endif">
                <label for="lot_type">Тип</label>
                <div id="loadChildren">
                    <? $categories = \App\Cat::find($auction->category);
                    $categories = $categories->children()->get(); ?>
                    <select class="form-control input-lg" name="lot_type">
                        @foreach($categories as $category)
                            <option @if($category->id == $auction->lot_type)selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
    </div>

    <script>



        $('#SelectCategory').on('change', function(){

            var _this = $(this);
            if(_this.val())
            {
                $.ajax({
                    url: '/auction/helpers/childrens-'+ _this.val(),
                    dataType : "html",
                    success: function (data, textStatus) {
                        $('#loadChildren').html(data);
                    }
                });

                $('.category_group').hide();
                $('.load_children').show();
                $('#Category-' + $(this).val()).show();
            } else {
                $('.load_children').hide();
                $('.category_group').hide();
            }

        });
    </script>

    <!-- Нерухомість -->
    <div id="Category-1" class="category_group" style="margin: 40px 0 30px 0;display: none">

        <div class="row">
            <div class="col-xs-6">
                <div class="form-group @if($errors->has('property_material'))has-error @endif">
                    <label for="property_material">Матеріал будівлі</label>
                    <select class="form-control input-lg" name="property_material">
                        <option value>Не обрано</option>

                        @foreach(trans('theme.property_material') as $val => $property_material)
                            <option value="{{ $val }}" @if($val == $auction->property_material) selected @endif>{{ $property_material }}</option>
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
                            <option value="{{ $val }}" @if($val == $auction->property_purpose) selected @endif>{{ $property_purpose }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('property_floors'))has-error @endif">
                    <label for="property_floors">Кiлькiсть поверхiв</label>
                    <input type="text" name="property_floors" class="form-control input-lg" id="property_floors" value="{{ $auction->property_floors }}">
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('property_areas'))has-error @endif">
                    <label for="property_areas">Кiмнат/примiщень</label>
                    <input type="text" name="property_areas" class="form-control input-lg" id="property_areas" value="{{ $auction->property_areas }}">
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('property_totalarea'))has-error @endif">
                    <label for="property_totalarea">Загальна площа, кв.м</label>
                    <input type="text" name="property_totalarea" class="form-control input-lg" id="property_totalarea" value="{{ $auction->property_totalarea }}">
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('property_livingarea'))has-error @endif">
                    <label for="property_livingarea">Житлова площа, кв.м</label>
                    <input type="text" name="property_livingarea" class="form-control input-lg" id="property_livingarea" value="{{ $auction->property_livingarea }}">
                </div>
            </div>
        </div>

    </div>

    <!-- Автомобілі -->
    <div id="Category-4" class="category_group" style="margin: 40px 0 30px 0;display: none">
        <div class="row">
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('auto_mark'))has-error @endif">
                    <label for="auto_mark">Марка</label>
                    <select class="form-control" name="auto_mark" id="auto_mark">
                        <option value>Не обрано</option>
                        @foreach(trans('theme.auto_mark') as $k => $auto_mark)
                            <option value="{{ $k }}" @if($k == $auction->auto_mark) selected @endif>{{ $auto_mark }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('auto_model'))has-error @endif">
                    <label for="auto_model">Модель</label>
                    <input type="text" name="auto_model" class="form-control" id="auto_model" value="{{ $auction->auto_model }}">
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('auto_year'))has-error @endif">
                    <label for="auto_year">Pік випуску</label>
                    <select class="form-control" name="auto_year" id="auto_year">
                        <option value="">Не обрано</option>
                        @foreach(trans('theme.auto_year') as $auto_year)
                            <option value="{{ $auto_year }}" @if($auto_year == $auction->auto_year) selected @endif>{{ $auto_year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-xs-3">
                <div class="form-group @if($errors->has('auto_potencia'))has-error @endif">
                    <label for="auto_potencia">Об'єм двигуна</label>
                    <input type="number" value="{{ $auction->auto_potencia }}" name="auto_potencia" class="form-control">
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('auto_transmission'))has-error @endif">
                    <label for="auto_transmission">Коробка передач</label>
                    <select class="form-control" name="auto_transmission" id="auto_transmission">
                        <option value="">Не обрано</option>
                        @foreach(trans('theme.auto_transmission') as $k => $auto_transmission)
                            <option value="{{ $k }}" @if($k == $auction->auto_transmission) selected @endif>{{ $auto_transmission }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('auto_drive'))has-error @endif">
                    <label for="auto_drive">Тип привода</label>
                    <select class="form-control" name="auto_drive" id="auto_drive">
                        <option value>Не обрано</option>
                        @foreach(trans('theme.auto_drive') as $k => $auto_drive)
                            <option value="{{ $k }}" @if($k == $auction->auto_drive) selected @endif>{{ $auto_drive }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('auto_fuel'))has-error @endif">
                    <label for="auto_fuel">Тип пального</label>
                    <select class="form-control" name="auto_fuel" id="auto_fuel">
                        <option value>Не обрано</option>
                        @foreach(trans('theme.auto_fuel') as $k => $auto_fuel)
                            <option value="{{ $k }}" @if($k == $auction->auto_fuel) selected @endif>{{ $auto_fuel }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('auto_doors'))has-error @endif">
                    <label for="auto_doors">Кількість дверей</label>
                    <select class="form-control" name="auto_doors" id="auto_doors">
                        <option value>Не обрано</option>
                        <option value="2" @if($auction->auto_doors == 2) selected @endif>2</option>
                        <option value="3" @if($auction->auto_doors == 3) selected @endif>3</option>
                        <option value="4" @if($auction->auto_doors == 4) selected @endif>4</option>
                        <option value="5" @if($auction->auto_doors == 5) selected @endif>5</option>
                    </select>
                </div>
            </div>

            <div class="col-xs-3">

                <div class="form-group @if($errors->has('auto_mileage'))has-error @endif">
                    <label for="auto_mileage">Пробіг, тис. км.</label>
                    <input type="number" value="{{ $auction->auto_mileage }}" name="auto_mileage" class="form-control">
                </div>

            </div>

            <div class="col-xs-3">

                <div class="form-group @if($errors->has('lot_DebtorName'))has-error @endif">
                    <label>ПІБ боржника/Назва</label>
                    <input type="number" value="{{ $auction->lot_DebtorName }}" name="lot_DebtorName" class="form-control">
                </div>

            </div>

            <div class="col-xs-3">

                <div class="form-group @if($errors->has('lot_EDRPOU'))has-error @endif">
                    <label>ЄДРПОУ</label>
                    <input type="number" value="{{ $auction->lot_EDRPOU }}" name="lot_EDRPOU" class="form-control">
                </div>

            </div>


        </div>
    </div>

    <div class="row" style="margin-top: 30px;margin-bottom: 30px;">
        <div id="upload_main" class="col-xs-3">
            <div class="form-group">
                <label for="lot_title">Основне зображення</label>

                @if($auction->img)
                <div class="dropzone dz-clickable dz-started dz-max-files-reached" id="main_image">
                    <div class="dz-default dz-message"><span><i class="glyphicon glyphicon-camera"></i><br>Завантажити</span></div>
                    <div class="dz-preview dz-processing dz-image-preview dz-success dz-complete">  <div class="dz-image">
                            <img data-dz-thumbnail="" src="{{ $auction->img }}" alt="" height="200">
                        </div>
                        <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span></div>  <div class="dz-error-message"><span data-dz-errormessage=""></span></div>  <div class="dz-success-mark">    <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">      <title>Check</title>      <defs></defs>      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">        <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>      </g>    </svg>  </div>  <div class="dz-error-mark">    <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">      <title>Error</title>      <defs></defs>      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">        <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">          <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>        </g>      </g>    </svg>  </div>
                        <input type="hidden" name="lot_image" value="{{ $auction->img }}"><input type="hidden" name="lot_image_min" value="{{ $auction->img_min }}">
                        <div onclick="$('#main_image .dz-preview').remove();$('#main_image').removeClass('dz-started dz-max-files-reached');" class="remove-image" data-name="Kk7GP0GUOU.jpg"><i class="glyphicon glyphicon-remove"></i></div></div>
                </div>
                @else
                    <div class="dropzone" id="main_image"></div>
                @endif


            </div>
        </div>

        <style>

            #upload_main .remove-image, #more_image .remove-image {
                position: absolute;
                top: -5px;
                right: -5px;
                z-index: 20;
                background-color: red;
                width: 20px;
                height: 20px;
                text-align: center;
                line-height: 20px;
                color: #fff;
                border-radius: 100%;
                font-size: 10px;
                cursor: pointer;
            }

            #upload_main .remove-image i, #more_image .remove-image i {
                cursor: pointer;
            }

            #upload_main #main_image, #more_image {
                min-height: 210px;
            }

            #upload_main #main_image:hover, #more_image:hover {
                border: 1px dashed #FF9800;
            }

            #upload_main #main_image .dz-message  {
                color: #FF9800;
                margin: 40px 0;
            }

            #upload_main #main_image .dz-message i {
                font-size: 55px;
            }


            #upload_main div#main_image.dz-started {
                border: 0;
                padding: 0;
            }

            #upload_main div#main_image.dz-started .dz-preview.dz-image-preview {
                margin: 5px;
            }

            #upload_main div#main_image.dz-started .dz-image {
                border-radius: 0px;
                width: 200px;
                height: 200px;
            }
        </style>

        <div class="col-xs-9">
            <div class="form-group">
                <label for="lot_title">Додаткові зображення</label>
                <div class="dropzone" id="more_image">

                    <? $photos = \App\Uploads::where('auction_id', '=',$auction->id)->get() ?>

                    @if($photos)

                        @foreach($photos as $photo)
                    <div id="image-{{ $photo->id }}" class="dz-preview dz-processing dz-image-preview dz-success dz-complete">
                        <input type="hidden" name="more_images[]" value="{{ $photo->id }}" />
                        <div class="dz-image">
                            <img data-dz-thumbnail="" src="{{ $photo->image_small }}" alt="">
                        </div>   <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span></div>  <div class="dz-error-message"><span data-dz-errormessage=""></span></div>  <div class="dz-success-mark">    <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">      <title>Check</title>      <defs></defs>      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">        <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>      </g>    </svg>  </div>  <div class="dz-error-mark">    <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">      <title>Error</title>      <defs></defs>      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">        <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">          <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>        </g>      </g>    </svg>  </div>
                        <div id="removefilecutsc" class="remove-image removeimage" data-name="{{ $photo->name }}" data-id="image-{{ $photo->id }}"><i class="glyphicon glyphicon-remove"></i></div></div>

                            @endforeach

                            <script>
                                $('.removeimage').on('click', function(){
                                    var img = $(this);
                                    $.ajax({
                                        type: "POST",
                                        url: "/auctions/upload/delete",
                                        data: "name="+ $(this).data('name'),
                                        success: function(msg){
                                            $('#' + img.data('id')).remove();
                                            console.log(msg);
                                        }
                                    });
                                });
                            </script>

                        @endif
                </div>
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
                <textarea class="form-control" rows="4" name="more_information">{{ $auction->more_information }}</textarea>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label for="about">Відомості про майно, його склад, характеристики, опис</label>
                <textarea class="form-control" rows="4" name="more_about">{{ $auction->more_about }}</textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-3">
            <div class="form-group @if($errors->has('region'))has-error @endif">
                <label for="region">Область</label>
                <select class="form-control input-lg" name="region">
                    <option value>Не обрано</option>
                    @foreach(trans('theme.regions') as $key => $region)
                        <option value="{{ $key }}" @if($key == $auction->region) selected @endif>{{ $region }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group @if($errors->has('city'))has-error @endif">
                <label for="city">Місто</label>
                <input type="text" name="city" class="form-control input-lg" id="city" value="{{ $auction->city }}">
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group">
                <label for="customer_code">Статус</label>
                <select class="form-control input-lg" name="status">
                    @foreach(trans('theme.statuses') as $key => $status)
                        <option value="{{ $key }}" @if($key == $auction->status) selected @endif>{{ $status}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-xs-3">
            <div class="form-group @if($errors->has('data_start'))has-error @endif">
                <label for="data_start">Дата початку аукціону</label>
                <input type="text" name="data_start" class="form-control input-lg" id="data_start" placeholder="" value="{{ $auction->data_start }}">
            </div>
        </div>

    </div>


    <div class="row">
        <div class="col-xs-3">
            <label for="guarantee_fee">Гарантійний внесок</label>
            <div class="input-group input-group-lg @if($errors->has('guarantee_fee'))has-error @endif">
                <input type="text" name="guarantee_fee" class="form-control" id="guarantee_fee" placeholder="" value="{{ $auction->guarantee_fee }}">
                <span class="input-group-addon">грн.</span>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group">
                <label for="starting_price">Стартова ціна</label>
                <div class="input-group input-group-lg @if($errors->has('starting_price'))has-error @endif">
                    <input type="text" name="starting_price" class="form-control" id="starting_price" placeholder="" value="{{ $auction->starting_price }}">
                    <span class="input-group-addon">грн.</span>
                </div>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group">
                <label for="bid_price">Крок аукціону</label>
                <div class="input-group input-group-lg @if($errors->has('bid_price'))has-error @endif">
                    <input type="text" name="bid_price" class="form-control" id="bid_price" placeholder="" value="{{ $auction->bid_price }}">
                    <span class="input-group-addon">грн.</span>
                </div>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group @if($errors->has('date_end'))has-error @endif">
                <label for="date_end">Дата завершення аукціону</label>
                <input type="text" name="date_end" class="form-control input-lg" id="date_end" placeholder="" value="{{ $auction->date_end }}">
            </div>
        </div>
        <div class="col-xs-3">
        <div class="form-group">
            <label>Тип майна</label>
            <select class="form-control input-lg" name="property_type">
                <option value>Не обрано</option>
                @foreach(trans('theme.property_type') as $val => $property_type)
                    <option value="{{ $val }}" @if($val == $auction->property_type) selected @endif>{{ $property_type }}</option>
                @endforeach
            </select>
        </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-lg">Подати оголошення</button>

</form>
</div>
<script>
            $(function () {
                $('#data_start').datetimepicker({
                    format: "YYYY-MM-DD HH:mm",
                    locale: 'ru'
                });

                $('#date_end').datetimepicker({
                    format: "YYYY-MM-DD HH:mm",
                    locale: 'ru'
                });
            });


    var MainDropzone = new Dropzone("div#main_image", {
        url: "/auctions/upload/{{ $auction->id }}",
        uploadMultiple: false,
        maxFiles: 1,
        thumbnailWidth: 200,
        thumbnailHeight: 200,
        dictDefaultMessage: '<i class="glyphicon glyphicon-camera"></i><br>Завантажити',
        init: function() {
            this.on("success", function(file, xhr) {
                // Handle the responseText here. For example, add the text to the preview element:

                var image = Dropzone.createElement('<input type="hidden" name="lot_image" value="'+ xhr.img +'" />');
                var image_min = Dropzone.createElement('<input type="hidden" name="lot_image_min" value="'+ xhr.imgmin +'" />');

                console.log(xhr.responseText);
                file.previewTemplate.appendChild(image);
                file.previewTemplate.appendChild(image_min);

                // Create the remove button
                var removeButton = Dropzone.createElement("<div class='remove-image' data-name='"+ xhr.url +"'><i class='glyphicon glyphicon-remove'></i></div>");

                // Capture the Dropzone instance as closure.
                var _this = this;

                // Listen to the click event
                removeButton.addEventListener("click", function(e) {
                    // Make sure the button click doesn't submit the form:
                    e.preventDefault();
                    e.stopPropagation();

                    // Remove the file preview.
                    _this.removeFile(file);

                    $.ajax({
                        type: "POST",
                        url: "/auctions/upload/delete",
                        data: "name="+ xhr.url,
                        success: function(msg){
                            console.log(msg);
                        }
                    });

                    // If you want to the delete the file on the server as well,
                    // you can do the AJAX request here.
                });

                // Add the button to the file preview element.
                file.previewElement.appendChild(removeButton);

            });
        }
    });

    var myDropzone = new Dropzone("div#more_image", {
        paramName: "file",
        url: "/auctions/upload/{{ $auction->id }}",
        dictDefaultMessage: 'Натисніть або перетягніть фотографії в цю область для початку завантаження',
        init: function() {
            this.on("success", function(file, xhr) {
                // Handle the responseText here. For example, add the text to the preview element:

                var image = Dropzone.createElement('<input type="hidden" name="more_images[]" value="'+ xhr.id +'" />');

                console.log(xhr.responseText);
                file.previewTemplate.appendChild(image);

                // Create the remove button
                var removeButton = Dropzone.createElement("<div class='remove-image' data-name='"+ xhr.url +"'><i class='glyphicon glyphicon-remove'></i></div>");

                // Capture the Dropzone instance as closure.
                var _this = this;

                // Listen to the click event
                removeButton.addEventListener("click", function(e) {
                    // Make sure the button click doesn't submit the form:
                    e.preventDefault();
                    e.stopPropagation();

                    // Remove the file preview.
                    _this.removeFile(file);

                    $.ajax({
                        type: "POST",
                        url: "/auctions/upload/delete",
                        data: "name="+ xhr.url,
                        success: function(msg){
                            console.log(msg);
                        }
                    });

                    // If you want to the delete the file on the server as well,
                    // you can do the AJAX request here.
                });

                // Add the button to the file preview element.
                file.previewElement.appendChild(removeButton);

            });


        }
    });


    $('#SelectCategory').on('change', function(){
        $('.category_group').hide();
        $('#Category-' + $(this).val()).show();

    });



</script>

@endsection