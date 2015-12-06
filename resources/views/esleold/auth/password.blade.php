@extends('auction.layout')
@section('title')Відновлення пароля - @lang('theme.sitename_title')@endsection

@section('content')
    <div class="container">
        <div class="auction_page_title">Відновлення пароля</div>

        <div class="register_container">

        <form method="POST" action="/password/email">
            {!! csrf_field() !!}

            <div>
                Email
                <input type="email" name="email" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label for="Email">Введіть E-mail</label>
                <input type="email" name="email" class="form-control input-lg" id="Email" placeholder="ivan@yandex.ua" value="{{ old('email') }}">
            </div>

            <div>
                <button type="submit">
                    Send Password Reset Link
                </button>
            </div>
        </form>


        </div>
    </div>
@endsection









