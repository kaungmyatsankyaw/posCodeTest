<?php

namespace App\Http\Controllers;

use App\Extra;
use App\Item;
use function foo\func;
use Illuminate\Http\Request;
use DB;
use App\Set;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $sets = Set::all();
        $items = Item::all();
        $extras = Extra::all();
        return view('home', compact('items', $items, 'sets', $sets, 'extras', $extras));

    }

    public function cal(Request $request)
    {

        $set = $request->get('setname');
        $item = $request->get('itemname');
        $extra = $request->get('extraname');

        $item_data = [];
        $set_data = [];
        $extra_data = [];
        foreach ($set as $key => $value) {

            if ($set[$key][0] != "0") {
                $set_data[] = DB::select("(select sets.name, sum(price) * " . (int)$set[$key][0] .
                    "   as price," . (int)$set[$key][0] . "  as qty from sets join items on sets.id = items.set_id where sets.name= '$key' 
                                                         group by sets.name) union ( select items.name,price = 0 , count(*) *" . (int)$set[$key][0] . " as price from items 
                                                         join sets on sets.id=items.set_id where sets.name = '$key' group by items.id)");
            }
        }

//        dd($set_data);

        foreach ($item as $key => $value) {

            if ($item[$key][0] != "0") {
                $item_data[] = DB::select(" select items.name as iname,count(*)* " . (int)$item[$key][0] . " as qty, sum(price) * " . (int)$item[$key][0] .
                    "   as price from items where name= '$key' ");
            }
        }

//        dd($item_data);
//
        foreach ($extra as $key => $value) {

            if ($extra[$key][0] != "0") {
                $extra_data[] = DB::select(" select extras.name as ename,count(*)* " . (int)$extra[$key][0] . " as qty, sum(price) * " . (int)$extra[$key][0] .
                    "   as price from extras where name= '$key' ");
            }
        }

        $price = 0.00;

        for ($i = 0; $i < count($set_data); $i++) {
            if (is_numeric($set_data[$i][0]->price))
                $price += $set_data[$i][0]->price;
        }

        for ($i = 0; $i < count($item_data); $i++) {
            if (is_numeric($item_data[$i][0]->price))
                $price += $item_data[$i][0]->price;
        }

        for ($i = 0; $i < count($extra_data); $i++) {
            if (is_numeric($item_data[$i][0]->price))
                $price += $item_data[$i][0]->price;
        }

        $subtotal = $price;

        if ($request->has('discount')) {
            $discount = 10;
            $price = $price * 0.9;
            $grand_total = $price;
            $cash = $grand_total;
        } else {
            $discount = 0;
            $grand_total = $price;
            $cash = $grand_total;
        }

        $data['set'] = $set_data;
        $data['item'] = $item_data;
        $data['extra'] = $extra_data;
        $data['subtotal'] = $subtotal;
//        $data['price'] = $price;
        $data['discount'] = $discount;
        $data['grand_total'] = $grand_total;
        $data['cash'] = $cash;

        $receipt = $this->receipt();
        $data['receipt_no'] = $receipt['no'];
        $data['time'] = $receipt['time'];
//dd($data);
        return view('cash', $data);

    }

    public function receipt()
    {
        $time = date('d/m/Y H:i:s');
        $receipt = DB::select("select * from receipt order by id desc limit 1");
        if (!$receipt) {
            $receipt_no = 1;
        } else {
            $receipt_no = $receipt[0]->receipt_no + 1;
        }

        $insert_query = "insert into receipt (receipt_no,time) values (?,?)";

        DB::insert($insert_query, [$receipt_no, $time]);
        $receipt_data['no'] = $receipt_no;
        $receipt_data['time'] = $time;
        return $receipt_data;
    }

}
