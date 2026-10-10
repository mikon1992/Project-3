<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where('id_user', $request->user()->id_user)
            ->with('details.product')
            ->latest('tanggal_order')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order)
    {
        abort_if($order->id_user !== $request->user()->id_user, 403);

        $order->load('details.product');

        return view('orders.show', compact('order'));
    }
}
