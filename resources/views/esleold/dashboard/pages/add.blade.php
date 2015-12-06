@extends('dashboard.layout')

@section('content')

    <div class="container-fluid">
        <h2 class="sub-header" style="margin-bottom: 30px">Добавить страницу</h2>

    <form role="form" method="post" action>
        {!! csrf_field() !!}
        <div class="form-group">
            <label for="InputTitle">Заголовок</label>
            <input name="title" type="text" class="form-control input-lg" id="InputTitle" placeholder="">
        </div>
        <div class="form-group">
            <label for="InputURL">URL</label>
            <input name="slug" type="text" class="form-control" id="InputURL" placeholder="">
        </div>
        <div class="form-group">
            <label for="editor">Контент страницы</label>
            <textarea name="editor" id="editor" rows="10" cols="80"></textarea>
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

@endsection