<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>POS</title>

    <!-- Scripts -->
{{--<script src="{{ asset('js/app.js') }}" defer></script>--}}

<!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script
        src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
</head>
<style>
    form {
        /*width: 300px;*/
        margin: 0 auto;
        /*text-align: center;*/
        /*padding-top: 50px;*/
    }

    .value-button {
        display: inline-block;
        border: 1px solid #ddd;
        margin: 0px;
        width: 40px;
        /*height: 20px;*/
        text-align: center;
        vertical-align: middle;
        /*padding: 11px 0;*/
        background: #eee;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }

    .value-button:hover {
        cursor: pointer;
    }

    form #decrease {
        margin-right: -4px;
        border-radius: 8px 0 0 8px;
    }

    form #increase {
        margin-left: -4px;
        border-radius: 0 8px 8px 0;
    }

    form #input-wrap {
        margin: 0px;
        padding: 0px;
    }

    input.number {
        text-align: center;
        border: none;
        border-top: 1px solid #ddd;
        border-bottom: 1px solid #ddd;
        margin: 0px;
        width: 40px;
        height: 40px;
    }

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                POS
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->

                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <main class="py-4">


            <form method="post">

                <div class="row">

                    <div class="col">
                        <h4 class="py-4">SET</h4>
                        @foreach($sets as $set)

                            <div class="row col form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="setname[<?php echo $set->name ?>]" value="{{ $set->name }}"
                                       id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    {{ $set->name }}
                                </label>
                            </div>
                            <div class="value-button decrease" data-id="<?php echo $set->id ?>" value="Decrease Value">-
                            </div>
                            <input type="number" name="setname[<?php echo $set->name ?>][]" class="number" id="<?php echo $set->id ?>number"
                                   value="0"/>
                            <div class="value-button increase" data-id="<?php echo $set->id ?>" value="Increase Value">+
                            </div>

                        @endforeach
                    </div>

                    <div class="col">
                        <h4 class="py-4">Items</h4>
                        @foreach($items as $item)

                            <div class="row col  mx-1  form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="itemname[<?php echo $item->name?>]"
                                       value="{{ $item->name }}"
                                       id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    {{ $item->name }}
                                </label>
                            </div>
                            <div class="value-button decrease_item" data-id="<?php echo $item->id ?>"
                                 value="Decrease Value">-
                            </div>
                            <input type="number" name="itemname[<?php echo $item->name?>][]" class="number"
                                   id="<?php echo $item->id ?>itemcount"
                                   value="0"/>
                            <div class="value-button increase_item" data-id="<?php echo $item->id ?>"
                                 value="Increase Value">+
                            </div>

                        @endforeach
                    </div>

                    <div class="col">
                        <h4 class="py-4">Extras</h4>
                        @foreach($extras as $extra)

                            <div class="row col  mx-1  form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="extraname[<?php echo $extra->name?>]"
                                       value="{{ $extra->name }}"
                                       id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    {{ $extra->name }}
                                </label>
                            </div>
                            <div class="value-button decrease_extra" data-id="<?php echo $extra->id ?>"
                                 value="Decrease Value">-
                            </div>
                            <input type="number" name="extraname[<?php echo $extra->name?>][]" class="number"
                                   id="<?php echo $extra->id ?>extracount"
                                   value="0"/>
                            <div class="value-button increase_extra" data-id="<?php echo $extra->id ?>"
                                 value="Increase Value">+
                            </div>

                        @endforeach
                    </div>

                </div>

                <div class="row">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="discount" id="exampleRadios1"
                               value="discount">
                        <label class="form-check-label" for="exampleRadios1">
                            Discount
                        </label>
                    </div>
                </div>

                <div class="row py-4">
                    <button type="submit" class="btn btn-lg btn-block btn-primary">Add</button>
                </div>

            </form>


        </main>

    </div>
</div>


<script>

    $('.increase').on('click', function () {
        // alert(456)
        // alert($(this).attr('data-id')+'number');
        var value = parseInt(document.getElementById($(this).attr('data-id') + 'number').value, 10);
        value = isNaN(value) ? 0 : value;
        value++;
        console.log(value);
        document.getElementById($(this).attr('data-id') + 'number').value = value;
    });


    $('.decrease').on('click', function () {
        var value = parseInt(document.getElementById($(this).attr('data-id') + 'number').value, 10);
        value = isNaN(value) ? 0 : value;
        value < 1 ? value = 1 : '';
        value--;
        document.getElementById($(this).attr('data-id') + 'number').value = value;

    });

    $('.increase_item').on('click', function () {

        var value = parseInt(document.getElementById($(this).attr('data-id') + 'itemcount').value, 10);
        value = isNaN(value) ? 0 : value;
        value++;
        console.log(value);
        document.getElementById($(this).attr('data-id') + 'itemcount').value = value;
    });


    $('.decrease_item').on('click', function () {
        var value = parseInt(document.getElementById($(this).attr('data-id') + 'itemcount').value, 10);
        value = isNaN(value) ? 0 : value;
        value < 1 ? value = 1 : '';
        value--;
        document.getElementById($(this).attr('data-id') + 'itemcount').value = value;

    });

    $('.increase_extra').on('click', function () {

        var value = parseInt(document.getElementById($(this).attr('data-id') + 'extracount').value, 10);
        value = isNaN(value) ? 0 : value;
        value++;
        console.log(value);
        document.getElementById($(this).attr('data-id') + 'extracount').value = value;
    });


    $('.decrease_extra').on('click', function () {
        var value = parseInt(document.getElementById($(this).attr('data-id') + 'extracount').value, 10);
        value = isNaN(value) ? 0 : value;
        value < 1 ? value = 1 : '';
        value--;
        document.getElementById($(this).attr('data-id') + 'extracount').value = value;

    });

</script>
</body>
</html>
