@extends('auction.layout')
@section('title')Пошук - Система електронних торгів - @lang('theme.sitename_title')@endsection

@section('content')

    @include('auction.categories.list')

    <div class="container">

        <div class="search_note">Для більш швидкого вибору скористайтеся пошуком</div>

        <div class="auction_main row">
            <div class="hidden-sm hidden-xs col-md-3">
                @include('auction.categories.filters')
                @include('auction.widget-lastlots')
            </div>
            <div class="col-xs-12 col-md-9">
                <div class="row search_by_title row-min">
                    <div class="col-xs-5">
                        <div class="input">
                            <input type="text" class="form-control" @if($request && $request->title)value="{{ $request->title }}"@endif form="search" name="title" placeholder="Пошук за найменуванням">
                        </div>
                    </div>
                    <div class="col-xs-5">
                        <div class="input">
                            <select class="form-control" name="region" form="search">
                                <option value>Область</option>
                                @foreach(trans('theme.regions') as $key => $region)
                                    <option value="{{ $key }}" @if($request && $request->region == $key) selected @endif>{{ $region }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-1">
                        <button type="submit" form="search" class="btn btn-warning btn-lg"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>

                <div id="auctions">
                    <div class="row">

                        <div class="form-horizontal clearfix sortBy">

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="col-xs-12 col-md-6 col-lg-5">Відображати по:</label>
                                    <div class="col-xs-12 col-md-6 col-lg-7">
                                        <select class="form-control" name="items_per_page" form="search" onchange="this.form.submit()">
                                            <option value="10" @if($request && $request->items_per_page == 10) selected @endif>10</option>
                                            <option value="25" @if($request && $request->items_per_page == 25) selected @endif>25</option>
                                            <option value="50" @if($request && $request->items_per_page == 50) selected @endif>50</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xs-12 col-sm-6">
                                <div class="form-group">
                                    <label class="col-md-4 col-xs-12 col-lg-3 two">Сортувати:</label>
                                    <div class="col-md-8 col-xs-12 col-lg-9">
                                        <select class="form-control" name="sortBy" form="search" onchange="this.form.submit()">
                                            <option value="new" @if(isset($request) && $request->sortBy == 'new') selected @endif>Від нових до старих</option>
                                            <option value="lowcost" @if(isset($request) && $request->sortBy == 'lowcost') selected @endif>Від найдешевших до найдорожчих</option>
                                            <option value="topcost" @if(isset($request) && $request->sortBy == 'topcost') selected @endif>Від найдорожчих до найдешевших</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($auctions->count() > 0)

                            {{-- Выводим цикл лотов --}}
                            @include('auction.lots.item', ['auctions' => $auctions])

                                <div class="clearfix">
                                    <?php echo $auctions->appends($_GET)->render(); ?>
                                        Аукціони з {{ $auctions->currentPage() *  $auctions->perPage() - $auctions->perPage() + 1}} по {{ $auctions->currentPage() *  $auctions->perPage() }} із {{ $auctions->total()}} аукціонів
                                </div>
                        @else
                            Пошук не дав результатів
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>

@endsection