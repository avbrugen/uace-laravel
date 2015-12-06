@if($categories->count() > 0)
    <label for="lot_type">Тип <span class="label-required">*</span></label>
<select id="selectLotType" class="form-control input-lg" name="lot_type">
    @foreach($categories as $category)
    <option value="{{ $category->id }}">{{ $category->name }}</option>
@endforeach
</select>
@endif

<script>
    $(document).ready(function () {
        $('#selectLotType').on('change', function(e){
            if($(this).val() == 7 || $(this).val() == 8)
            {
                $('#label_plot_size span').show();
            } else {
                $('#label_plot_size span').hide();
            }

        });
    });
</script>