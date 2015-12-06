@extends('layouts')

@section('title')Оголошення - @lang('theme.sitename_title')@endsection

@section('content')
    @foreach($articles as $post)
        <div id="article" class="post post-{{$post->id}}">
            <h2><a href="{{action('NewsController@getArticle', ['slug' => $post->slug])}}#c">{{$post->title}}</a></h2>
            @if($post->preview)<div class="image"><img src="{{$post->preview}}" alt="{{$post->title}}"></div>@endif
            <p>{{$post->anonce}}</p>
        </div>
    @endforeach
@endsection