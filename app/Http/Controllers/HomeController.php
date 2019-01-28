<?php

namespace App\Http\Controllers;

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
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $sets = Set::all();

        $set_query = "select  sets.*,sum(items.price) as price,sets.id as sid
                                            from sets  left join items on sets.id=items.set_id group by sets.id ";
        $result = DB::select($set_query);
        $items = Item::all();

        return view('home', compact('result', $result,'items',$items,'sets',$sets));

    }
}
