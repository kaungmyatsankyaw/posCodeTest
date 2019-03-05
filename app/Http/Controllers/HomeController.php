<?php

namespace App\Http\Controllers;

use App\Extra;
use App\Item;
use function foo\func;
use Illuminate\Http\Request;
use DB;
use App\Set;
use Response;

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

//        $sets = Set::all();
//        $items = Item::all();
//        $extras = Extra::all();

        $items = Item::all();

        foreach ($items as $item) {
            if ($item->is_set == 1) {
                $out['set_name'] = $item->name;
                $out['set_price'] = $item->price;
                $out['set_id'] = $item->id;
                $set[] = $out;
                unset($out);
            } else {
                $out['item_name'] = $item->name;
                $out['item_price'] = $item->price;
                $out['item_id'] = $item->id;
                $item_data[] = $out;
                unset($out);
            }
        }

        $data['sets'] = $set;
        $data['items'] = $item_data;

        return view('index', $data);

//    }

//return view('home', compact('items', $items, 'sets', $sets, 'extras', $extras));

    }

    public function cal(Request $request)
    {

        $set = $request->get('setname');
        $item = $request->get('itemname');
        $extra = $request->get('extraname');
//dd($set);
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
            if (is_numeric($extra_data[$i][0]->price))
                $price += $extra_data[$i][0]->price;
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

    public
    function receipt()
    {
        $time = date('d/m/Y H:i:s');
        $receipt = DB::select("select * from receipt order by id desc limit 1");
        if (!$receipt) {
            $receipt_no = 1;
        } else {
            $receipt_no = $receipt[0]->receipt_no + 1;
        }

        $insert_query = "insert into receipt (receipt_no,time) values (?,?)";

        DB::insert($insert_query, [$receipt_no, date('Y-m-d H:i:s')]);
        $receipt_data['no'] = $receipt_no;
        $receipt_data['time'] = $time;
        return $receipt_data;
    }

    public function cash(Request $request)
    {
//dd($request->all());
        $set = [];
        $item = [];
        $set_data = [];
        $item_data = [];
        $sets = [];
        $items = [];
        $user_item = $request->input('data');

        foreach ($request->input('data') as $key => $value) {
            if ((int)$user_item[$key]['value'] != 0) {
                if ($this->checkSet($user_item[$key]['name'])) {
                    $out['name'] = $user_item[$key]['name'];
                    $out['count'] = (int)$user_item[$key]['value'];
                    $set[] = $out;
                    unset($out);
                } else {
                    $out['name'] = $user_item[$key]['name'];
                    $out['count'] = (int)$user_item[$key]['value'];
                    $item[] = $out;
                    unset($out);
                }
            }
        }


        foreach ($set as $key => $value) {
            $query = " select set_data.set_name,set_data.price,sub.sub_item,? as count from ( select items.name as set_name,sum(price)* ? as price
                        from items where items.name = ? group by items.name )  set_data , (select items.name as sub_item from items join
                                            (select sub_item_id,item_id from sub_items join items on items.id = sub_items.item_id where items.name = ? ) as tmp 
                                            on items.id = tmp.sub_item_id group by items.name ) sub";
            $set_data[] = DB::select($query, [$set[$key]['count'], $set[$key]['count'], $set[$key]['name'], $set[$key]['name']]);
        }

        foreach ($item as $key => $value) {
            $query = "select items.name  as item_name,sum(price)* ? as price,? as count from items where items.name = ? group by items.name";
            $item_data[] = DB::select($query, [$item[$key]['count'], $item[$key]['count'], $item[$key]['name']]);
        }

        foreach ($set_data as $key => $value) {
            $out['set_name'] = $set_data[$key][0]->set_name;
            $out['set_price'] = $set_data[$key][0]->price;
            $out['count'] = $set_data[$key][0]->count;

            for ($i = 0; $i < count($value); $i++) {
                $out['sub_items'][] = $set_data[$key][$i]->sub_item;
            }

            $sets[] = $out;
            unset($out);
        }

        foreach ($item_data as $key => $value) {
            $out['item_name'] = $item_data[$key][0]->item_name;
            $out['item_price'] = $item_data[$key][0]->price;
            $out['item_count'] = $item_data[$key][0]->count;
            $items[] = $out;
            unset($out);
        }

        $price = 0.00;

        for ($i = 0; $i < count($sets); $i++) {
            $price += $sets[$i]['set_price'];
        }

        for ($i = 0; $i < count($items); $i++) {
            $price += $items[$i]['item_price'];
        }

        $subtotal = $price;

        if ($request->get('discount') == 'discount') {
            $discount = 10;
            $price = $price * 0.9;
            $grand_total = $price;
            $cash = $grand_total;
        } else {
            $discount = 0;
            $grand_total = $price;
            $cash = $grand_total;
        }


        $data['set'] = $sets;
        $data['items'] = $items;
        $data['price'] = $price;
        $data['discount'] = $discount;
        $data['grand_total'] = $grand_total;
        $data['subtotal'] = $subtotal;
        $data['cash'] = $cash;

        $set_tmp = [];
        $item_tmp = [];
        $set_count_tmp=[];
        $item_count_tmp=[];
        foreach ($sets as $key => $value) {
            $set_tmp[] = $value['set_name'];
            $set_count_tmp[]=$value['count'];
        }

        $set_str = implode(", ", $set_tmp);
        $set_count_str=implode(", ",$set_count_tmp);



        foreach ($items as $key => $value) {
            $item_tmp[] = $items[$key]['item_name'];
            $item_count_tmp[]=$items[$key]['item_count'];
        }

        $item_count_str=implode(", ",$item_count_tmp);



        $item_str = implode(",", $item_tmp);
        $receipt = $this->receipt_new($set_str, $item_str,$set_count_str,$item_count_str,$discount, $grand_total,$subtotal, $cash);

        $data['receipt_no'] = $receipt['no'];
        $data['time'] = $receipt['time'];

        return view('cash_onepage', $data);
    }

    public function checkSet($name)
    {
        $quey = "select is_set from items where name =?";
        $result = DB::select($quey, [$name]);
        if ($result[0]->is_set == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function receipt_new($sets, $items, $set_count_str,$item_count_str,$discount, $grand_total,$price, $cash)
    {
        $time = date('d/m/Y H:i:s');
        $receipt = DB::select("select receipt_no from receipts_new order by id desc limit 1");
        if (!$receipt) {
            $receipt_no = 1;
        } else {
            $receipt_no = $receipt[0]->receipt_no + 1;
        }

        $query = "insert into receipts_new(receipt_no,sets,items,set_count,item_count,discount,grand_total,price,cash,time) values(?,?,?,?,?,?,?,?,?,?)";

        DB::select($query, [$receipt_no, $sets, $items,$set_count_str,$item_count_str, $discount, $grand_total, $price,$cash,date('Y-m-d H:i:s')]);
        $receipt_data['no'] = $receipt_no;
        $receipt_data['time'] = $time;
        return $receipt_data;

    }

}
