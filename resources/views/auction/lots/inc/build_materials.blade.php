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
                <td>Тип матеріалу</td>
                <td>{{ $cat = \App\Cat::find($auction->lot_type)->name  }}</td>
            </tr>

            @if($auction->property_type)
                <tr>
                    <td>Тип майна</td>
                    <td>{{ trans('theme.property_type.'. $auction->property_type) }}</td>
                </tr>
            @endif

            @if($auction->build_materials_col)
                <tr>
                    <td>Кількість тис. шт.</td>
                    <td>{{ $auction->build_materials_col }}</td>
                </tr>
            @endif

            @if($auction->build_materials_weight)
                <tr>
                    <td>Маса, кг</td>
                    <td>{{ $auction->build_materials_weight }}</td>
                </tr>
            @endif

            @if($auction->build_materials_volume)
                <tr>
                    <td>Об'єм, м<sup>3</sup></td>
                    <td>{{ $auction->build_materials_volume }}</td>
                </tr>
            @endif

            @if($auction->build_materials_width)
                <tr>
                    <td>Ширина</td>
                    <td>{{ $auction->build_materials_width }}</td>
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