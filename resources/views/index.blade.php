@extends('layouts.app')

@section('title','Cash')


@section('content')

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

        #nav-profile-tab.active +  #nav-home {
            display: none !important;
        }
    </style>



    <div class="container-fluid pt-5">


        <div class="row">
            <div class="col col-md-6">
                <div id="cash_data"></div>
            </div>
            <div class="col col-md-6">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Set</a>
                        <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="false">Item</a>
                    </div>
                </nav>
                <form method="post" id="cash_form">

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active py-3" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        @foreach($sets as $key=>$value)

                            <div class="row col form-check form-check-inline py-3">

                                <div class="col col-md-4 text-center">
                                    <label class="form-check-label" for="defaultCheck1">
                                        {{ $sets[$key]['set_name'] }}
                                    </label>
                                </div>
                                <div class="col col-md-4 offset-4">
                                    <div class="value-button decrease" data-id="<?php echo $sets[$key]['set_id'] ?>"
                                         value="Decrease Value">-
                                    </div>
                                    <input type="number" name="<?php echo $sets[$key]['set_name'] ?>"
                                           class="number"
                                           id="<?php echo $sets[$key]['set_id'] ?>number"
                                           value="0"/>
                                    <div class="value-button increase" data-id="<?php echo $sets[$key]['set_id'] ?>"
                                         value="Increase Value">+
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                    <div class="tab-pane fade py-3" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        @foreach($items as $key=>$value)

                            <div class="row col form-check form-check-inline py-3">

                                <div class="col col-md-4 text-center">
                                    <label class="form-check-label" for="defaultCheck1">
                                        {{ $items[$key]['item_name'] }}
                                    </label>
                                </div>
                                <div class="col col-md-4 offset-4">
                                    <div class="value-button decrease_item"
                                         data-id="<?php echo $items[$key]['item_id'] ?>"
                                         value="Decrease Value">-
                                    </div>
                                    <input type="number" name="<?php echo $items[$key]['item_name'] ?>"
                                           class="number"
                                           id="<?php echo $items[$key]['item_id'] ?>itemcount"
                                           value="0"/>
                                    <div class="value-button increase_item"
                                         data-id="<?php echo $items[$key]['item_id'] ?>"
                                         value="Increase Value">+
                                    </div>
                                </div>

                            </div>

                        @endforeach

                    </div>

                </div>


                <div class="row px-4">
                    <div class="form-check">
                        <input class="form-check-input radio" type="radio" name="discount" id="exampleRadios1"
                               value="discount" >
                        <label class="form-check-label" for="exampleRadios1">
                            Discount
                        </label>
                    </div>
                </div>
                    <div class="row px-4">
                        <div class="form-check">
                            <input class="form-check-input radio" type="radio" name="discount" id="exampleRadios1"
                                   value="no_discount" >
                            <label class="form-check-label" for="exampleRadios1">
                               No  Discount
                            </label>
                        </div>
                    </div>

                </form>


                <div class="row py-4 px-4">
                        <button type="submit" class="btn  btn-primary" id="cash_button">Add</button>
                    </div>


                </div>
            </div>


        </div>

        <script>
            $('#cash_button').on('click', (e) => {
                e.preventDefault();
                // console.log($(':input[type="number"]').serializeArray());
                $.ajax({
                    url: '{{ url('/cash') }}',
                    method: "post",
                    data: {data: $(':input[type="number"]').serializeArray(),discount:$('.radio:checked').val()},
                    success: function (data) {
                        $('#cash_data').empty();
                       $('#cash_data').append(data);
                    }
                });
            });
        </script>

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

@endsection
