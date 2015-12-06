@extends('layouts')
@section('title')@lang('theme.cont') - @lang('theme.sitename_title')@endsection
@section('content')

    <h2>@lang('theme.contactspage_h2')</h2>

    <div id="map-container">
        <div id="canvas-map">&nbsp;</div>
    </div>

    <div class="row page_contacts">
        <div class="col-md-12"><i class="adress"></i>@lang('theme.contacts_wbr')</div>
        <div class="col-md-12 col-lg-6"><i class="phone"></i><b>Номер телефона:</b><div style="padding: 0 0 0 64px">@lang('theme.phone_footer')</div></div>
        <div class="col-md-12 col-lg-6"><i class="email"></i><b>E-mail:</b><br>info@uace.com.ua</div>
    </div>



    <script>
        var map;
        var mapCoordinates = new google.maps.LatLng(50.447902, 30.499121);
        var markers = [];
        var image = new google.maps.MarkerImage('static/images/map-pointer.png', // РёРєРѕРЅРєР°
                new google.maps.Size(121,46), // СЂР°Р·РјРµСЂС‹ РёРєРѕРЅРѕРє
                new google.maps.Point(0,0),
                new google.maps.Point(42,56)
        );

        function addMarker()
        {
            markers.push(new google.maps.Marker({
                position: mapCoordinates,
                raiseOnDrag: false,
                icon: image,
                map: map,
                draggable: false
            }));
        }

        function initialize() {
            var mapOptions = {
                zoom: 18,
                center: new google.maps.LatLng(50.447983, 30.499583),
                scrollwheel: false,
                mapTypeControl: true,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.DEFAULT,
                    mapTypeIds: [
                        google.maps.MapTypeId.ROADMAP,
                        google.maps.MapTypeId.TERRAIN
                    ]
                },
                zoomControl: true,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.SMALL
                }
            };
            map = new google.maps.Map(document.getElementById('canvas-map'), mapOptions);
            addMarker();
        }

        google.maps.event.addDomListener(window, 'load', initialize);

    </script>
@stop
@section('head')<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>@stop