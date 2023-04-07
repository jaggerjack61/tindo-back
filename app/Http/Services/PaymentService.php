<?php

namespace App\Http\Services;

use App\Models\Order;
use App\Models\Painting;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class PaymentService
{

    public function createPayment($order)
    {
        $sum = 0;
        foreach ($order->items as $item) {
            $sum += $item['price'];
        }
        $payment = new Payment();
        $payment->reference = $order->reference;
        $payment->email = $order->email;
        $payment->phone = $order->phone ? $order->phone : null;
        $payment->amount = $sum;// look into this
        $payment->save();
    }

    public function webhookReciever($request)
    {
        $payment = Payment::where('reference', $request['reference'])->first();
        $payment->status = $request['status'];
        $payment->poll_url = $request['pollurl'];
        $payment->redirect_url = $request['browserurl'] ?? null;
        $payment->paynow_reference = $request['paynowreference'];
        $payment->save();
        if ($request['status'] == 'Paid') {
            $order = Order::where('reference', $request['reference'])->first();
            $order->status = 'Paid';
            $order->save();
            foreach ($order->items as $item) {
                $painting = Painting::find($item->item_id);
                Log::info($item->name.'-'.$painting->name);
                $painting->status = 'sold';
                $painting->save();

            }
        }
        elseif ($request['status'] == 'Awaiting Delivery') {
            $order = Order::where('reference', $request['reference'])->first();
            $order->status = 'Paid';
            $order->save();
            foreach ($order->items as $item) {
                $painting = Painting::find($item->item_id);
                Log::info($item->name.'-'.$painting->name);
                $painting->status = 'sold';
                $painting->save();

            }
        }
        return response('', 200);
    }
}
