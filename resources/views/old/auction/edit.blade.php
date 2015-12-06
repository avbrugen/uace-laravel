@extends('auction.layout')
@section('title')Зміна даних - @lang('theme.sitename_title')@endsection

@section('content')
    <div class="container">
        <div class="auction_page_title">Зміна даних</div>

        <div class="register_container">

            <form id="update_form" role="form" method="POST" action="{{action('AuctionsController@postEdit')}}">
                {!! csrf_field() !!}
                <input type="hidden" name="personGroup" value="1">
                <div class="form-group @if($errors->has('LastName') && $group == 1)has-error @endif">
                    <label for="InputLastName">Ваше прізвище</label>
                    <input type="text" name="LastName" class="form-control input-lg" id="InputLastName" value="{{ $current->last_name }}" placeholder="Іванов">
                    @if($errors->has('LastName') && $group == 1)<p class="text-danger">{{ $errors->first('LastName') }}</p>@endif
                </div>
                <div class="form-group @if($errors->has('FirstName') && $group == 1)has-error @endif">
                    <label for="InputFirstName">Ваше ім'я</label>
                    <input type="text" name="FirstName" class="form-control input-lg" id="InputFirstName" value="{{ $current->first_name }}" placeholder="Іван">
                    @if($errors->has('FirstName') && $group == 1)<p class="text-danger">{{ $errors->first('FirstName') }}</p>@endif
                </div>
                <div class="form-group @if($errors->has('MiddleName') && $group == 1)has-error @endif">
                    <label for="InputMiddleName">Ваше по-батькові</label>
                    <input type="text" name="MiddleName" class="form-control input-lg" id="InputMiddleName" value="{{ $current->middle_name }}" placeholder="Іванович">
                    @if($errors->has('MiddleName') && $group == 1)<p class="text-danger">{{ $errors->first('MiddleName') }}</p>@endif
                </div>
                <!--<div class="form-group @if($errors->has('email') && $group == 1)has-error @endif">
                    <label for="InputEmail">E-mail</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control input-lg" id="InputEmail" placeholder="ivan@yandex.ua">
                    <p class="help-block">Ваш E-mail буде використовуватися в якості логіна для входу в систему.</p>
                    @if($errors->has('email') && $group == 1)<p class="text-danger">{{ $errors->first('email') }}</p>@endif
                </div>-->
                <div class="form-group @if($errors->has('phone') && $group == 1)has-error @endif">
                    <label for="InputPhone">Ваш номер телефону</label>
                    <input type="text" name="phone" class="form-control input-lg" id="InputPhone" value="{{ $current->phone }}" placeholder="+38099-999-99-99">
                    @if($errors->has('phone') && $group == 1)<p class="text-danger">{{ $errors->first('phone') }}</p>@endif
                </div>
                <!--<div class="form-group  @if($errors->has('password') && $group == 1)has-error @endif">
                    <label for="InputPassword">Введіть пароль</label>
                    <input type="password" name="password" class="form-control input-lg" id="InputPassword" placeholder="••••••••••••">
                    @if($errors->has('password') && $group == 1)<p class="text-danger">{{ $errors->first('password') }}</p>@endif
                </div>
                <div class="form-group">
                    <label for="InputPasswordConfirmed">Введіть пароль повторно</label>
                    <input type="password" name="password_confirmation" class="form-control input-lg" id="InputPasswordConfirmed" placeholder="••••••••••••">
                    <p class="help-block">Пароль повинен містити не менше 6 символів.</p>
                </div>-->
                <button type="submit" class="btn btn-primary btn-lg">Оновити інформацію</button>
            </form>

        </div>

    </div>
@endsection