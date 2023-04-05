@extends('layouts.secondary')

@section('content')
    @include('layouts.includes.header')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Users</span></h4>

            <!-- Basic Bootstrap Table -->



            <!-- Hoverable Table rows -->
            <div class="card">
                @include('layouts.includes.message')
                <div class="row">
                    <div class="col-9">
                        <h5 class="card-header">{{$results->count()}} Users</h5>
                    </div>
                    <div class="col-3">
                        <a href="" class="btn btn-sm btn-success float-end m-1" data-bs-toggle="modal" data-bs-target="#newUserModal">New User</a>
                    </div>
                </div>

                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Access LeveL</th>
                            <th>Status</th>
                            <th>Action</th>




                        </tr>
                        </thead>
                        <tbody>

                        @foreach($results as $result)
                            @if($result->email != "admin@example.com")
                                <tr>
                                    <td>{{$result->name}}</td>
                                    <td>{{$result->email}}</td>
                                    <td>{{$result->access_level}}</td>
                                    <td>{{$result->status}}</td>
                                    <td>
                                        @if($result->access_level == 'admin')
                                            <a href="{{route('demote-user',$result->id)}}" class="btn btn-sm btn-outline-primary">Demote to User</a>
                                        @else
                                            <a href="{{route('promote-user',$result->id)}}" class="btn btn-sm btn-primary">Promote to Admin</a>
                                        @endif
                                        @if($result->status == 'active')
                                                <a href="{{route('deactivate-user',$result->id)}}" class="btn btn-sm btn-info">Deactivate</a>
                                        @else
                                                <a href="{{route('activate-user',$result->id)}}" class="btn btn-sm btn-outline-info">Activate</a>
                                        @endif





                                    </td>
                                </tr>
                            @endif

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

    <div  class="modal fade" id="newUserModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <form action="{{route('new-user')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" id="edit_id" />
                            <label for="edit_name">Full Name</label>
                            <input type="text" name="name" class="form-control" id="edit_name" placeholder="Your name" required />
                            <label for="edit_description">Email Address</label>
                            <input type="email" name="email" class="form-control" id="edit_description" placeholder="Your email" required />
                            <label for="edit_type">Password</label>
                            <input type="password" name="password" class="form-control" id="edit_type" placeholder="Your password" required />
                            <div class="my-2">
                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div  class="modal fade" id="viewPaintingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">


                    <h5 class="modal-title" id="viewModalTitle"></h5>


                    <span class="mx-3" id="viewPrice"></span>




                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="viewType"></p>
                    <p id="viewDimensions"></p>
                    <div>
                        <img id="viewImage" width="100% "/>
                    </div>
                    <p id="viewDescription"></p>

                </div>

            </div>
        </div>
    </div>




@endsection
