<style>
    #getSeller .modal-dialog, #sellerInfo .modal-dialog   {
        margin: 12% auto;
    }

    #getSeller .modal-content, #sellerInfo .modal-content {
        border: 0;
        border-radius: 0;
    }

    #getSeller .modal-header, #sellerInfo .modal-header {
        padding: 20px 25px;
    }

    #getSeller .modal-body, #sellerInfo .modal-body {
        padding: 15px 25px 10px 25px;
        font-size: 17px;
        font-family: "PT Sans";
    }

    #getSeller .modal-footer, #sellerInfo .modal-footer {
        padding: 15px 25px;
    }

    #getSeller .modal-dialog .input-lg, #sellerInfo .modal-dialog .input-lg {
        border-radius: 0;
    }

    #getSeller .modal-dialog .btn-lg, #sellerInfo .modal-dialog .btn-lg {
        border-radius: 0;
    }

    #sellerInfo h3, #sellerInfo h3 {
        font-size: 19px;
        margin: 6px 0px;
        background: rgb(243, 243, 243) none repeat scroll 0% 0%;
        padding: 10px 20px;
    }

</style>

<div class="modal fade" id="getSeller" tabindex="-1" role="dialog" aria-labelledby="getSellerLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <form role="form" method="post" action="/forms/get-seller">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Зв'язатися з продавцем</h4>
                </div>
                <div class="modal-body">

                    <input type="hidden" name="user" value="{{ $auction->curuser[0]->id }}">
                    <div class="form-group @if($errors->has('name'))has-error @endif">
                        <label>Ваше ім'я <span class="label-required">*</span></label>
                        <input type="text" name="name" class="form-control input-lg" placeholder="Иван" value="{{{ old('name') }}}">
                    </div>
                    <div class="form-group @if($errors->has('phone'))has-error @endif">
                        <label>Ваш номер телефону <span class="label-required">*</span></label>
                        <input type="text" name="phone" class="form-control input-lg" placeholder="+38 (099) 999-99-99" value="{{{ old('phone') }}}">
                    </div>
                    <div class="form-group @if($errors->has('email'))has-error @endif">
                        <label>Ваш E-mail <span class="label-required">*</span></label>
                        <input type="email" name="email" class="form-control input-lg" placeholder="ivan@ivanov.com" value="{{{ old('email') }}}">
                    </div>

                </div>
                {!! csrf_field() !!}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Отримати контакти</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Если контроллер вернул данные о продавце - открываем модальное окно --}}
@if(Session::has('seller'))
    <?php $seller = Session::get('seller'); ?>


    <div class="modal fade" id="sellerInfo" tabindex="-1" role="dialog" aria-labelledby="sellerInfoLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Зв'язатися з продавцем</h4>
                    </div>
                    <div class="modal-body">
                        <p>Ваші дані успішно відправлено продавцю. Він зв'яжеться з вами найближчим часом.</p>
                        <p>Якщо це не відбулося, спробуйте самі зв'язатися з ним за наступними контактами:</p>
                        <address>
                            <strong>Ім'я Прізвище / Найменування</strong><br>
                            <h3>{{ $seller['first_name'] }} {{ $seller['last_name'] }}</h3>
                        </address>
                        <address>
                            <strong>E-mail</strong><br>
                            <h3>{{ $seller['email'] }}</h3>
                        </address>
                        @if($seller['phone'])
                        <address>
                            <strong>Номер телефону</strong><br>
                            <h3>{{ $seller['phone'] }}</h3>
                        </address>
                        @endif
                    </div>

            </div>
        </div>
    </div>

@endif

<script>
@if($errors->has('name') || $errors->has('phone') || $errors->has('email'))
    $(document).ready(function() {
        $('#getSeller').modal('show');
    });
@endif
@if(Session::has('seller'))
    $(document).ready(function() {
        $('#sellerInfo').modal('show');
    });
    @endif
</script>