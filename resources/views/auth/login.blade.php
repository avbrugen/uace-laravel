<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Вход</title>
    <link rel="stylesheet" href="{{asset('//uace.com.ua/static/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="//uace.com.ua/static/css/auctions.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
</head>
<body>

<div class="container">

    <form method="POST" action="/auth/login" class="form-signin" role="form">
        @if(Session::has('status'))<div class="alert alert-success" style="margin-bottom: 20px;">{{ Session::get('status') }}</div>@endif

        <h2 class="form-signin-heading">Авторизація</h2>
        <input type="email" class="form-control" placeholder="E-mail" required autofocus name="email" value="{{ old('email') }}">
        <input type="password" class="form-control" placeholder="Пароль" required name="password">
        <label class="checkbox">
            <input type="checkbox" value="remember-me" name="remember"> Запам'ятати мене
        </label>
        <input type="hidden" name="_token" value="{{csrf_token()}}"/>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Увійти</button>
        <div class="text-center" style="padding: 10px 0"><a href="#" data-toggle="modal" data-target="#ResetPassword">Забули пароль?</a></div>
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


<!-- Reset Password Modal -->
<div class="modal fade" id="ResetPassword" tabindex="1" role="dialog" aria-labelledby="ResetPasswordLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="ResetPasswordModalLabel">Відновлення пароля</h4>
            </div>
            <div class="modal-body">


                <form method="POST" action="/password/email">
                    {!! csrf_field() !!}

                    <div class="form-group">
                        <label for="Email">Введіть E-mail</label>
                        <input type="email" name="email" class="form-control input-lg" id="Email" placeholder="ivan@yandex.ua" value="{{ old('email') }}">
                    </div>

                    <div>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Відновити</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
</div>

<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter33833349 = new Ya.Metrika({
                    id:33833349,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/33833349" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

</body>
</html>


