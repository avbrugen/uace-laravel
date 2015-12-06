<div class="row">
    <div class="col-xs-6 col-md-3">
        <div class="form-group @if($errors->has('stuff_brand'))has-error @endif">
            <label for="region">Виробник</label>
            <select class="form-control" name="stuff_brand">
                <option value>Не обрано</option>
                @foreach(trans('theme.stuff_brand') as $key => $brand)
                    <option value="{{ $key }}" @if($auction && $auction->stuff_brand == $key) selected @endif>{{ $brand }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-xs-6 col-md-3">
        <div class="form-group @if($errors->has('stuff_model'))has-error @endif">
            <label for="region">Модель</label>
            <select class="form-control" name="stuff_model">
                <option value>Не обрано</option>
                @foreach(trans('theme.equipment_model') as $key => $brand)
                    <option value="{{ $key }}" @if($auction && $auction->stuff_model == $key) selected @endif>{{ $brand }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-xs-6 col-md-3">
        <div class="form-group @if($errors->has('stuff_year'))has-error @endif">
            <label>Рік</label>
            <input type="number" name="stuff_year" class="form-control" @if($auction)value="{{ $auction->stuff_year }}"@endif>
        </div>
    </div>

    <div class="col-xs-6 col-md-3">
        <div class="form-group @if($errors->has('stuff_diagonal'))has-error @endif">
            <label>Діагональ, дюймів</label>
            <input type="number" name="stuff_diagonal" class="form-control" @if($auction)value="{{ $auction->stuff_diagonal }}"@endif>
        </div>
    </div>
</div>