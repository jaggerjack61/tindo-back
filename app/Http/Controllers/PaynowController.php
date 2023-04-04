<?php

namespace App\Http\Controllers;

use App\Http\Services\PaymentService;
use App\Http\Services\PaynowService;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaynowController extends Controller
{

    public $paynowService;
    public $paymentService;

    public function __construct()
    {
        $this->paynowService = new PaynowService();
        $this->paymentService = new PaymentService();
    }

    public function mobilePayment(Request $request)
    {

        try {
            $string = json_encode($request->all());
            $file = fopen("output.txt", "w");
            fwrite($file, $string);
            fclose($file);
            $request->phone = '0'.$request->phone;
            if ($this->paynowService->makeMobilePayment($request)) {
                return response()->json(['message' => 'success']);
            } else {
                return response()->json(['message' => 'invalid order']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'failed:'.$e->getMessage()]);
        }
    }

    public function bankPayment(Request $request)
    {
        try {
            if ($this->paynowService->makeBankPayment($request->all())) {
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
            $result = Payment::where('reference', $request->reference)->first();
            return response()->json(['message' => 'success', 'payment' => $result]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'failed']);
        }

    }

    public function handleResult(Request $request)
    {
        $this->paymentService->webhookReciever($request->all());
        return response('',200);
    }


}
