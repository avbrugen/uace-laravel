@extends('auction.layout')
@section('title')Стати учасником аукціону №{{ $auction_id }} - @lang('theme.sitename_title')@endsection

@section('content')

    <div class="container">
        <div class="auction_page_title">Стати учасником аукціону №{{ $auction_id }}</div>
        <div class="register_container" style="width: 820px">

            <ul id="bidders-tabs" class="nav nav-tabs">
                <li class="active"><a href="#section1" data-toggle="tab">Інформація про особу</a></li>
                <li><a href="#section2" data-toggle="tab">Банківські реквізити</a></li>
                <li><a href="#section3" data-toggle="tab">Паспортні дані, адреса</a></li>
                <li><a href="#section4" data-toggle="tab">Додатки</a></li>
            </ul>

            <form role="form" method="post" enctype="multipart/form-data">
            <div class="tab-content" style="padding: 30px 0;">
                <div class="tab-pane active" id="section1" style="padding: 0 120px">

                    {!! csrf_field() !!}

                    <div class="form-group @if($errors->has('last_name'))has-error @endif">
                        <label for="last_name">Прізвище <span class="label-required">*</span></label>
                        <input type="text" name="last_name" class="form-control input-lg" id="last_name" placeholder="Іванов" value="@if($User['last_name']){{ $User['last_name'] }}@else{{ old('last_name') }}@endif">
                        @if($errors->has('last_name'))<p class="text-danger">{{ $errors->first('last_name') }}</p>@endif
                    </div>
                    <div class="form-group @if($errors->has('first_name'))has-error @endif">
                        <label for="first_name">Ім’я <span class="label-required">*</span></label>
                        <input type="text" name="first_name" class="form-control input-lg" id="first_name" placeholder="Іван" value="@if($User['first_name']){{ $User['first_name'] }}@else{{ old('first_name') }}@endif">
                        @if($errors->has('first_name'))<p class="text-danger">{{ $errors->first('first_name') }}</p>@endif
                    </div>
                    <div class="form-group @if($errors->has('middle_name'))has-error @endif">
                        <label for="middle_name">По батькові <span class="label-required">*</span></label>
                        <input type="text" name="middle_name" class="form-control input-lg" id="middle_name" placeholder="Іванович" value="@if($User['middle_name']){{ $User['middle_name'] }}@else{{ old('middle_name') }}@endif">
                        @if($errors->has('middle_name'))<p class="text-danger">{{ $errors->first('middle_name') }}</p>@endif
                    </div>

                    @if(!$User['email'])
                        <div class="form-group @if($errors->has('email'))has-error @endif">
                            <label for="email">E-mail <span class="label-required">*</span></label>
                            <input type="text" name="email" class="form-control input-lg" id="email" placeholder="ivan@yandex.ua">
                            @if($errors->has('email'))<p class="text-danger">{{ $errors->first('email') }}</p>@endif
                        </div>
                    @endif

                    <div class="form-group @if($errors->has('phone'))has-error @endif">
                        <label for="phone">Телефон <span class="label-required">*</span></label>
                        <input type="text" name="phone" class="form-control input-lg" id="phone" placeholder="+38 (099) 999-99-99" value="@if($User['phone']){{ $User['phone'] }}@else{{ old('phone') }}@endif">
                        @if($errors->has('phone'))<p class="text-danger">{{ $errors->first('phone') }}</p>@endif
                    </div>
                    <div class="form-group">
                        <label for="dop_phone">Додаткові номери</label>
                        <input type="text" name="dop_phone" class="form-control input-lg" id="dop_phone" placeholder="">
                    </div>
                    <span class="label-required">*</span> — обов'язкові поля.
                    <button type="button" aria-expanded="true" class="btn btn-primary btn-lg pull-right tab-next">Далі</button>

                </div>
                <div class="tab-pane" id="section2" style="padding: 0 120px">

                    <div class="form-group">
                        <label for="FirstName">Тип оплати <span class="label-required">*</span></label>
                        <select name="payment_type" id="pay-type" class="form-control input-lg">
                            <option value="1" @if(old('payment_type') == 1)selected @endif>Банківський рахунок</option>
                            <option value="2" @if(old('payment_type') == 2)selected @endif>Банківська картка</option>
                        </select>
                    </div>

                    <div class="form-group @if($errors->has('bank_name'))has-error @endif">
                        <label for="bank_name">Назва банку <span class="label-required">*</span></label>
                        <input type="text" name="bank_name" class="form-control input-lg" id="bank_name" placeholder="" value="{{ old('bank_name') }}">
                        @if($errors->has('bank_name'))<p class="text-danger">{{ $errors->first('bank_name') }}</p>@endif
                    </div>

                    <div class="payment-card form-group @if($errors->has('payment_card'))has-error @endif" style="display: none;">
                        <label for="payment_card">Номер картки отримувача <span class="label-required">*</span></label>
                        <input type="text" name="payment_card" class="form-control input-lg" id="payment_card" placeholder="" value="{{ old('payment_card') }}">
                        @if($errors->has('payment_card'))<p class="text-danger">{{ $errors->first('payment_card') }}</p>@endif
                    </div>

                    <div class="payment-card form-group @if($errors->has('payment_code'))has-error @endif" style="display: none;">
                        <label for="payment_code">Код отримувача <span class="label-required">*</span></label>
                        <input type="text" name="payment_code" class="form-control input-lg" id="payment_code" placeholder="" value="{{ old('payment_code') }}">
                        @if($errors->has('payment_code'))<p class="text-danger">{{ $errors->first('payment_code') }}</p>@endif
                    </div>

                    <div class="form-group @if($errors->has('account_number'))has-error @endif">
                        <label for="account_number">Номер рахунку <span class="label-required">*</span></label>
                        <input type="text" name="account_number" class="form-control input-lg" id="account_number" placeholder="" value="{{ old('account_number') }}">
                        @if($errors->has('account_number'))<p class="text-danger">{{ $errors->first('account_number') }}</p>@endif
                    </div>

                    <div class="form-group @if($errors->has('bank_code'))has-error @endif">
                        <label for="bank_code">Код банку (МФО) <span class="label-required">*</span></label>
                        <input type="text" name="bank_code" class="form-control input-lg" id="bank_code" placeholder="" value="{{ old('bank_code') }}">
                        @if($errors->has('bank_code'))<p class="text-danger">{{ $errors->first('bank_code') }}</p>@endif
                    </div>

                    <div class="row">
                        <div class="col-xs-3">
                            <button type="button" aria-expanded="true" class="btn btn-primary btn-lg tab-previous">Назад</button>
                        </div>
                        <div class="col-xs-6 text-center" style="line-height: 45px">
                            <span class="label-required">*</span> — обов'язкові поля.
                        </div>
                        <div class="col-xs-3">
                            <button type="button" aria-expanded="true" class="btn btn-primary btn-lg pull-right tab-next">Далі</button>
                        </div>
                    </div>

                </div>
                <div class="tab-pane" id="section3" style="padding: 0 120px">
                    <div class="row">

                        <div class="col-xs-2">
                            <div class="form-group @if($errors->has('passport_series'))has-error @endif">
                                <label for="passport_series">Серія <span class="label-required">*</span></label>
                                <input type="text" name="passport_series" class="form-control input-lg" id="passport_series" placeholder="" value="{{ old('passport_series') }}">
                            </div>
                        </div>

                        <div class="col-xs-5">
                            <div class="form-group @if($errors->has('passport_number'))has-error @endif">
                                <label for="passport_number">Номер <span class="label-required">*</span></label>
                                <input type="text" name="passport_number" class="form-control input-lg" id="passport_number" placeholder="" value="{{ old('passport_number') }}">
                            </div>
                        </div>

                        <div class="col-xs-5">
                            <div class="form-group @if($errors->has('passport_issue'))has-error @endif">
                                <label for="passport_issue">Дата видачі <span class="label-required">*</span></label>
                                <input type="date" name="passport_issue" class="form-control input-lg" id="passport_issue" placeholder="" value="{{ old('passport_issue') }}">
                            </div>
                        </div>

                        <div class="col-xs-7">
                            <div class="form-group @if($errors->has('passport_issued'))has-error @endif">
                                <label for="passport_issued">Ким видано <span class="label-required">*</span></label>
                                <input type="text" name="passport_issued" class="form-control input-lg" id="passport_issued" placeholder="" value="{{ old('passport_issued') }}">
                                @if($errors->has('passport_issued'))<p class="text-danger">{{ $errors->first('passport_issued') }}</p>@endif
                            </div>
                        </div>

                        <div class="col-xs-5">
                            <div class="form-group @if($errors->has('passport_inn'))has-error @endif">
                                <label for="passport_inn">ІПН <span class="label-required">*</span></label>
                                <input type="text" name="passport_inn" class="form-control input-lg" id="passport_inn" placeholder="" value="{{ old('passport_inn') }}">
                                @if($errors->has('passport_inn'))<p class="text-danger">{{ $errors->first('passport_inn') }}</p>@endif
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="inn_waiver"> У мене відмова від ідентифікаційного коду
                                </label>
                            </div>
                        </div>

                    </div>

                    <h4>Адреса проживання</h4><hr>

                    <div class="row">

                        <div class="col-xs-4">
                            <div class="form-group @if($errors->has('adress_postcode'))has-error @endif">
                                <label for="adress_postcode">Поштовий індекс <span class="label-required">*</span></label>
                                <input type="text" name="adress_postcode" class="form-control input-lg" id="adress_postcode" placeholder="" value="{{ old('adress_postcode') }}">
                                @if($errors->has('adress_postcode'))<p class="text-danger">{{ $errors->first('adress_postcode') }}</p>@endif
                            </div>
                        </div>

                        <div class="col-xs-5">
                            <div class="form-group @if($errors->has('adress_region'))has-error @endif">
                                <label for="adress_region">Область <span class="label-required">*</span></label>
                                <select name="adress_region" class="form-control input-lg">
                                    @foreach(trans('theme.regions') as $key => $region)
                                        <option value="{{ $key }}" @if(old('adress_region') == $key) selected @endif>{{ $region }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-3">
                            <div class="form-group @if($errors->has('adress_city'))has-error @endif">
                                <label for="adress_city">Місто <span class="label-required">*</span></label>
                                <input type="text" name="adress_city" class="form-control input-lg" id="adress_city" placeholder="" value="{{ old('adress_city') }}">
                            </div>
                        </div>

                        <div class="col-xs-12">
                            <div class="form-group @if($errors->has('adress_full'))has-error @endif">
                                <label for="adress_full">Адреса <span class="label-required">*</span></label>
                                <input type="text" name="adress_full" class="form-control input-lg" id="adress_full" placeholder="" value="{{ old('adress_full') }}">
                                @if($errors->has('adress_full'))<p class="text-danger">{{ $errors->first('adress_full') }}</p>@endif
                            </div>
                        </div>

                        <div class="col-xs-3">
                            <button type="button" aria-expanded="true" class="btn btn-primary btn-lg tab-previous">Назад</button>
                        </div>
                        <div class="col-xs-6 text-center" style="line-height: 45px">
                            <span class="label-required">*</span> — обов'язкові поля.
                        </div>
                        <div class="col-xs-3">
                            <button type="button" aria-expanded="true" class="btn btn-primary btn-lg pull-right tab-next">Далі</button>
                        </div>

                    </div>

                </div>

                <div class="tab-pane" id="section4" style="padding: 0 50px">
                    <h4>До рееєтраційної заяви необхідно додати скановані копії наступних документів:</h4>
                    <hr>
                    <div class="form-horizontal">
                        <div class="row form-group">
                            <label class="col-sm-6 control-label" for="exampleInputFile">Квитанція про сплату гарантійного внеску</label>
                            <div class="col-sm-6">
                                <input type="file" name="file1" id="exampleInputFile">
                                @if($errors->has('file1'))<p class="text-danger">{{ $errors->first('file1') }}</p>@endif
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <label class="col-sm-6 control-label" for="exampleInputFile">Паспорт</label>
                            <div class="col-sm-6">
                                <input type="file" name="file2" id="exampleInputFile">
                                @if($errors->has('file2'))<p class="text-danger">{{ $errors->first('file2') }}</p>@endif
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <label class="col-sm-6 control-label" for="exampleInputFile">Копія виписки з ЄДР (для ФОП)</label>
                            <div class="col-sm-6">
                                <input type="file" name="file3" id="exampleInputFile">
                                @if($errors->has('file3'))<p class="text-danger">{{ $errors->first('file3') }}</p>@endif
                            </div>
                        </div>
                        <hr>
                        <div class="row form-group">
                            <label class="col-sm-6 control-label" for="exampleInputFile">Копія індивідуального податкового номеру</label>
                            <div class="col-sm-6">
                                <input type="file" name="file4" id="exampleInputFile">
                                @if($errors->has('file4'))<p class="text-danger">{{ $errors->first('file4') }}</p>@endif
                            </div>
                        </div>

                        <div style="padding-top: 40px">
                            <div class="col-xs-3">
                                <button type="button" aria-expanded="true" class="btn btn-primary btn-lg tab-previous">Назад</button>
                            </div>
                            <div class="col-xs-6 text-center" style="line-height: 45px">
                                <span class="label-required">*</span> — обов'язкові поля.
                            </div>
                            <div class="col-xs-3">
                                <button type="submit" class="btn btn-success btn-lg pull-right">Відправити</button>
                            </div>
                        </div>



                    </div>

                </div>

            </div>
            </form>

        </div>
    </div>

    <script>
        $('.tab-next').click(function(){
            $('#bidders-tabs > .active').next('li').find('a').trigger('click');
        });

        $('.tab-previous').click(function(){
            $('#bidders-tabs > .active').prev('li').find('a').trigger('click');
        });

        @if(old('payment_type') == 2)
         $('.payment-card').show();
        @endif

        $('#pay-type').on('change', function() {
            $('.payment-card').hide();
            if($(this).val() == 2)
            {
                $('.payment-card').show();
            }
        });

    </script>

@endsection