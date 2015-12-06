@extends('dashboard.layout')

@section('content')

    <div class="container-fluid">
        <h2 class="sub-header" style="margin-bottom: 30px">{{$article->title}} <small>Редактирование новости</small></h2>


        <div class="row">
            <form role="form" method="post" action enctype="multipart/form-data">
            <div class="col-md-8">

                    {!! csrf_field() !!}


                    <div class="form-group">

                        <textarea name="editor" id="editor" rows="10" cols="80">{{$article->container}}</textarea>
                    </div>


                    <script>
                        CKEDITOR.replace( 'editor' );
                        CKEDITOR.config.filebrowserUploadUrl = '/uploader';
                        CKEDITOR.config.height = '500px';
                        CKEDITOR.config.allowedContent = true;
                    </script>

                    <button type="submit" class="btn btn-primary btn-lg">Обновить запись</button>

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
                        <label for="InputAnonce">Анонс новости</label>
                        <textarea name="anonce" id="InputAnonce" rows="5" cols="50" class="form-control">{{$article->anonce}}</textarea>
                    </div>

                    <div class="form-group">
                        @if($article->preview)
                            <label for="InputFile">Текущая миниатюра</label>
                            <div><img src="{{$article->preview}}" alt="" style="width: 100%;margin: 10px 0;"></div>
                            <label for="InputFile">Обновить миниатюру</label>
                        @else
                            <label for="InputFile">Миниатюра новости</label>
                        @endif
                        <input type="file" id="InputFile" name="preview">
                        <p class="help-block">Рекомендуемый размер 500x200</p>
                    </div>

                </div>
        </div>
        </form>


    </div>

@endsection