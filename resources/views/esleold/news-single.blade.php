@extends('layouts')

@section('title'){{$post->title}} - @lang('theme.news') - @lang('theme.sitename_title')@endsection

@section('content')
        <div id="article" class="post post-{{$post->id}}">
            <h2><a href="{{action('NewsController@getArticle', ['slug' => $post->slug])}}">{{$post->title}}</a></h2>
            @if($post->preview)<div class="image"><img src="{{$post->preview}}" alt="{{$post->title}}"></div>@endif
            <div class="content">{!! $post->container !!}</div>
        </div>
@endsection