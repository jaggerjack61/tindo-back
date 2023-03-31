<?php

namespace App\Http\Controllers;

use App\Http\Services\PaynowService;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaynowController extends Controller
{

    public $service;

    public function __construct()
    {
        $this->service = new PaynowService();
    }

    public function mobilePayment(Request $request)
    {
        try {
            if ($this->service->makeMobilePayment($request->uniqueId, $request->email, $request->phone, $request->network, $request->order)) {
                return response()->json(['message' => 'success']);
            } else {
                return response()->json(['message' => 'invalid order']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'failed']);
        }
    }

    public function bankPayment(Request $request)
    {
        try {
            if ($this->service->makeBankPayment($request->uniqueId, $request->email, $request->order)) {
                return response()->json(['message' => 'success']);
            } else {
                return response()->json(['message' => 'invalid order']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'failed']);
        }

    }

    public function paymentStatus(Request $request)
    {
        try {
            $result = Payment::where('reference', $request->uniqueId)->first();
            return response()->json(['message' => 'success', 'payment' => $result]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'failed']);
        }

    }

    public function handleResult(Request $request)
    {
        $payment = new Payment();
        $payment->reference = $request['reference'];
        $payment->reference = $request['paynowreference'];
        $payment->status = $request['status'];
        $payment->poll_url = $request['pollurl'];
        $payment->save();
        return response('', 200);
    }


}
