<?php

namespace App\Http\Services;
use App\Models\Painting;
use App\Models\WhatsappSetting;
use Paynow\Payments\Paynow;

class PaynowService{

    public $id = '15485';
    public $key = 'df033924-f9bb-4056-bc77-934657ee2ab1';
    public $returnUrl = 'https://c506-104-223-93-213.ngrok.io/paynow/return';
    public  $resultUrl = 'https://c506-104-223-93-213.ngrok.io/api/paynow/result';


    public function __construct()
    {
        $this->paynow = new Paynow($this->id,$this->key,$this->returnUrl,$this->resultUrl);
    }


    public function makeMobilePayment($uniqueId,$email,$phone,$network,$order)
    {
        if($this->verifyOrder($order)){
            $payment=$this->paynow->createPayment($uniqueId,$email);
            foreach($order as $item){
                $payment->add($item->name,$item->price);
            }
            $response = $this->paynow->sendMobile($payment, $phone, $network);
            return true;
        }
        else{
            return false;
        }


    }

    public function makeBankPayment($uniqueId,$email,$order)
    {
        if($this->verifyOrder($order)){
            $payment=$this->paynow->createPayment($uniqueId,$email);
            foreach($order as $item){
                $payment->add($item->name,$item->price);
            }
            $response = $this->paynow->send($payment);
            return true;
        }
        return false;

    }

    public function verifyOrder($order)
    {
        foreach($order as $item){
            if(!Painting::find($item->id)->status=='available'){
                return false;
            }
        }
        return true;
    }



}
