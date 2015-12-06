<div class="navbar navbar-inverse" role="navigation" style="margin-bottom: 0px;-webkit-border-radius: 0;-moz-border-radius: 0;border-radius: 0;">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/auction">UACE</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/dashboard">Админ-панель</a></li>
                    <li><a href="{{action('DashboardController@getAddNews')}}">Добавить новость</a></li>
                    <!--<li><a href="#">Profile</a></li>-->
                    <li><a href="/auth/logout">Выход</a></li>
                </ul>
                <!--<form class="navbar-form navbar-right">
                    <input type="text" class="form-control" placeholder="Search...">
                </form>-->
            </div>
        </div>
</div>