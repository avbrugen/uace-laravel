<div class="tab-pane @if(!Session::has('bit_success')) active @endif" id="features">
    <div id="auction_more" class="row">
        <div class="col-sm-12 col-md-6">
            <div class="col">
                <table class="table">
                    <tbody>

                    <tr>
                        <td>Номер лоту</td>
                        <td>{{ $auction->id }}</td>
                    </tr>

                    <tr>
                        <td>Тип авто</td>
                        <td>{{ $cat = \App\Cat::find($auction->lot_type)->name  }}</td>
                    </tr>

                    @if($auction->property_type)
                        <tr>
                            <td>Тип майна</td>
                            <td>{{ trans('theme.property_type.'. $auction->property_type) }}</td>
                        </tr>
                    @endif

                    <tr>
                        <td>Марка</td>
                        <td>{{ trans('theme.auto_mark.'. $auction->auto_mark) }}</td>
                    </tr>

                    <tr>
                        <td>Модель</td>
                        <td>{{ $auction->auto_model }}</td>
                    </tr>

                    <tr>
                        <td>Pік випуску</td>
                        <td>{{ $auction->auto_year }}</td>
                    </tr>

                    @if($auction->auto_potencia)
                    <tr>
                        <td>Об'єм двигуна</td>
                        <td>{{ $auction->auto_potencia }}</td>
                    </tr>
                    @endif

                    <tr>
                        <td>Коробка передач</td>
                        <td>{{ trans('theme.auto_transmission.'. $auction->auto_transmission) }}</td>
                    </tr>

                    <tr>
                        <td>Тип привода</td>
                        <td>{{ trans('theme.auto_drive.'. $auction->auto_drive) }}</td>
                    </tr>

                    <tr>
                        <td>Тип пального</td>
                        <td>{{ trans('theme.auto_fuel.'. $auction->auto_fuel) }}</td>
                    </tr>

                    <tr>
                        <td>Кількість дверей</td>
                        <td>{{ $auction->auto_doors }}</td>
                    </tr>

                    @if($auction->auto_mileage)
                    <tr>
                        <td>Пробіг, тис. км.</td>
                        <td>{{ $auction->auto_mileage }}</td>
                    </tr>
                    @endif

                    @if($auction->lot_DebtorName)
                        <tr>
                            <td>ПІБ боржника/Назва</td>
                            <td>{{ $auction->lot_DebtorName }}</td>
                        </tr>
                    @endif

                    @if($auction->lot_EDRPOU)
                        <tr>
                            <td>ЄДРПОУ</td>
                            <td>{{ $auction->lot_EDRPOU }}</td>
                        </tr>
                    @endif

                    </tbody>
                </table>

            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="col">

                <table class="table">
                    <tbody>

                    @if($auction->property_floors)
                        <tr>
                            <td>Кiлькiсть поверхiв</td>
                            <td>{{ $auction->property_floors }}</td>
                        </tr>
                    @endif

                    @if($auction->property_areas)
                        <tr>
                            <td>Кiмнат/примiщень</td>
                            <td>{{ $auction->property_areas }}</td>
                        </tr>
                    @endif

                    @if($auction->property_areas)
                        <tr>
                            <td>Загальна площа, кв.м</td>
                            <td>{{ $auction->property_totalarea }}</td>
                        </tr>
                    @endif

                    @if($auction->property_livingarea)
                        <tr>
                            <td>Житлова площа, кв.м </td>
                            <td>{{ $auction->property_livingarea }}</td>
                        </tr>
                    @endif

                    </tbody>
                </table>

                <h4>Додаткові відомості:</h4>
                <?php
                function activateUrlStrings($str){
                    $find = array('`((?:https?|ftp)://\S+[[:alnum:]]/?)`si', '`((?<!//)(www\.\S+[[:alnum:]]/?))`si');
                    $replace = array('<a href="$1" target="_blank">$1</a>', '<a href="http://$1" target="_blank">$1</a>');
                    return preg_replace($find,$replace,$str);
                }

                $string = activateUrlStrings($auction->more_information);
                ?>
                <p>{!! html_entity_decode(nl2br(e($string))) !!} </p>

            </div>
        </div>
    </div>
</div>

<div class="tab-pane" id="info">
    <div id="auction_more">
        <div class="col">
            <h4>Відомості про майно, його склад, характеристики, опис </h4>
            <p>{!! nl2br(e($auction->more_about)) !!} </p>
        </div></div>
</div>