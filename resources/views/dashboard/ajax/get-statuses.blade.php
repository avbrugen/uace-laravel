@foreach(trans('theme.statuses') as $key => $status)
    <option value="{{ $key }}">{{ $status}}</option>
@endforeach