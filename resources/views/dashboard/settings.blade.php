@extends('dashboard.layout')
@section('content')

    <div class="container-fluid">
        <h2 class="sub-header" style="margin-bottom: 20px">Налаштування</h2>

        @foreach($errors->all(':message') as $message)
            <div class="alert alert-danger">{{ $message }}</div>
        @endforeach

        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif

        <form role="form" method="post">

            {!! csrf_field() !!}
        @foreach($settings as $setting)
                <div class="form-group">
                    <label>{{ $setting->title }}</label>
                    <input type="text" class="form-control" name="{{ $setting->name }}" value="{{ $setting->value }}" @if($setting->may_change == 0) disabled @endif>
                </div>
        @endforeach

            <button type="submit">Зберегти</button>

        </form>


    </div>


@endsection