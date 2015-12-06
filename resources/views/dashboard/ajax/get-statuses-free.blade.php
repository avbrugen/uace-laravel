@foreach(trans('theme.statuses_free') as $key => $status)
    <option value="{{ $key }}">{{ $status}}</option>
@endforeach