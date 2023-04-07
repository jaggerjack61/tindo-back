<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function showPayments()
    {
        $results = Payment::orWhere('status','Paid')->orWhere('status','Awaiting Delivery')->orderBy('created_at', 'desc')->paginate(30);
        return view('pages.payments',compact('results'));
    }
}
