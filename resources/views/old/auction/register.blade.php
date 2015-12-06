@extends('auction.layout')
@section('title')Реєстрація - @lang('theme.sitename_title')@endsection

@section('content')
    <div class="container">
        <div class="auction_page_title">Реєстрація користувача</div>

        <div class="register_container">

            <script>
                $(document).ready(function(){
                    $('#personGroup1').on('click', function() {
                        $('#register_form-2').hide();
                        $('#register_form-1').show();
                    });

                    $('#personGroup2').on('click', function() {
                        $('#register_form-1').hide();
                        $('#register_form-2').show();
                    });
                });

            </script>

            <? if(Session::has('personGroup')) {
                $group = Session::get('personGroup');
            } else {
                $group = 1;
            }
            ?>

            <div class="radio personGroup">
                <label id="personGroup1" class="checkbox-inline">
                    <input type="radio" name="personGroup" @if($group == 1) checked @endif>
                    Фізична особа
                </label>
                <label id="personGroup2" class="checkbox-inline">
                    <input type="radio" name="personGroup" @if($group == 2) checked @endif>
                    Юридична особа
                </label>
            </div>

            <!-- Форма для регистрации физического лица -->
            <form id="register_form-1" role="form" method="POST" action="/auth/register" @if($group == 1) style="display: block" @else style="display: none" @endif>
                {!! csrf_field() !!}
                <input type="hidden" name="personGroup" value="1">
                <div class="form-group @if($errors->has('LastName') && $group == 1)has-error @endif">
                    <label for="InputLastName">Введіть прізвище  <span class="label-required">*</span></label>
                    <input type="text" name="LastName" class="form-control input-lg" id="InputLastName" placeholder="Іванов" value="{{ old('LastName') }}">
                    @if($errors->has('LastName') && $group == 1)<p class="text-danger">{{ $errors->first('LastName') }}</p>@endif
                </div>
                <div class="form-group @if($errors->has('FirstName') && $group == 1)has-error @endif">
                    <label for="InputFirstName">Введіть ім'я  <span class="label-required">*</span></label>
                    <input type="text" name="FirstName" class="form-control input-lg" id="InputFirstName" placeholder="Іван" value="{{ old('FirstName') }}">
                    @if($errors->has('FirstName') && $group == 1)<p class="text-danger">{{ $errors->first('FirstName') }}</p>@endif
                </div>
                <div class="form-group @if($errors->has('MiddleName') && $group == 1)has-error @endif">
                    <label for="InputMiddleName">Введіть по-батькові  <span class="label-required">*</span></label>
                    <input type="text" name="MiddleName" class="form-control input-lg" id="InputMiddleName" placeholder="Іванович" value="{{ old('MiddleName') }}">
                    @if($errors->has('MiddleName') && $group == 1)<p class="text-danger">{{ $errors->first('MiddleName') }}</p>@endif
                </div>
                <div class="form-group @if($errors->has('email') && $group == 1)has-error @endif">
                    <label for="InputEmail">E-mail  <span class="label-required">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control input-lg" id="InputEmail" placeholder="ivan@yandex.ua">
                    <p class="help-block">Ваш E-mail буде використовуватися в якості логіна для входу в систему.</p>
                    @if($errors->has('email') && $group == 1)<p class="text-danger">{{ $errors->first('email') }}</p>@endif
                </div>
                <div class="form-group @if($errors->has('phone') && $group == 1)has-error @endif">
                    <label for="InputPhone">Введіть номер телефону  <span class="label-required">*</span></label>
                    <input type="text" name="phone" class="form-control input-lg" id="InputPhone" placeholder="+38099-999-99-99" value="{{ old('phone') }}">
                    @if($errors->has('phone') && $group == 1)<p class="text-danger">{{ $errors->first('phone') }}</p>@endif
                </div>
                <div class="form-group  @if($errors->has('password') && $group == 1)has-error @endif">
                    <label for="InputPassword">Введіть пароль  <span class="label-required">*</span></label>
                    <input type="password" name="password" class="form-control input-lg" id="InputPassword" placeholder="••••••••••••">
                    @if($errors->has('password') && $group == 1)<p class="text-danger">{{ $errors->first('password') }}</p>@endif
                </div>
                <div class="form-group">
                    <label for="InputPasswordConfirmed">Введіть пароль повторно  <span class="label-required">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control input-lg" id="InputPasswordConfirmed" placeholder="••••••••••••">
                    <p class="help-block">Пароль повинен містити не менше 6 символів.</p>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> Я погоджуюсь з правилами
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Зареєструватися</button>
                <p class="pull-right"><span class="label-required">*</span> — обов'язкові поля.</p>
            </form>

            <!-- Форма для регистрации юридического лица -->
            <form id="register_form-2" role="form" method="POST" action="/auth/register"  @if($group == 2) style="display: block" @else style="display: none" @endif>
                {!! csrf_field() !!}
                <input type="hidden" name="personGroup" value="2">

                <div class="form-group @if($errors->has('legal_entity') && $group == 2)has-error @endif">
                    <label for="InputNameLegalEntity">Найменування юридичної особи  <span class="label-required">*</span></label>
                    <input type="text" name="legal_entity" class="form-control input-lg" id="InputNameLegalEntity" value="{{ old('legal_entity') }}">
                    @if($errors->has('legal_entity') && $group == 2)<p class="text-danger">{{ $errors->first('legal_entity') }}</p>@endif
                </div>
                <div class="form-group @if($errors->has('EDRPOUcode') && $group == 2)has-error @endif">
                    <label for="InputEDRPOUcode">Введіть код ЄДРПОУ  <span class="label-required">*</span></label>
                    <input type="text" name="EDRPOUcode" class="form-control input-lg" id="InputEDRPOUcode" placeholder="99999999" value="{{ old('EDRPOUcode') }}">
                    @if($errors->has('EDRPOUcode') && $group == 2)<p class="text-danger">{{ $errors->first('EDRPOUcode') }}</p>@endif
                </div>
                <div class="form-group @if($errors->has('LastName') && $group == 2)has-error @endif">
                    <label for="InputLastName">Введіть прізвище представника <span class="label-required">*</span></label>
                    <input type="text" name="LastName" class="form-control input-lg" id="InputLastName" placeholder="Іванов" value="{{ old('LastName') }}">
                    @if($errors->has('LastName') && $group == 2)<p class="text-danger">{{ $errors->first('LastName') }}</p>@endif
                </div>
                <div class="form-group @if($errors->has('FirstName') && $group == 2)has-error @endif">
                    <label for="InputFirstName">Введіть ім'я представника  <span class="label-required">*</span></label>
                    <input type="text" name="FirstName" class="form-control input-lg" id="InputFirstName" placeholder="Іван" value="{{ old('FirstName') }}">
                    @if($errors->has('FirstName') && $group == 2)<p class="text-danger">{{ $errors->first('FirstName') }}</p>@endif
                </div>
                <div class="form-group @if($errors->has('MiddleName') && $group == 2)has-error @endif">
                    <label for="InputMiddleName">Введіть по-батькові представника <span class="label-required">*</span></label>
                    <input type="text" name="MiddleName" class="form-control input-lg" id="InputMiddleName" placeholder="Іванович" value="{{ old('MiddleName') }}">
                    @if($errors->has('MiddleName') && $group == 2)<p class="text-danger">{{ $errors->first('MiddleName') }}</p>@endif
                </div>
                <div class="form-group @if($errors->has('email') && $group == 2)has-error @endif">
                    <label for="InputEmail">E-mail <span class="label-required">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control input-lg" id="InputEmail" placeholder="ivan@yandex.ua">
                    <p class="help-block">Ваш E-mail буде використовуватися в якості логіна для входу в систему.</p>
                    @if($errors->has('email') && $group == 2)<p class="text-danger">{{ $errors->first('email') }}</p>@endif
                </div>
                <div class="form-group @if($errors->has('phone') && $group == 2)has-error @endif">
                    <label for="InputPhone">Введіть номер телефону <span class="label-required">*</span></label>
                    <input type="text" name="phone" class="form-control input-lg" id="InputPhone" placeholder="+38099-999-99-99" value="{{ old('phone') }}">
                    @if($errors->has('phone') && $group == 2)<p class="text-danger">{{ $errors->first('phone') }}</p>@endif
                </div>
                <div class="form-group  @if($errors->has('password') && $group == 2)has-error @endif">
                    <label for="InputPassword">Введіть пароль <span class="label-required">*</span></label>
                    <input type="password" name="password" class="form-control input-lg" id="InputPassword" placeholder="••••••••••••">
                    @if($errors->has('password') && $group == 2)<p class="text-danger">{{ $errors->first('password') }}</p>@endif
                </div>
                <div class="form-group">
                    <label for="InputPasswordConfirmed">Введіть пароль повторно <span class="label-required">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control input-lg" id="InputPasswordConfirmed" placeholder="••••••••••••">
                    <p class="help-block">Пароль повинен містити не менше 6 символів.</p>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox"> Я погоджуюсь з правилами
                    </label>
                </div>
                <button type="submit" class="btn btn-primary btn-lg">Зареєструватися</button>
                <p class="pull-right"><span class="label-required">*</span> — обов'язкові поля.</p>
            </form>

        </div>

    </div>
@endsection