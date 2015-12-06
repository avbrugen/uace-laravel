@extends('layouts')

@section('title'){{$post->title}} - {{ trans('theme.news_categories.'.$post->category) }} - @lang('theme.sitename_title')@endsection

@section('content')
        <div id="article" class="post post-{{$post->id}}">
            <h2><a href="{{action('NewsController@getArticle', ['slug' => $post->slug])}}">{{$post->title}}</a></h2>
			@if(Carbon\Carbon::parse($post->date_publish)->format('d.m.Y H:i') != '30.11.-0001 00:00')<p style="color: #949494">{{ Carbon\Carbon::parse($post->date_publish)->format('d.m.Y H:i') }}</p>@endif
            @if($post->preview)<div class="image"><img src="{{$post->preview}}" alt="{{$post->title}}"></div>@endif
            <div class="content">{!! $post->container !!}</div>
        </div>
@endsection