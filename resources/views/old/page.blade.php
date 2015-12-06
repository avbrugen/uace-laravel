@extends('layouts')

@section('title'){{$page->title}} - @lang('theme.sitename_title')@endsection

@section('content')
    {!! $page->contant !!}
@endsection