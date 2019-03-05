<div class="container">
    <div class="row">
        <div class="col-md-12 ">
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
                            {{--Receipt No . {{ $receipt_no }}--}}
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
                            {{  date('d/m/Y') }}
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
                    <table class="table mb-0 p-0">
                        <thead class=" ">
                        <tr>
                            <th scope="col">QTY</th>
                            <th scope="col">ITEM</th>
                            <th scope="col " class="text-right">AMOUNT</th>

                        </tr>
                        </thead>
                        <tbody class="">

                        @if(count($set)>0)
                            @for($i=0;$i<count($set);$i++)
                                <tr class="text-brown">
                                    <th scope="row">
                                        {{ $set[$i]['count'] }}
                                    </th>
                                    <th rowspan="" colspan="">
                                        {{ $set[$i]['set_name'] }} <br>

                                        @for($j=0;$j<count($set[$i]['sub_items']);$j++)
                                            {{ $set[$i]['sub_items'][$j] }} <br>
                                        @endfor

                                    </th>
                                    <th class="text-right">
                                        {{ number_format($set[$i]['set_price'],2) }} <br>

                                    </th>
                                </tr>
                            @endfor
                        @endif

                        @if(count($items)>0)
                            @for($i=0;$i<count($items);$i++)
                                @php
                                @endphp
                                <tr class="text-primary">
                                    <th scope="row">
                                        {{ $items[$i]['item_count'] }}
                                    </th>
                                    <th rowspan="" colspan="">
                                        {{ $items[$i]['item_name'] }} <br>
                                    {{--</th>--}}
                                    <th class="text-right">
                                        {{ number_format($items[$i]['item_price'],2) }}
                                    </th>
                                </tr>
                            @endfor
                        @endif


                        </tbody>
                    </table>


                </div>
                <div class="card-footer text-muted">
                    <div class="row">
                        <div class="col-md-4 offset-md-4 font-weight-bold p-2">
                            Sub Total
                        </div>
                        <div class="col-md-4 text-right p-2">
                            {{ number_format($subtotal,2 ) }}
                        </div>
                    </div>
                    @if($discount > 0)
                        <div class="row">
                            <div class="col-md-4 offset-md-4 font-weight-bold p-2">
                                Discount %
                            </div>
                            <div class="col-md-4 text-right p-2">
                                {{ $discount }}
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-4 offset-md-4 font-weight-bold p-2">
                            Grand Total
                        </div>
                        <div class="col-md-4 text-right p-2">
                            {{ number_format($grand_total,2 ) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 offset-md-4 font-weight-bold p-2">
                            Cash
                        </div>
                        <div class="col-md-4 text-right p-2">
                            {{ number_format($cash,2 ) }}
                        </div>
                    </div>
                    <div class="row mt-5 mb-0">
                        <div class="col col-md-12">
                            <p class="text-center pb-0 mb-0">CUSTOMER HOTLINE</p>
                            <p class="text-center pb-0 mb-0">(060) 3 2298 7229</p>
                            <p class="text-center">***Thank You!***</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
