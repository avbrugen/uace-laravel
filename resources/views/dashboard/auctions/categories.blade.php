@extends('dashboard.layout')
@section('content')

    <div class="container-fluid">
        <h2 class="sub-header">Категорії аукціонів</h2>

        @if(Session::has('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
<ul>
    @foreach($cats as $category)
        <li>{{ $category->name }} <a class="category_edit" href="#" data-category-id="{{ $category->id }}" data-toggle="modal" data-target="#modalEdit">Редагувати</a></li>
        <ul>
            @foreach($category->getDescendants() as $par)
                <li>{{ $par->name }} <a class="category_edit" href="#" data-category-id="{{ $par->id }}" data-toggle="modal" data-target="#modalEdit">Редагувати</a></li>
            @endforeach
        </ul>
    @endforeach
</ul>

        <script>
            $('.category_edit').on('click', function(e)
            {
                var _this = $(this);
                $.ajax({
                   url: '/dashboard/auctions/categories/edit-'+ _this.data('category-id'),
                   dataType : "html",
                   success: function (data, textStatus) {
                       $('#ajaxEdit').html(data);
                   }
                });
            });
        </script>

        <!-- Modal -->
        <div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" id="ajaxEdit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Название модали</h4>
                    </div>
                    <div class="modal-body">
                        ...
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                        <button type="button" class="btn btn-primary">Сохранить изменения</button>
                    </div>
                </div>
            </div>
        </div>



        <button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#addCategory">
            Добавить категорию
        </button>
    </div>

<!-- Добавить категорию -->
<div class="modal fade" id="addCategory" tabindex="2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form role="form" id="addCategoryForm" action="{{ action('CategoriesController@postAddCategory') }}" method="post" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Добавление категории</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="InputTitile">Название</label>
                        <input type="text" name="name" class="form-control input-lg" id="InputTitile" placeholder="">
                    </div>

                    <div class="form-group">
                    <label for="InputTitile">Основная категория</label>
                    <select class="form-control input-lg" name="parent">
                        <option value="0">Не выбрано</option>
                        @foreach($cats as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            </form>
        </div>
    </div>
</div>




@endsection