<?php

namespace App\Http\Services;
use App\Models\Painting;
use Paynow\Payments\Paynow;

class PaynowService{

    public $id = '15485';
    public $key = 'df033924-f9bb-4056-bc77-934657ee2ab1';
    public $returnUrl = 'https://c506-104-223-93-213.ngrok.io/paynow/return';
    public  $resultUrl = 'https://c506-104-223-93-213.ngrok.io/api/paynow/result';
    public $order;


    public function __construct()
    {
        $this->paynow = new Paynow($this->id,$this->key,$this->returnUrl,$this->resultUrl);
        $this->order = new OrderService();
    }


    public function makeMobilePayment($order)
    {
        if($this->order->verifyOrder($order)){
            $payment=$this->paynow->createPayment($order->uniqueId,$order->email);
            foreach($order->items as $item){
                $payment->add($item->name,$item->price);
            }
            $response = $this->paynow->sendMobile($payment, $order->phone, $order->network);
            return true;
        }
        else{
            return false;
        }


    }

    public function makeBankPayment($order)
    {
        if($this->order->verifyOrder($order)){
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
