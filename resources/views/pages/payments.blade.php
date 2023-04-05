@extends('layouts.secondary')

@section('content')
    @include('layouts.includes.header')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Payments</span></h4>

            <!-- Basic Bootstrap Table -->


            <!-- Hoverable Table rows -->
            <div class="card">
                @include('layouts.includes.message')

                <h5 class="card-header">{{$results->count()}} Payments</h5>


                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Address</th>
                            <th>Date</th>
                            <th>Delivery Status</th>
                            <th>Action</th>


                        </tr>
                        </thead>
                        <tbody>

                        @foreach($results as $result)

                            <tr>
                                <td>{{$result->order->user->name}}</td>
                                <td>${{number_format($result->amount,2)}}</td>
                                <td>{{$result->order->address}}</td>
                                <td>{{$result->created_at->diffForHumans()}}</td>
                                <td>{{$result->order->delivery_status}}</td>
                                <td>
                                    {{--                                    @if ($result->status == 'unread')--}}
                                    {{--                                        <a href="{{route('read-payment',[$result->id])}}"--}}
                                    {{--                                           class="btn btn-sm btn-primary">Mark as Read</a>--}}
                                    {{--                                    @elseif ($result->status == 'read')--}}
                                    {{--                                        <a href="{{route('unread-payment',[$result->id])}}"--}}
                                    {{--                                           class="btn btn-sm btn-secondary">Mark As Unread</a>--}}

                                    {{--                                    @endif--}}
                                    {{--                                    @if ($result->status == 'unread')--}}
                                    {{--                                        <a href="{{route('deliver-payment',[$result->id])}}"--}}
                                    {{--                                           class="btn btn-sm btn-outline-primary">Mark as Delivered</a>--}}
                                    {{--                                    @elseif ($result->status == 'read')--}}
                                    {{--                                        <a href="{{route('undeliver-payment',[$result->id])}}"--}}
                                    {{--                                           class="btn btn-sm btn-outline-secondary">Mark As Undelivered</a>--}}
                                    {{--                                    @endif--}}

                                    <a href="" class="btn btn-sm btn-success"
                                       onclick="setMessage('{{$result->email}}','{{$result->subject}}','{{$result->content}}','{{$result->name}}')"
                                       data-bs-toggle="modal" data-bs-target="#viewPaintingModal{{$result->id}}">View
                                        Items</a>
                                    @if($result->order->delivery_status == 'pending')
                                    <a href="{{route('mark-delivered',[$result->order->id])}}" class="btn btn-sm btn-primary" >Mark as Delivered</a>
                                    @else
                                        <a href="{{route('mark-undelivered',[$result->order->id])}}" class="btn btn-sm btn-info" >Mark as Undelivered</a>
                                    @endif
                                </td>

                            </tr>
                            <div class="modal fade" id="viewPaintingModal{{$result->id}}" tabindex="-1"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">


                                            <h5 class="modal-title">Order Items</h5>


                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <span class="col-6 text-primary">Name</span>
                                                <span class="col-6 text-primary">Price</span>
                                            </div>



                                            @foreach($result->order->items as $item)
                                                <div class="row">
                                                    <span class="col-6 my-2">{{$item->item_name}}</span>
                                                    <span class="col-6 my-2">${{$item->item_price}}</span>
                                                </div>


                                            @endforeach


                                        </div>
                                    </div>
                                </div>
                            </div>

                        @endforeach
                        </tbody>


                    </table>


                </div>
            </div>

            <!--/ Hoverable Table rows -->

            <hr class="my-5"/>
            {{$results->links()}}


            <!--/ Responsive Table -->
        </div>
        <!-- / Content -->


        <div class="content-backdrop fade"></div>
    </div>


    <div class="modal fade" id="viewPaintingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">


                    <h5 class="modal-title" id="subject"></h5>


                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <h6 id="email"></h6>

                    <p id="message"></p>
                </div>
            </div>
        </div>

        <script>
            function setMessage(email, subject, message, name) {
                document.getElementById("email").innerHTML = email;
                document.getElementById("subject").innerHTML = subject;
                document.getElementById("message").innerHTML = message + "<br><br>" + "From " + name;

            }
        </script>

@endsection
