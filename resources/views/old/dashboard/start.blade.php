@extends('dashboard.layout')

@section('content')

    <div class="container-fluid">
        <h2 class="sub-header">Страницы</h2>

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Заголовок</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pages as $page)

                <tr>
                    <td>{{$page->id}}</td>
                    <td>{{$page->title}}</td>
                    <td><a href="{{asset('/'. $page->slug)}}" target="_blank">Посмотреть</a> <a href="{{action('DashboardController@getEditPage', ['id' => $page->id])}}">Редактировать</a></td>
                </tr>
            @endforeach


            </tbody>
        </table>


    </div>
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
            @foreach($news as $article)

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