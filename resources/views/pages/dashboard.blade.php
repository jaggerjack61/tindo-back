@extends('layouts.secondary')

@section('content')
    @include('layouts.includes.header')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard</span></h4>

            <!-- Basic Bootstrap Table -->



            <!-- Hoverable Table rows -->
            <div class="card">
                @include('layouts.includes.message')
                <div class="row">
                    <div class="col-9">
                        <h5 class="card-header">{{$results->where('status','!=','deleted')->count()}} Paintings</h5>
                    </div>
                    <div class="col-3">
                        <a href="" class="btn btn-sm btn-success float-end m-1" data-bs-toggle="modal" data-bs-target="#addPaintingModal">New Painting</a>
                    </div>
                </div>

                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Dimensions</th>
                            <th>Price(ZWL)</th>
                            <th>Status</th>
                            <th>Action</th>




                        </tr>
                        </thead>
                        <tbody>

                        @foreach($results as $result)
                            @if($result->status != 'deleted')
                            <tr>
                                <td>{{$result->name}}</td>
                                <td>{{$result->type}}</td>
                                <td>{{$result->dimensions}}</td>
                                <td>{{$result->price}}</td>
                                <td>{{$result->status}}</td>
                                <td>
                                    @if ($result->status == 'available')
                                    <a href="{{route('hide-painting',[$result->id])}}" class="btn btn-sm btn-primary">Hide</a>
                                    <a href="{{route('sell-painting',[$result->id])}}" class="btn btn-sm btn-secondary">Mark As Sold</a>
                                    <a href="{{route('delete-painting',[$result->id])}}" class="btn btn-sm btn-danger">Delete</a>
                                    @elseif ($result->status == 'sold')
                                        <a href="{{route('hide-painting',[$result->id])}}" class="btn btn-sm btn-primary">Hide</a>
                                        <a href="{{route('restore-painting',[$result->id])}}" class="btn btn-sm btn-secondary">Mark As Available</a>
                                        <a href="{{route('delete-painting',[$result->id])}}" class="btn btn-sm btn-danger">Delete</a>
                                    @elseif ($result->status == 'hidden')
                                        <a href="{{route('sell-painting',[$result->id])}}" class="btn btn-sm btn-primary">Mark as Sold</a>
                                        <a href="{{route('restore-painting',[$result->id])}}" class="btn btn-sm btn-secondary">Mark As Available</a>
                                        <a href="{{route('delete-painting',[$result->id])}}" class="btn btn-sm btn-danger">Delete</a>
                                    @endif
                                    <a href="" class="btn btn-sm btn-info" onclick="editPainting('{{$result->id}}','{{$result->name}}','{{$result->type}}','{{$result->dimensions}}','{{$result->price}}','{{$result->description}}')" data-bs-toggle="modal" data-bs-target="#editPaintingModal">Edit Painting</a>
                                    <a href="" class="btn btn-sm btn-success" onclick="setImage('{{$result->url}}','{{$result->name}}','{{$result->type}}','{{$result->dimensions}}','{{$result->price}}','{{$result->description}}')" data-bs-toggle="modal" data-bs-target="#viewPaintingModal">View Painting</a>
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
    <div  class="modal fade" id="addPaintingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Painting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <form action="{{route('store-painting')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <label for="name">Painting Name</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Name" required />
                            <label for="description">Painting Description</label>
                            <input type="text" name="description" class="form-control" id="description" placeholder="Description" required />
                            <label for="type">Painting Type</label>
                            <input type="text" name="type" class="form-control" id="type" placeholder="Type" required />
                            <label for="dimensions">Painting Dimensions</label>
                            <input type="text" name="dimensions" class="form-control" id="dimensions" placeholder="Dimensions" required />
                            <label for="price">Painting Price</label>
                            <input type="number" step="0.01" name="price" class="form-control" id="price" placeholder="Price" required />
                            <label for="file">Painting File</label>
                            <input type="file" name="file" class="form-control" id="file" placeholder="Painting name" required />
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
    <div  class="modal fade" id="editPaintingModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Painting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <form action="{{route('edit-painting')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" id="edit_id" />
                            <label for="edit_name">Painting Name</label>
                            <input type="text" name="edit_name" class="form-control" id="edit_name" placeholder="Name" required />
                            <label for="edit_description">Painting Description</label>
                            <input type="text" name="edit_description" class="form-control" id="edit_description" placeholder="Description" required />
                            <label for="edit_type">Painting Type</label>
                            <input type="text" name="edit_type" class="form-control" id="edit_type" placeholder="Type" required />
                            <label for="edit_dimensions">Painting Dimensions</label>
                            <input type="text" name="edit_dimensions" class="form-control" id="edit_dimensions" placeholder="Dimensions" required />
                            <label for="edit_price">Painting Price</label>
                            <input type="number" step="0.01" name="edit_price" class="form-control" id="edit_price" placeholder="Price" required />
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

    <script>
        function setImage(img, title, type, dimensions, price, description) {
            console.log(img);
            document.getElementById("viewImage").src = img;
            document.getElementById("viewModalTitle").innerHTML = title;
            document.getElementById("viewType").innerHTML = type;
            document.getElementById("viewDimensions").innerHTML = dimensions;
            document.getElementById("viewDescription").innerHTML = description;
            document.getElementById("viewPrice").innerHTML ="ZWL $"+price;


        }
        function editPainting(id, name, type, dimensions, price, description){
            document.getElementById("edit_id").value = id;
            document.getElementById("edit_name").value = name;
            document.getElementById("edit_type").value = type;
            document.getElementById("edit_dimensions").value = dimensions;
            document.getElementById("edit_description").value = description;
            document.getElementById("edit_price").value =price;
        }
    </script>


@endsection
