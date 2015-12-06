@extends('dashboard.layout')
@section('head')
    <script src="/static/js/moment-with-locales.min.js"></script>
    <script src="/static/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="/static/css/bootstrap-datetimepicker.min.css">

@endsection
@section('content')

    <style>
        .remove-image {
            position: absolute;
            top: 0px;
            right: -10px;
            z-index: 20;
            background-color: red;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 31px;
            color: #fff;
            border-radius: 100%;
            font-size: 15px;
            cursor: pointer;
        }

        .current_preview {
            position: relative;
        }
    </style>

    <div class="container-fluid">
        <h2 class="sub-header" style="margin-bottom: 30px">{{$article->title}} <small>Редагування запису</small></h2>


        <div class="row">
            <form role="form" method="post" action enctype="multipart/form-data">
            <div class="col-md-8">

                    {!! csrf_field() !!}


                    <div class="form-group">

                        <textarea name="editor" id="editor" rows="10" cols="80">{{$article->container}}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg">Оновити запис</button>

            </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="InputTitle">Заголовок</label>
                        <input name="title" type="text" class="form-control input-lg" id="InputTitle" placeholder="" value="{{$article->title}}">
                    </div>
                    <div class="form-group">
                        <label for="InputURL">URL</label>
                        <input name="slug" type="text" class="form-control" id="InputURL" placeholder="" value="{{$article->slug}}">
                    </div>

                    <div class="form-group">
                        <label>Категория</label>
                        <select class="form-control" name="category">
                            @foreach(trans('theme.news_categories') as $k => $c)
                                <option value="{{ $k }}" @if($article->category == $k) selected @endif>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>




                    <div class="form-group">
                        <label for="InputAnonce">Анонс новини</label>
                        <textarea name="anonce" id="InputAnonce" rows="5" cols="50" class="form-control">{{$article->anonce}}</textarea>
                    </div>

                    <div class="form-group">
                        <label>Дата</label>
                        <input type="text" name="date_publish" id="date_publish" class="form-control" value="{{ Carbon\Carbon::parse($article->date_publish)->format('d.m.Y H:i') }}">
                    </div>

                    <div class="form-group">
                        @if($article->preview)
                            <div class="current_preview">
                            <label for="InputFile">Мініатюра</label>
                            <div class="current_preview">
                                <img src="{{$article->preview}}" alt="" style="width: 100%;margin: 10px 0;">
                                <div class="remove-image" onclick="$('#has_preview').val(0);$('.current_preview').hide();"><i class="glyphicon glyphicon-remove"></i></div>
                            </div>
                            </div>
                            <input id="has_preview" type="hidden" @if($article->preview)value="1"@else value="0"@endif name="has_preview">
                            <label for="InputFile">Оновити мініатюру</label>
                        @else
                            <label for="InputFile">Мініатюра новини</label>
                        @endif
                        <input type="file" id="InputFile" name="preview">
                        <p class="help-block">Рекомендований розмір 500x200</p>
                    </div>

                </div>

        </form>
    </div>

    <script>
        CKEDITOR.replace( 'editor' );
        CKEDITOR.config.filebrowserUploadUrl = '/uploader';
        CKEDITOR.config.height = '550px';
        CKEDITOR.config.allowedContent = true;
        CKEDITOR.config.filebrowserBrowseUrl = '/elfinder/ckeditor';

        $(function () {
            $('#date_publish').datetimepicker({
                locale: 'ru'
            });
        });
    </script>

@endsection