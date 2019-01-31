@extends('layouts.app')

@section('title','Cash')


@section('content')




    <div class="container ">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card ">
                    <div class="card-header text-center">
                        <p class="p-0 m-0">
                            LIBRASUN SNACKS</p>
                        <p class="p-0 m-0">
                            Mid Valley City,
                        </p>
                        <p class="p-0 m-0">
                            Lingkaran Syed Putra,
                        </p>
                        <p class="p-0 m-0">
                            59200 Kuala Lumpur
                        </p>
                        <div class="row mt-2">
                            <div class="col col-m6 text-left">
                                Receipt No . {{ $receipt_no }}
                            </div>
                            <div class="col col-m6 text-right">
                                Temp-Temp_01
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col col-m6 text-left">
                                Shift No.1
                            </div>
                            <div class="col col-m6 text-right">
                                20/02/2018
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col col-m6 text-left">
                                Cashier:SUPPORT
                            </div>
                            <div class="col col-m6 text-right">
                               {{ $time }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col text-left">
                                DINE-IN
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <table class="table ">
                            <thead class="thead-dark ">
                            <tr>
                                <th scope="col">QTY</th>
                                <th scope="col">ITEM</th>
                                <th scope="col " class="text-right">AMOUNT</th>

                            </tr>
                            </thead>
                            <tbody class="">

                            @if(count($set)>0)
                            @for($i=0;$i<count($set);$i++)
                                <tr   class="text-brown">
                                    <th scope="row">
                                        {{ $set[$i][0]->qty }}
                                    </th>
                                    <th rowspan="" colspan="">
                                        {{ $set[$i][0]->name }} <br>
                                        {{ $set[$i][1]->qty }}- {{ $set[$i][1]->name }} <br>
                                        {{ $set[$i][2]->qty }}- {{ $set[$i][2]->name }}
                                    </th>
                                    <th class="text-right">
                                        {{ number_format($set[$i][0]->price,2) }} <br>
                                        {{ number_format($set[$i][1]->price,2) }}<br>
                                        {{ number_format($set[$i][1]->price,2) }}
                                    </th>
                                </tr>
                                @endfor
                                @endif

                            @if(count($item)>0)
                                @for($i=0;$i<count($item);$i++)
                                    <tr class="text-primary">
                                        <th scope="row" >
                                            {{ $item[$i][0]->qty }}
                                        </th>
                                        <th rowspan="" colspan="">
                                            {{ $item[$i][0]->iname }} <br>
                                        </th>
                                        <th class="text-right">
                                            {{ number_format($item[$i][0]->price,2) }}
                                        </th>
                                    </tr>
                                @endfor
                                @endif

                            @if(count($extra)>0)
                                @for($i=0;$i<count($extra);$i++)
                                    <tr class="text-success">
                                        <th scope="row" >
                                            {{ $extra[$i][0]->qty }}
                                        </th>
                                        <th rowspan="" colspan="">
                                            {{ $extra[$i][0]->ename }} <br>
                                        </th>
                                        <th class="text-right">
                                            {{ number_format($extra[$i][0]->price,2) }}
                                        </th>
                                    </tr>
                                @endfor
                            @endif

                            </tbody>
                        </table>


                    </div>
                    <div class="card-footer text-muted">
                       <div class="row">
                           <div class="col-md-4 offset-md-4 font-weight-bold">
                             Sub Total
                           </div>
                           <div class="col-md-4 text-right">
                           {{ number_format($subtotal,2 ) }}
                           </div>
                       </div>
                        @if($discount > 0)
                          <div class="row">
                              <div class="col-md-4 offset-md-4 font-weight-bold">
                                  Discount %
                              </div>
                              <div class="col-md-4 text-right">
                                  {{ $discount }}
                              </div>
                          </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
