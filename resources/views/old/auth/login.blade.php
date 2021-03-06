<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link rel="stylesheet" href="{{asset('static/css/bootstrap.min.css')}}">
</head>
<body>

<div class="container">

    <form method="POST" action="/auth/login" class="form-signin" role="form">
        {!! csrf_field() !!}
        <h2 class="form-signin-heading">Авторизация</h2>
        <input type="email" class="form-control" placeholder="E-mail" required autofocus name="email" value="{{ old('email') }}">
        <input type="password" class="form-control" placeholder="Пароль" required name="password">
        <label class="checkbox">
            <input type="checkbox" value="remember-me" name="remember"> Запомнить меня
        </label>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
    </form>

</div> <!-- /container -->


<style>
    body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #eee;
    }

    .form-signin {
        max-width: 330px;
        padding: 15px;
        margin: 0 auto;
    }
    .form-signin .form-signin-heading,
    .form-signin .checkbox {
        margin-bottom: 10px;
    }
    .form-signin .checkbox {
        font-weight: normal;
        margin-left: 20px;
    }
    .form-signin .form-control {
        position: relative;
        height: auto;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
        padding: 10px;
        font-size: 16px;
    }
    .form-signin .form-control:focus {
        z-index: 2;
    }
    .form-signin input[type="email"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }
    .form-signin input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
</style>

</body>
</html>


