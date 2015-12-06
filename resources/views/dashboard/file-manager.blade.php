@extends('dashboard.layout')

@section('head')
<!-- jQuery and jQuery UI (REQUIRED) -->
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>
<? $locale = 'ru'; ?>
        <!-- elFinder CSS (REQUIRED) -->
<link rel="stylesheet" type="text/css" href="<?= asset('//uace.com.ua/packages/barryvdh/elfinder/css/elfinder.min.css') ?>">
<link rel="stylesheet" type="text/css" href="<?= asset('//uace.com.ua/packages/barryvdh/elfinder/css/theme.css') ?>">

<!-- elFinder JS (REQUIRED) -->
<script src="<?= asset('//uace.com.ua/packages/barryvdh/elfinder/js/elfinder.min.js') ?>"></script>

<?php if($locale){ ?>
        <!-- elFinder translation (OPTIONAL) -->
<script src="<?= asset("//uace.com.ua/packages/barryvdh/elfinder/js/i18n/elfinder.$locale.js") ?>"></script>
<?php } ?>

        <!-- elFinder initialization (REQUIRED) -->
<script type="text/javascript" charset="utf-8">
    // Documentation for client options:
    // https://github.com/Studio-42/elFinder/wiki/Client-configuration-options
    $().ready(function() {
        $('#elfinder').elfinder({
            height: 700,
            url: '/elfinder/connector',
            // set your elFinder options here
            <?php if($locale){ ?>
                lang: '<?= $locale ?>', // locale
            <?php } ?>
            customData: {
                _token: '<?= csrf_token() ?>'
            },
            //url : '<?= route("elfinder.connector") ?>'  // connector URL
        });
    });
</script>
@endsection

@section('content')

    <div class="container-fluid">
        <h2 class="sub-header" style="margin-bottom: 20px">Управління файлами</h2>

        <div id="elfinder"></div>


    </div>


@endsection