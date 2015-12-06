@extends('layouts')

@section('title'){{$page->title}} - @lang('theme.sitename_title')@endsection

@section('content')

    <h2>Задати питання</h2>

    @foreach($errors->all(':message') as $message)
    <div class="alert alert-danger" style="padding: 10px;">{{ $message }}</div>
        @endforeach

<div id="question-page">
    <form action="/forms/question" method="post" role="form">
        <div class="form-group">
            <label for="InputName">Ваше ім&#39;я</label>
            <input class="form-control" id="InputName" name="person" placeholder="" type="text" />
        </div>

        <div class="form-group">
            <label for="exampleInputPassword1">E-mail</label>
            <input class="form-control" id="InputEmail" name="email" placeholder="" type="email" />
        </div>
        <input name="_token" type="hidden" value="{{ csrf_token() }}" />
        <div class="form-group">
            <label for="InputQuestion">Питання</label>
            <textarea class="form-control" name="question" rows="5"></textarea>
        </div>
        <button class="btn btn-warning btn-lg" type="submit">Отправить вопрос</button>
    </form>
</div>

    {!! $page->contant !!}
@endsection