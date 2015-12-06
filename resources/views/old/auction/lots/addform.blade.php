<script>
    var postid = {{ $last_id }};
    @if($activeCategory)$(document).ready(function(){$('#Category-{{$activeCategory}}').show();});
    @endif
</script>

@foreach($errors->all('<li>:message</li>') as $message)
    {{ $message }}
    @endforeach

<form id="AddLot" method="post" action style="margin-top: 50px;padding: 0 110px;">
    {!! csrf_field() !!}
    <div class="row">
        <div class="col-md-6">

            <div class="form-group @if($errors->has('lot_title'))has-error @endif">
                <label for="lot_title">Назва лоту</label>
                <input type="text" name="lot_title" class="form-control input-lg" id="lot_title" placeholder="">
            </div>

        </div>
        <div class="col-md-6">

            <div class="form-group @if($errors->has('lot_category'))has-error @endif">
                <label for="lot_category">Категорія лоту</label>
                <select id="SelectCategory" class="form-control input-lg" name="lot_category">
                    <option value>Не обрано</option>
                    <? $cats = \App\Cat::roots()->get(); ?>
                    @foreach($cats as $category)
                        <option @if($activeCategory == $category->id)selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
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
                            <option value="{{ $val }}">{{ $property_material }}</option>
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
                            <option value="{{ $val }}">{{ $property_purpose }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('property_floors'))has-error @endif">
                    <label for="property_floors">Кiлькiсть поверхiв</label>
                    <input type="text" name="property_floors" class="form-control input-lg" id="property_floors">
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('property_areas'))has-error @endif">
                    <label for="property_areas">Кiмнат/примiщень</label>
                    <input type="text" name="property_areas" class="form-control input-lg" id="property_areas">
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('property_totalarea'))has-error @endif">
                    <label for="property_totalarea">Загальна площа, кв.м</label>
                    <input type="text" name="property_totalarea" class="form-control input-lg" id="property_totalarea">
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('property_livingarea'))has-error @endif">
                    <label for="property_livingarea">Житлова площа, кв.м</label>
                    <input type="text" name="property_livingarea" class="form-control input-lg" id="property_livingarea">
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
                            <option value="{{ $k }}">{{ $auto_mark }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('auto_model'))has-error @endif">
                    <label for="auto_model">Модель</label>
                    <input type="text" name="auto_model" class="form-control" id="auto_model">
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('auto_year'))has-error @endif">
                    <label for="auto_year">Pік випуску</label>
                    <select class="form-control" name="auto_year" id="auto_year">
                        <option value="">Не обрано</option>
                        @foreach(trans('theme.auto_year') as $auto_year)
                            <option value="{{ $auto_year }}">{{ $auto_year }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-3">

                <div class="form-group @if($errors->has('auto_potencia'))has-error @endif">
                    <label for="auto_potencia">Об'єм двигуна</label>
                    <input type="number" name="auto_potencia" class="form-control">
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
                            <option value="{{ $k }}">{{ $auto_transmission }}</option>
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
                            <option value="{{ $k }}">{{ $auto_drive }}</option>
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
                            <option value="{{ $k }}">{{ $auto_fuel }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group @if($errors->has('auto_doors'))has-error @endif">
                    <label for="auto_doors">Кількість дверей</label>
                    <select class="form-control" name="auto_doors" id="auto_doors">
                        <option value>Не обрано</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
            </div>

            <div class="col-xs-3">

                <div class="form-group @if($errors->has('auto_mileage'))has-error @endif">
                    <label for="auto_mileage">Пробіг, тис. км.</label>
                    <input type="number" name="auto_mileage" class="form-control">
                </div>

            </div>

            <div class="col-xs-3">

                <div class="form-group @if($errors->has('lot_DebtorName'))has-error @endif">
                    <label>ПІБ боржника/Назва</label>
                    <input type="number" name="lot_DebtorName" class="form-control">
                </div>

            </div>

            <div class="col-xs-3">

                <div class="form-group @if($errors->has('lot_EDRPOU'))has-error @endif">
                    <label>ЄДРПОУ</label>
                    <input type="number" name="lot_EDRPOU" class="form-control">
                </div>

            </div>
        </div>
    </div>

    <? $auction = null; ?>
    <!-- Будівельні матеріали -->
    <div id="Category-39" class="category_group" style="margin: 40px 0 30px 0;display: none">
        @include('dashboard.fields.build')
    </div>

    <!-- Техніка та меблі -->
    <div id="Category-30" class="category_group" style="margin: 40px 0 30px 0;display: none">
        @include('dashboard.fields.stuff')
    </div>

    <!-- Корпоративні права -->
    <div id="Category-37" class="category_group" style="margin: 40px 0 30px 0;display: none">
        @include('dashboard.fields.corporate')
    </div>

    <div class="row" style="margin-top: 30px;margin-bottom: 30px;">
        <div id="upload_main" class="col-xs-3">
            <div class="form-group">
                <label for="lot_title">Основне зображення</label>
                <div class="dropzone" id="main_image"></div>
            </div>
        </div>

        <div class="col-xs-9">
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
                <textarea class="form-control" rows="4" name="more_information"></textarea>
            </div>
        </div>
        <div class="col-xs-6">
            <div class="form-group">
                <label for="about">Відомості про майно, його склад, характеристики, опис</label>
                <textarea class="form-control" rows="4" name="more_about"></textarea>
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
                        <option value="{{ $key }}">{{ $region }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group @if($errors->has('city'))has-error @endif">
                <label for="city">Місто</label>
                <input type="text" name="city" class="form-control input-lg" id="city">
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group">
                <label>Тип майна</label>
                <select class="form-control input-lg" name="property_type">
                    <option value>Не обрано</option>
                    @foreach(trans('theme.property_type') as $val => $property_type)
                        <option value="{{ $val }}">{{ $property_type }}</option>
                    @endforeach
                </select>

            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group @if($errors->has('data_start'))has-error @endif">
                <label for="data_start">Дата початку аукціону</label>
                <input type="text" name="data_start" class="form-control input-lg" id="data_start" placeholder="">
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xs-3">
            <label for="guarantee_fee">Гарантійний внесок</label>
            <div class="input-group input-group-lg @if($errors->has('guarantee_fee'))has-error @endif">
                <input type="text" name="guarantee_fee" class="form-control" id="guarantee_fee" placeholder="">
                <span class="input-group-addon">грн.</span>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group">
                <label for="starting_price">Стартова ціна</label>
                <div class="input-group input-group-lg @if($errors->has('starting_price'))has-error @endif">
                    <input type="text" name="starting_price" class="form-control" id="starting_price" placeholder="">
                    <span class="input-group-addon">грн.</span>
                </div>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group">
                <label for="bid_price">Крок аукціону</label>
                <div class="input-group input-group-lg @if($errors->has('bid_price'))has-error @endif">
                    <input type="text" name="bid_price" class="form-control" id="bid_price" placeholder="">
                    <span class="input-group-addon">грн.</span>
                </div>
            </div>
        </div>
        <div class="col-xs-3">
            <div class="form-group @if($errors->has('date_end'))has-error @endif">
                <label for="date_end">Дата завершення аукціону</label>
                <input type="text" name="date_end" class="form-control input-lg" id="date_end" placeholder="">
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary btn-lg">Подати оголошення</button>

</form>

<script type="text/javascript">
    $(function () {
        $('#data_start').datetimepicker({
            locale: 'ru'
        });

        $('#date_end').datetimepicker({
            locale: 'ru'
        });
    });
</script>

<script>

    Date.prototype.dateFormat = function( format ){
        return moment(this).format(format);
    };

    Dropzone.autoDiscover = false;

    var MainDropzone = new Dropzone("div#main_image", {
        url: "/auctions/upload/{{ $last_id }}",
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
        url: "/auctions/upload/{{ $last_id }}",
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