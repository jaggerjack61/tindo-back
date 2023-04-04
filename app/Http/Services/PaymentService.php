<?php

namespace App\Http\Services;

use App\Models\Payment;
use Illuminate\Http\Request;


class PaymentService{

    public function createPayment($order)
    {
        $sum = 0;
        foreach ($order->items as $item) {
            $sum += $item['price'];
        }
        $payment = new Payment();
        $payment->reference = $order->reference;
        $payment->email = $order->email;
        $payment->phone = $order->phone?$order->phone:null;
        $payment->amount = $sum;// look into this
        $payment->save();
    }

    public function webhookReciever($request)
    {
        $payment = Payment::where('reference',$request['reference'])->first();
        $payment->status = $request['status'];
        $payment->poll_url = $request['pollurl'];
        $payment->redirect_url = $request['browserurl'] ?? null;
        $payment->paynow_reference = $request['paynowreference'];
        $payment->save();
        return response('', 200);
    }
}
