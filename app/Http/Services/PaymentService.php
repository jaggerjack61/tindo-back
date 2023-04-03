<?php

namespace App\Http\Services;

use App\Models\Payment;

class PaymentService{

    public function createPayment($order)
    {
        $payment = new Payment();
        $payment->reference = $order->reference;
        $payment->email = $order->email;
        $payment->phone = $order->phone?$order->phone:null;
        $payment->amount = $order->items->price->sum();// look into this
    }
}
