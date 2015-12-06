@extends('dashboard.layout')

@section('head')
    <script src="{{asset('static/js/jquery.liTranslit.js')}}"></script>
    <script src="/static/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="/static/css/bootstrap-datetimepicker.min.css">
@endsection

@section('content')

    <div class="container-fluid">
        <h2 class="sub-header">Додати запис</h2>
        <form role="form" method="post" action enctype="multipart/form-data">
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="InputTitle">Заголовок</label>
                <input name="title" type="text" class="form-control title_text" id="InputTitle" placeholder="">
            </div>
            <div class="form-group">
                <label for="InputURL">URL</label>
                <input name="slug" type="text" class="form-control title_translit" id="InputURL" placeholder="">
            </div>
            <div class="form-group">
                <label>Категорія</label>
                <select class="form-control" name="category">
                    @foreach(trans('theme.news_categories') as $k => $c)
                        <option value="{{ $k }}">{{ $c }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="InputAnonce">Анонс записи</label>
                <textarea name="anonce" id="InputAnonce" rows="10" cols="80" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="editor">Повний текст</label>
                <textarea name="editor" id="editor" rows="10" cols="80"></textarea>
            </div>

            <div class="form-group">
                <label>Дата</label>
                <input type="text" name="date_publish" id="date_publish" class="form-control" value="{{ Carbon\Carbon::parse(\Carbon\Carbon::now())->format('d.m.Y H:i') }}">
            </div>

            <div class="form-group">
                <label for="InputFile">Мініатюра</label>
                <input type="file" id="InputFile" name="preview">
                <p class="help-block">Виберіть превью для запису (не обов'язково).</p>
            </div>

            <script>
                CKEDITOR.replace( 'editor' );
                CKEDITOR.config.filebrowserUploadUrl = '/uploader';
                CKEDITOR.config.height = '400px';
                CKEDITOR.config.allowedContent = true;
                CKEDITOR.config.basicEntities = false;
                CKEDITOR.config.fillEmptyBlocks = false;
                CKEDITOR.config.tabSpaces = 0;
                CKEDITOR.config.forcePasteAsPlainText = true;
                CKEDITOR.config.filebrowserBrowseUrl = '/elfinder/ckeditor';

                $(function () {
                    $('#date_publish').datetimepicker({
                        locale: 'ru'
                    });
                });
            </script>

            <button type="submit" class="btn btn-primary btn-lg">Опублікувати</button>
        </form>

    </div>

    <script>
        $('.title_text').liTranslit({
            elAlias: $('.title_translit')
        });
    </script>

@endsection