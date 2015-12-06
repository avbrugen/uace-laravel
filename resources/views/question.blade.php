@extends('layouts')

@section('title'){{$page->title}} - @lang('theme.sitename_title')@endsection

@section('content')

    <h2>Задати питання</h2>

<div id="question-page">

    @if(Session::has('sended'))
        <div class="alert alert-success">{{ Session::get('sended') }}</div>
    @endif

    <form action="/forms/question" method="post" role="form">
        <div class="form-group @if($errors->has('person'))has-error @endif">
            <label for="InputName">Ваше ім&#39;я</label>
            <input class="form-control" id="InputName" name="person" placeholder="" type="text" value="{{ old('person') }}" />
        </div>

        <div class="form-group @if($errors->has('phone'))has-error @endif">
            <label>Телефон</label>
            <input class="form-control" name="phone" placeholder="+38 (099) 999-99-99" type="text" value="{{ old('phone') }}" />
        </div>

        <div class="form-group @if($errors->has('email'))has-error @endif">
            <label>E-mail</label>
            <input class="form-control" id="InputEmail" name="email" placeholder="" type="email" value="{{ old('email') }}" />
        </div>

        <input name="_token" type="hidden" value="{{ csrf_token() }}" />
        <div class="form-group @if($errors->has('question'))has-error @endif">
            <label for="InputQuestion">Питання</label>
            <textarea class="form-control" name="question" rows="5">{{ old('question') }}</textarea>
        </div>
        <button class="btn btn-warning btn-lg" type="submit">Задати питання</button>
    </form>
</div>

    {!! $page->contant !!}
@endsection