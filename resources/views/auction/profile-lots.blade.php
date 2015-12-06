@extends('auction.layout')
@section('title')Система електронних торгів - @lang('theme.sitename_title')@endsection

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
                            <input type="text" class="form-control" form="search" name="title" placeholder="Пошук за найменуванням">
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
                        <button type="submit" form="search" class="btn btn-warning"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>

                <div id="auctions">

                            <h3 style="font-family: 'PT Sans';margin-bottom: 8px;margin-top: 0px;">Лоти продавця: @if($user->legal_entity){{ $user->legal_entity }}@else{{ $user->first_name }} {{ $user->last_name }}@endif</h3>
<div class="contacts" style="margin-bottom: 30px;font-size: 16px">@if($user->phone)<i class="glyphicon glyphicon-phone" style="color: #ffcc00;"></i> {{ $user->phone }}@endif<i class="glyphicon glyphicon-envelope" style="color: #ffcc00; @if($user->phone) margin-left: 10px @endif"></i> {{ $user->email }}</div>

                    <hr>
                    <div class="row">

                        @if($lots->count() > 0)
                            {{-- Выводим цикл лотов --}}
                            @include('auction.lots.item', ['auctions' => $lots])
                        @else
                            <h4>Извините, ничего не найдено</h4>
                        @endif



                            <div class="clearfix">
                                <?php echo $lots->appends($_GET)->render(); ?>

                                @if($request && $request->items_per_page  > $lots->count() )
                                    Аукціони з {{ $lots->currentPage() *  $lots->perPage() - $lots->perPage() + 1}} по {{ $lots->currentPage() *  $lots->perPage() }} із {{ $lots->total()}} аукціонів
                                @elseif($lots->total() > 10)
                                    Аукціони з {{ $lots->currentPage() *  $lots->perPage() - $lots->perPage() + 1}} по {{ $lots->currentPage() *  $lots->perPage() }} із {{ $lots->total()}} аукціонів
                                @else
                                    Аукціони з {{ $lots->currentPage() *  $lots->perPage() - $lots->perPage() + 1}} по {{ $lots->total()  }} із {{ $lots->total()}} аукціонів
                                @endif

                            </div>
                    </div>
                </div>

            </div>
        </div>

    </div>



@endsection