<?php

namespace App\Http\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Painting;
use Illuminate\Support\Facades\Log;

class OrderService{

    public function verifyOrder($order)
    {
        foreach($order->items as $item){
            if(Painting::find($item['id'])->status != 'available'){
                Log::info('available');
                return false;
            }
            if(Painting::find($item['id'])->price != $item['price']){
                Log::info('price');
                return false;
            }
        }
        return true;
    }

    public function createOrder($order){
        $ord = new Order();
        $ord->user_id = auth()->user()->id;
        $ord->address = $order->address;
        $ord->reference = $order->reference;
        $ord->save();
        foreach($order->items as $item){
            $ordItem = new OrderItem();
            $ordItem->order_id = $ord->id;
            $ordItem->item_id = $item['id'];
            $ordItem->item_name = $item['name'];
            $ordItem->item_price = $item['price'];
            $ordItem->save();
        }
    }

}
