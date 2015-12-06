@extends('dashboard.layout')

@section('content')

    <div class="container-fluid">
        <h2 class="sub-header">Сторінки</h2>

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Заголовок</th>
                <th>Опції</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pages as $page)

                <tr>
                    <td>{{$page->id}}</td>
                    <td>{{$page->title}}</td>
                    <td><a href="{{asset('/'. $page->slug)}}" target="_blank">Подивитися</a> <a href="{{action('DashboardController@getEditPage', ['id' => $page->id])}}">Редагувати</a></td>
                </tr>
            @endforeach


            </tbody>
        </table>


    </div>
    <div class="container-fluid">
        <h2 class="sub-header">Записи</h2>

        <form class="row" role="search" method="get" action="{{action('DashboardController@searchPost')}}" style="margin-top: 30px;margin-bottom: 20px">
            <div class="col-xs-5 form-group">
                <input type="text" name="s" class="form-control" placeholder="Пошук...">
            </div>

            <div class="col-xs-5 form-group">
                <select name="category" class="form-control">
                    @foreach(trans('theme.news_categories') as $k => $c)
                        <option value="{{ $k }}">{{ $c }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-xs-2 form-group">
                <button type="submit" class="btn btn-warning">Показати результати</button>
            </div>

        </form>

        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Заголовок</th>
                <th>Категорія</th>
                <th>Короткий опис</th>
                <th>Опції</th>
            </tr>
            </thead>
            <tbody>
            @foreach($news as $article)

                <tr>
                    <td>{{$article->id}}</td>
                    <td>{{$article->title}}</td>
                    <td>{{trans('theme.news_categories.'.$article->category)}}</td>
                    <td>{{$article->anonce}}</td>
                    <td><a href="{{action('NewsController@getArticle', ['slug' => $article->slug])}}">Подивитися</a>
                        <a href="{{action('DashboardController@getEditNews', ['id' => $article->id])}}">Редагувати</a>
                        <a href="{{action('DashboardController@getDeleteNews', ['id' => $article->id])}}" class="delete_article" data-id="{{ $article->id }}">Видалити</a>
                    </td>
                </tr>
            @endforeach


            </tbody>
        </table>

        <?php echo $news->appends($_GET)->setPath('dashboard/news')->render();  ?>

        <script>
            $('.delete_article').on('click', function(){
                if (confirm("Ви підтверджуєте видалення?")) {
                    return true;
                } else {
                    return false;
                }
            });

        </script>


    </div>

@endsection