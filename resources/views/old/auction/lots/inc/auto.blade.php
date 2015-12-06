<div class="tab-pane active" id="features">
    <div id="auction_more" class="row">
        <div class="col-xs-6">
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

                    @if($auction->property_material)
                        <tr>
                            <td>Матеріал будівлі</td>
                            <td>{{ trans('theme.property_material.'. $auction->property_material) }}</td>
                        </tr>
                    @endif

                    </tbody>
                </table>

            </div>
        </div>
        <div class="col-xs-6">
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
                <p>{!! nl2br(e($auction->more_information)) !!} </p>

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