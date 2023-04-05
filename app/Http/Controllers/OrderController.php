<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function markDelivered(Order $order)
    {
        $order->delivery_status = 'delivered';
        $order->save();
        return back()->with('success','The order has been delivered'.$order->item_name);
    }

    public function markUndelivered(Order $order)
    {
        $order->delivery_status = 'pending';
        $order->save();
        return back()->with('error','The order is pending delivery');
    }
}
