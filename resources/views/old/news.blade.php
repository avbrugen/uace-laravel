@extends('layouts')

@section('title')@lang('theme.news') - @lang('theme.sitename_title')@endsection

@section('content')
    @foreach($articles as $post)
        <div id="article" class="post post-{{$post->id}}">
            <h2><a href="{{action('NewsController@getArticle', ['slug' => $post->slug])}}">{{$post->title}}</a></h2>
            <div class="image"><img src="{{$post->preview}}" alt="{{$post->title}}"></div>
            <p>{{$post->anonce}}</p>
        </div>
    @endforeach
@endsection