<div class="row">
    <div class="col-xs-3">
        <div class="form-group @if($errors->has('equipment_brand'))has-error @endif">
            <label for="region">Виробник</label>
            <select class="form-control" name="equipment_brand">
                <option value>Не обрано</option>
                @foreach(trans('theme.equipment_brand') as $key => $brand)
                    <option value="{{ $key }}" @if($auction && $auction->equipment_brand == $key) selected @endif>{{ $brand }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-xs-3">
        <div class="form-group @if($errors->has('equipment_model'))has-error @endif">
            <label for="region">Модель</label>
            <select class="form-control" name="equipment_model">
                <option value>Не обрано</option>
                @foreach(trans('theme.equipment_model') as $key => $brand)
                    <option value="{{ $key }}" @if($auction && $auction->equipment_model == $key) selected @endif>{{ $brand }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-xs-3">
        <div class="form-group @if($errors->has('equipment_year'))has-error @endif">
            <label>Рік</label>
            <input type="number" name="equipment_year" class="form-control" @if($auction)value="{{ $auction->equipment_year }}"@endif>
        </div>
    </div>

    <div class="col-xs-3">
        <div class="form-group @if($errors->has('equipment_power'))has-error @endif">
            <label>Потужність, кВт</label>
            <input type="number" name="equipment_power" class="form-control" @if($auction)value="{{ $auction->equipment_power }}"@endif>
        </div>
    </div>
</div>