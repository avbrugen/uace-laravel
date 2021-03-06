@extends('dashboard.layout')

@section('content')

    <div class="container-fluid">
            <h2 class="sub-header">Пошук по записах</h2>

        <form class="row" role="search" method="get" action="{{action('DashboardController@searchPost')}}" style="margin-top: 30px;margin-bottom: 20px">
            <div class="col-xs-5 form-group">
                <input type="text" name="s" class="form-control" placeholder="Пошук..." @if(isset($request) && $request->s) value="{{ $request->s }}" @endif>
            </div>

            <div class="col-xs-5 form-group">
                <select name="category" class="form-control">
                    @foreach(trans('theme.news_categories') as $k => $c)
                        <option value="{{ $k }}" @if(isset($request) && $request->category == $k) selected @endif>{{ $c }}</option>
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
            @foreach($articles as $article)

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

        <?php echo $articles->appends($_GET)->render(); ?>

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