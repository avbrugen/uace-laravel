@if($categories->count() > 0)
    <label for="lot_type">Тип</label>
<select class="form-control input-lg" name="lot_type">
    @foreach($categories as $category)
    <option value="{{ $category->id }}">{{ $category->name }}</option>
@endforeach
</select>
@endif