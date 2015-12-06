<div class="row">
    <div class="col-xs-3">
        <div class="form-group @if($errors->has('build_materials_col'))has-error @endif">
            <label>Кількість тис. шт.</label>
            <input type="number" name="build_materials_col" class="form-control" @if($auction)value="{{ $auction->build_materials_col }}"@endif>
        </div>
    </div>

    <div class="col-xs-3">
        <div class="form-group @if($errors->has('build_materials_weight'))has-error @endif">
            <label>Маса, кг</label>
            <input type="number" name="build_materials_weight" class="form-control" @if($auction)value="{{ $auction->build_materials_weight }}"@endif>
        </div>
    </div>

    <div class="col-xs-3">
        <div class="form-group @if($errors->has('build_materials_volume'))has-error @endif">
            <label>Об'єм, м<sup>3</sup></label>
            <input type="number" name="build_materials_volume" class="form-control" @if($auction)value="{{ $auction->build_materials_volume }}"@endif>
        </div>
    </div>

    <div class="col-xs-3">
        <div class="form-group @if($errors->has('build_materials_width'))has-error @endif">
            <label>Ширина</label>
            <input type="number" name="build_materials_width" class="form-control" @if($auction)value="{{ $auction->build_materials_width }}"@endif>
        </div>
    </div>

    <div class="col-xs-3">
        <div class="form-group @if($errors->has('lot_DebtorName'))has-error @endif">
            <label>ПІБ боржника/Назва</label>
            <input type="number" name="lot_DebtorName" class="form-control" @if($auction)value="{{ $auction->lot_DebtorName }}"@endif>
        </div>
    </div>

    <div class="col-xs-3">
        <div class="form-group @if($errors->has('lot_EDRPOU'))has-error @endif">
            <label>ЄДРПОУ</label>
            <input type="number" name="lot_EDRPOU" class="form-control" @if($auction)value="{{ $auction->lot_EDRPOU }}"@endif>
        </div>
    </div>
</div>