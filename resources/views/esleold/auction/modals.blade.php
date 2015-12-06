@if(Session::get('addsuccess'))
    <script>
        $(document).ready(function () {
            $('#AddSuccess').modal();
        })
    </script>

    <div class="modal fade" id="AddSuccess" tabindex="-1" role="dialog" aria-labelledby="LoginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    Заявка успішно надіслана адміністратору. Після перевірки ми опублікуємо ваш лот, або зв'яжемося за контактами вказаними в профілі для уточнення даних.
                </div>
            </div>
        </div>
    </div>
@endif

@if(Session::has('status') or Session::has('reset_password_error') or Session::has('success_bidders_add'))
    <script>
        $(document).ready(function () {
            $('#StatusModal').modal();
        })
    </script>

    <div class="modal fade" id="StatusModal" tabindex="-1" role="dialog" aria-labelledby="StatusModal" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    {{ Session::get('status') }}
                    {{ Session::get('reset_password_error') }}
                    {{ Session::get('success_bidders_add') }}
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(!Auth::check())
            <!-- Login Modal -->
    <div class="modal fade" id="LoginModal" tabindex="1" role="dialog" aria-labelledby="LoginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Авторизація</h4>
                </div>
                <div class="modal-body">
                    <form method="POST" action="/auth/login" class="form-signin" role="form">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <input type="email" class="form-control input-lg" placeholder="E-mail" required autofocus name="email" value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control input-lg" placeholder="Пароль" required name="password">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="remember-me" name="remember"> Запам'ятати мене
                            </label>
                        </div>
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
                        <div class="row">
                            <div class="col-xs-6"><p style="text-align: center;padding-top: 15px"><a href="/auctions/register">Зареєструватись</a></p></div>
                            <div class="col-xs-6"><p style="text-align: left;padding-top: 15px"><a href="#"  data-toggle="modal" data-target="#ResetPassword" onclick="$('#LoginModal').modal('hide')">Забули пароль?</a></p>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

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

@else

    <style>
        nav#nav-auctions .navbar-search {
            width: 420px;
        }
    </style>

@endif