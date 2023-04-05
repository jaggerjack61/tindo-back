<?php

namespace App\Http\Services;
use App\Models\Painting;
use Illuminate\Support\Facades\Log;
use Paynow\Payments\Paynow;

class PaynowService{

    public $id = '15485';
    public $key = 'df033924-f9bb-4056-bc77-934657ee2ab1';
    public $returnUrl = 'https://0e4a-77-246-52-174.eu.ngrok.io';
    public  $resultUrl = 'https://322c-197-221-253-139.eu.ngrok.io/api/paynow/result';
    public $orderService;
    public $paymentService;


    public function __construct()
    {
        $this->paynow = new Paynow($this->id,$this->key,$this->returnUrl,$this->resultUrl);
        $this->orderService = new OrderService();
        $this->paymentService = new PaymentService();
    }


    public function makeMobilePayment($order)
    {
        if($this->orderService->verifyOrder($order)){
            $this->orderService->createOrder($order);
            $this->paymentService->createPayment($order);
            $payment=$this->paynow->createPayment($order->reference,$order->email);
            foreach($order->items as $item){

                $payment->add(str_replace(' ','-', $item['name']), $item['price']);
            }
            $res = $this->paynow->sendMobile($payment, $order->phone, $order->network);

            return true;
        }
        else{
            return false;
        }


    }

    public function makeBankPayment($order)
    {
        if($this->orderService->verifyOrder($order)){
            $this->paymentService->createPayment($order);
            $payment=$this->paynow->createPayment($order->reference,$order->email);
            foreach($order->items as $item){
                $payment->add($item->name,$item->price);
            }
            $response = $this->paynow->send($payment);
            return true;
        }
        return false;

    }





}
