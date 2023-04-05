<div>
    <div>


    <div class="card mb-4">
        <h5 class="card-header">Time Periods</h5>
        <div class="card-body">

            <div class="m-1 row">
                <label for="html5-date-input" class="col-md-1 col-form-label">Start Date</label>
                <div class="col-md-4">
                    <input class="form-control" type="date" wire:model="start" value="2021-06-18" id="html5-date-input"/>
                </div>
                <label for="html5-date-input" class="col-md-1 col-form-label">End Date</label>
                <div class="col-md-4">
                    <input class="form-control" wire:model="end" value="2021-06-18" type="date" id="html5-date-input"/>
                </div>


            </div>


        </div>
    </div>
    <table class="table table-responsive">
        <thead>
        <th>User</th>
        <th>Reference</th>
        <th>Amount(RTGS\ZWL)</th>
        <th>Date</th>

        </thead>
        <tbody>
        @foreach($results as $result)
            <tr>
                <td>{{$result->order->user->name}}</td>
                <td>{{$result->reference}}</td>
                <td>${{number_format($result->amount, 2)}}</td>
                <td>{{$result->created_at->diffForHumans()}}</td>
            </tr>
        @endforeach
        <tr>
            <td>Total:</td>
            <td></td>
            <td>${{number_format($sum, 2)}}</td>
        </tr>

        </tbody>
    </table>
</div>
</div>


