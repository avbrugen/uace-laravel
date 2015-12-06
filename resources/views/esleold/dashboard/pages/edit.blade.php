@extends('dashboard.layout')

@section('content')

    <div class="container-fluid">
        <h2 class="sub-header">{{$page->title}} <small>Редактирование страницы</small></h2>

        <form role="form" method="post" action>
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="InputTitle">Заголовок</label>
                <input name="title" type="text" class="form-control" id="InputTitle" value="{{$page->title}}">
            </div>
            <div class="form-group">
                <label for="InputURL">URL</label>
                <input name="slug" type="text" class="form-control" id="InputURL" value="{{$page->slug}}">
            </div>
            <div class="form-group">
                <label for="editor">Контент страницы</label>
                <textarea name="editor" id="editor" rows="10" cols="80">{{$page->contant}}</textarea>
            </div>

            <script>
                CKEDITOR.replace( 'editor' );
                CKEDITOR.config.filebrowserUploadUrl = '/uploader';
                CKEDITOR.config.height = '500px';
                CKEDITOR.config.allowedContent = true;
            </script>

            <button type="submit" class="btn btn-primary btn-lg">Применить изменения</button>
        </form>

    </div>

@endsection