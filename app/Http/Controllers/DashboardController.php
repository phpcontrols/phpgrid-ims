<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $ordersShipped = 0;

        $ordersShipped = DB::connection('im')->table('orders')
                ->sum('NumberShipped');


        /*
        // SELECT 
        *
        FROM orders
        WHERE NumberShipped = 
            (select max(NumberShipped) from orders)
        */

        /*
        DB::table('orders')
            ->select('products.ProductName')
            ->join('products','orders.productId','=','products.id')
            ->where('NumberShipped','=',function($query) {
                $query->from('orders')
                    ->select(DB::raw("'max'(NumberShipped));
            })
            ->get();
        */

        // converted with /sql-to-laravel-builder/, https://sql2builder.github.io/
        // return scalar value 
        $mostOrderedProduct = DB::connection('im')->table('orders')
                    ->join('products','orders.productId','=','products.id')
                    ->whereRaw('NumberShipped = (select max(NumberShipped) from orders)')
                    ->value('products.ProductName');



        return view('dashboard')->with(['ordersShipped' => $ordersShipped,
                                        'mostOrderedProduct' => $mostOrderedProduct
                                        ]);
    }
}
