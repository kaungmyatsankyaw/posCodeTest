<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AdminController extends Controller
{
    public function index()
    {
        $result = DB::select("select * from receipts_new");

        foreach ($result as $re) {
            $out['reno']=$re->receipt_no;
            $out['price'] = $re->price;
            $out['discount']=$re->discount;
            $out['grand_total']=$re->grand_total;
            $out['cash']=$re->cash;
            $out['date']=$re->time;
            $o['set'] = explode(', ', $re->sets);
            $o['set_count'] = explode(',', $re->set_count);

            $out['sets'] = array_combine($o['set'], $o['set_count']);

            $o['item'] = explode(',', $re->items);
            $o['item_count'] = explode(',', $re->item_count);

            $out['items'] = array_combine($o['item'], $o['item_count']);

            $ad[] = $out;
            unset($out);
        }
        $data['ads']=$ad;
//        dd($ad);
        return view('admin.index',$data);
    }
}
