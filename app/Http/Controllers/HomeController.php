<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\SaleDetail;
use App\Models\SaleOrder;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get today summary
        $total_sale_order_today = SaleOrder::where('date', '=', now()->toDateString())->count();
        $total_sale_item_today = SaleDetail::join('sale_orders', 'sale_orders.id', '=', 'sale_details.sale_order_id')->where('sale_orders.date', '=', now()->toDateString())->sum('qty');


        // Get summary within current month
        $total_sale_order_current_month = SaleOrder::whereMonth('date', now()->month)->count();
        $total_sale_item_current_month = SaleDetail::join('sale_orders', 'sale_orders.id', '=', 'sale_details.sale_order_id')->whereMonth('sale_orders.date', now()->month)->sum('qty');

        // dd($total_sale_order_today,  $total_sale_item_today);

        return view('home', [
            'total_sale_order_today' => $total_sale_order_today, 'total_sale_item_today' => $total_sale_item_today,
            'total_sale_order_current_month' => $total_sale_order_current_month, 'total_sale_item_current_month' => $total_sale_item_current_month,
        ]);
    }
}
