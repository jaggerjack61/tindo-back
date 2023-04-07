<?php

namespace App\Http\Services;
use App\Models\Painting;
use Illuminate\Support\Facades\Log;
use Paynow\Payments\Paynow;

class PaynowService{

    public $id = '15940';
    public $key = 'c948f699-74b6-4c28-b5c9-8f89aea6dea3';
    public $returnUrl = 'https://4ec1-77-246-52-32.eu.ngrok.io';
    public  $resultUrl = 'https://4ec1-77-246-52-32.eu.ngrok.io/api/paynow/result';
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
            $this->orderService->createOrder($order);
            $this->paymentService->createPayment($order);
            $payment=$this->paynow->createPayment($order->reference,$order->email);
            foreach($order->items as $item){

                $payment->add(str_replace(' ','-', $item['name']), $item['price']);
            }
            $res = $this->paynow->send($payment);
            if($res->success()){
                return $res->redirectUrl();
            }
            log::info(json_encode($res));

            return true;
        }
        else{
            return false;
        }

    }





}
