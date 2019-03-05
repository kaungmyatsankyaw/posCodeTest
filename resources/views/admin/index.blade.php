@extends('adminlte::page')

@section('title', 'All')

@section('content_header')
    <h1>Receipt Record</h1>
@stop


@section('content')
    <div class="container" style="width: 100%">
        <div class="row ">
            @if(Session::has('status'))
                <div class="alert alert-success" role="alert">{{ Session::get('status') }}</div>
            @endif
            <table class="table table-bordered " style="width: 100%" id="ads">
                <thead>
                <tr>
                    <th scope="col">Receipt No</th>
                    <th scope="col">Set</th>
                    <th scope="col">Item</th>
                    <th scope="col">Price</th>
                    <th>Discount</th>
                    <th>Grand Total</th>
                    <th>Cash</th>
                    <th>Time</th>
                </tr>
                </thead>
                <tbody>


                @foreach($ads as $ad)

                    <tr>
                        <td>{{ $ad['reno']  }}</td>
                        <td>
                        @foreach($ad['sets'] as $key=>$value)
                            {{ $value }} -  <b>{{ $key }}</b> <br>
                        @endforeach
                        </td>
                        <td>
                            @foreach($ad['items'] as $key=>$value)
                                {{ $value }} -  <b>{{ $key }}</b> <br>
                            @endforeach
                        </td>
                        <td>{{ $ad['price'] }}</td>
                        <td>{{ $ad['discount'] }}</td>
                        <td>{{ $ad['grand_total'] }}</td>
                        <td>{{ $ad['cash'] }}</td>
                        <td>{{ $ad['date'] }}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

@endsection


@section('js')
    <script>
        $(document).ready(function () {
            $('#ads').DataTable();
        });
    </script>
@stop