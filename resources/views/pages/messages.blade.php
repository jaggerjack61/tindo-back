@extends('layouts.secondary')

@section('content')
    @include('layouts.includes.header')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Messages</span></h4>

            <!-- Basic Bootstrap Table -->



            <!-- Hoverable Table rows -->
            <div class="card">
                @include('layouts.includes.message')

                        <h5 class="card-header">{{$results->where('status','unread')->count()}} Unread Messages</h5>


                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Action</th>




                        </tr>
                        </thead>
                        <tbody>

                        @foreach($results as $result)

                                <tr>
                                    <td>{{$result->name}}</td>
                                    <td>{{$result->email}}</td>
                                    <td>{{$result->subject}}</td>
                                    <td>{{optional($result)->created_at->diffForHumans()}}</td>
                                    <td>{{$result->status}}</td>
                                    <td>
                                        @if ($result->status == 'unread')
                                            <a href="{{route('read-message',[$result->id])}}" class="btn btn-sm btn-primary">Mark as Read</a>
                                        @elseif ($result->status == 'read')
                                            <a href="{{route('unread-message',[$result->id])}}" class="btn btn-sm btn-secondary">Mark As Unread</a>

                                        @endif

                                        <a href="" class="btn btn-sm btn-success" onclick="setMessage('{{$result->email}}','{{$result->subject}}','{{$result->content}}','{{$result->name}}')" data-bs-toggle="modal" data-bs-target="#viewPaintingModal">View Message</a>
                                    </td>
                                </tr>
                        @endforeach
                        </tbody>


                    </table>


                </div>
            </div>

            <!--/ Hoverable Table rows -->

            <hr class="my-5" />
            {{$results->links()}}


            <!--/ Responsive Table -->
        </div>
        <!-- / Content -->



        <div class="content-backdrop fade"></div>
    </div>


    <div  class="modal fade" id="viewPaintingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        function setMessage(email, subject, message,name) {
            document.getElementById("email").innerHTML = email;
            document.getElementById("subject").innerHTML = subject;
            document.getElementById("message").innerHTML = message + "<br><br>" + "From " +name;

        }
    </script>


@endsection
