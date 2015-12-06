@extends('dashboard.layout')

@section('content')

    <div class="container-fluid">
            <h2 class="sub-header">Новости</h2>


        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Заголовок</th>
                <th>Краткое описание</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($articles as $article)

                <tr>
                    <td>{{$article->id}}</td>
                    <td>{{$article->title}}</td>
                    <td>{{$article->anonce}}</td>
                    <td><a href="{{action('NewsController@getArticle', ['slug' => $article->slug])}}">Посмотреть</a>
                        <a href="{{action('DashboardController@getEditNews', ['id' => $article->id])}}">Редактировать</a>
                        <a href="{{action('DashboardController@getDeleteNews', ['id' => $article->id])}}" class="delete_article" data-id="{{ $article->id }}">Удалить</a>
                    </td>
                </tr>
            @endforeach


            </tbody>
        </table>

        <script>
            $('.delete_article').on('click', function(){
                if (confirm("Вы подтверждаете удаление?")) {
                    return true;
                } else {
                    return false;
                }
            });

        </script>


    </div>

@endsection