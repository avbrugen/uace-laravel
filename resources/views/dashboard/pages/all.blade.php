@extends('dashboard.layout')

@section('content')

    <div class="container-fluid">
        <h1>Страницы</h1>


        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Заголовок</th>
                <th>URL</th>
                <th>Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pages as $page)

                <tr>
                    <td>{{$page->id}}</td>
                    <td>{{$page->title}}</td>
                    <td><a href="{{asset('/'. $page->slug)}}" target="_blank">{{asset('/'. $page->slug)}}</a></td>
                    <td><a href="{{action('DashboardController@getEditPage', ['id' => $page->id])}}">Редактировать</a></td>
                </tr>
            @endforeach


            </tbody>
        </table>


    </div>

@endsection