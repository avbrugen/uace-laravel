@extends('auction.layout')
@section('title')Відновлення пароля - @lang('theme.sitename_title')@endsection

@section('content')
    <div class="container">
        <div class="auction_page_title">Відновлення пароля</div>

        <div class="register_container">

            <form method="POST" action="/password/reset">
                {!! csrf_field() !!}
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="Email">Введіть E-mail</label>
                    <input type="email" name="email" class="form-control input-lg" id="Email" placeholder="ivan@yandex.ua" value="{{ old('email') }}">
                </div>

                <div class="form-group">
                    <label for="password">Новий пароль</label>
                    <input type="password" name="password" class="form-control input-lg">
                </div>

                <div class="form-group">
                    <label for="password">Новий пароль ще раз</label>
                    <input type="password" name="password_confirmation" class="form-control input-lg">
                </div>

                <div>
                    <button type="submit" class="btn btn-success btn-lg pull-right">Відновити пароль</button>
                </div>
            </form>


        </div>
    </div>
@endsection