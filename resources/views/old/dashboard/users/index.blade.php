@extends('dashboard.layout')

@section('content')

    <div class="container-fluid">
        <h2 class="sub-header">Пользователи</h2>


        <table class="table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Отвество</th>
                <th>E-mail</th>
                <th>Телефон</th>
                <th>Группа</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)

                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->first_name}}</td>
                    <td>{{$user->last_name}}</td>
                    <td>{{$user->middle_name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone}}</td>
                    <td>@if($user->user_group == 2) Юридическое лицо @else Физическое лицо @endif</td>
                </tr>
            @endforeach


            </tbody>
        </table>

        <div class="row">
        <form class="navbar-form" role="search" method="get" action="{{action('DashboardController@searchUsers')}}">
            <div class="form-group">
                <input type="text" name="s" class="form-control input-lg" placeholder="Поиск по пользователям...">
            </div>
        </form>
        </div>

    </div>

@endsection