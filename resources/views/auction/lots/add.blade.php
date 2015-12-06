@extends('auction.layout')
@section('title')Подати оголошення - @lang('theme.sitename_title')@endsection

@section('search_param')
id="search" action="/auction/search" method="get"
@endsection

@section('head')
    <script src="//uace.com.ua/static/js/dropzone.js"></script>
    <script src="//uace.com.ua/static/js/moment-with-locales.min.js"></script>
    <script src="//uace.com.ua/static/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="//uace.com.ua/static/css/dropzone.css">
    <link rel="stylesheet" href="//uace.com.ua/static/css/bootstrap-datetimepicker.min.css">

@endsection
@section('content')
    <div class="container">

        <?php
        $activeCategory = Session::get('activeCategory');
        ?>

    @include('auction.lots.addform')

    </div>
@endsection