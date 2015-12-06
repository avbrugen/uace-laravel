@extends('dashboard.layout')

@section('content')

    <div class="container-fluid">
        <h2 class="sub-header">Користувачі</h2>

        <form class="row" role="search" method="get" action="{{action('DashboardController@searchUsers')}}" style="margin-top: 30px;margin-bottom: 20px">
            <div class="col-xs-5 form-group">
                <input type="text" name="s" class="form-control" placeholder="Пошук по користувачам...">
            </div>

            <div class="col-xs-5 form-group">
                <select name="group" class="form-control">
                    <option value="1">Фізична особа</option>
                    <option value="2">Юридична особа</option>
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
                <th>Ім'я</th>
                <th>Прізвище</th>
                <th>По батькові</th>
                <th>E-mail</th>
                <th>Телефон</th>
                <th>Група</th>
                <th>Останній вхід</th>
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
                    <td>@if($user->user_group == 2) Юридична особа @else Фізична особа @endif</td>
                    <td>{{$user->last_login}}</td>
                </tr>
            @endforeach


            </tbody>
        </table>


    </div>

@endsection