@extends('dashboard.layout')

@section('head')<script src="{{asset('static/js/jquery.liTranslit.js')}}"></script>@endsection

@section('content')

    <div class="container-fluid">
        <h2 class="sub-header">Добавить новость</h2>
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
                <label for="InputAnonce">Анонс новости</label>
                <textarea name="anonce" id="InputAnonce" rows="10" cols="80" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label for="editor">Полный текст новости</label>
                <textarea name="editor" id="editor" rows="10" cols="80"></textarea>
            </div>
            <div class="form-group">
                <label for="InputFile">Миниатюра новости</label>
                <input type="file" id="InputFile" name="preview">
                <p class="help-block">Выберите превью для новости. </p>
            </div>

            <script>
                CKEDITOR.replace( 'editor' );
                CKEDITOR.config.filebrowserUploadUrl = '/uploader';
                CKEDITOR.config.height = '500px';
                CKEDITOR.config.allowedContent = true;
            </script>

            <button type="submit" class="btn btn-primary btn-lg">Опубликовать</button>
        </form>

    </div>

    <script>
        $('.title_text').liTranslit({
            elAlias: $('.title_translit')
        });
    </script>

@endsection