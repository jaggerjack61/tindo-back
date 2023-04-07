<?php

namespace App\Http\Livewire;

use App\Models\Payment;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Reports extends Component
{
    public $start = '';
    public $end = '';


    public function render()
    {
//        dd($this->start);
        $start = Carbon::parse($this->start ?: Carbon::now())->startOfDay();
        $end = Carbon::parse($this->end ?: Carbon::now())->endOfDay();
        $results = Payment::whereBetween('created_at', [$start, $end])
            ->where(function(Builder $query) {
                $query->orWhere('status', 'Paid')
                    ->orWhere('status', 'Awaiting Delivery');
            })


            ->get();
        $sum = 0;
        foreach ($results as $result){
            $sum += $result->amount;
        }
        return view('livewire.reports', compact('results','sum'));
    }
}
