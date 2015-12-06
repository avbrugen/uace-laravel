@extends('auction.layout')
@section('title')Подати оголошення - @lang('theme.sitename_title')@endsection

@section('head')
    <script src="/static/js/dropzone.js"></script>
    <script src="/static/js/moment-with-locales.min.js"></script>
    <script src="/static/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="/static/css/dropzone.css">
    <link rel="stylesheet" href="/static/css/bootstrap-datetimepicker.min.css">

@endsection
@section('content')
    <div class="container">

        <?php
        $activeCategory = Session::get('activeCategory');
        ?>

    @include('auction.lots.addform')

    </div>
@endsection