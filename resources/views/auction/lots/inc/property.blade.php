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
                <td>Тип нерухомості</td>
                <td>{{ $cat = \App\Cat::find($auction->lot_type)->name  }}</td>
            </tr>

            @if($auction->property_type)
                <tr>
                    <td>Тип майна</td>
                    <td>{{ trans('theme.property_type.'. $auction->property_type) }}</td>
                </tr>
            @endif

            @if($auction->property_purpose)
                <tr>
                    <td>Цільове призначення</td>
                    <td>{{ trans('theme.property_purpose.'. $auction->property_purpose) }}</td>
                </tr>
            @endif

            @if($auction->property_material)
            <tr>
                <td>Матеріал будівлі</td>
                <td>{{ trans('theme.property_material.'. $auction->property_material) }}</td>
            </tr>
            @endif

            @if($auction->property_floors)
                <tr>
                    <td>Кількість поверхів</td>
                    <td>{{ $auction->property_floors }}</td>
                </tr>
            @endif

            @if($auction->property_floor)
                <tr>
                    <td>Поверх</td>
                    <td>{{ $auction->property_floor }}</td>
                </tr>
            @endif

            @if($auction->property_areas)
                <tr>
                    <td>Кiмнат/примiщень</td>
                    <td>{{ $auction->property_areas }}</td>
                </tr>
            @endif

            @if($auction->property_totalarea)
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

            @if($auction->plot_size)
                <tr>
                    <td>Розмір земельної ділянки, кв.м</td>
                    <td>{{ $auction->plot_size }}</td>
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