@extends('layouts.secondary')

@section('content')
    @include('layouts.includes.header')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Profile</span></h4>

            <!-- Basic Bootstrap Table -->


            <!-- Hoverable Table rows -->
            <div class="card">
                @include('layouts.includes.message')

                <h5 class="card-header">User Details</h5>

                <div class="card-body">
                    <form action="{{route('save-profile')}}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-fullname">Name</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                              <span id="basic-icon-default-fullname2" class="input-group-text"
                              ><i class="bx bx-user"></i
                                  ></span>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="basic-icon-default-fullname"
                                        name="name"
                                        value="{{auth()->user()->name}}"
                                        aria-describedby="basic-icon-default-fullname2"
                                        required
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-icon-default-email">Email</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input
                                        type="text"
                                        id="basic-icon-default-email"
                                        class="form-control"
                                        name="email"
                                        value="{{auth()->user()->email}}"
                                        aria-describedby="basic-icon-default-email2"
                                        disabled
                                    />

                                </div>

                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 form-label" for="basic-icon-default-phone">Password</label>
                            <div class="col-sm-10">
                                <div class="input-group input-group-merge">
                              <span id="basic-icon-default-phone2" class="input-group-text"
                              ><i class="bx bx-lock"></i
                                  ></span>
                                    <input
                                        type="text"
                                        id="basic-icon-default-phone"
                                        class="form-control phone-mask"
                                        name="pass"
                                        placeholder="Leave blank to indicate no chnange to your password"

                                    />
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </form>
                </div>


            </div>
        </div>

        <!--/ Hoverable Table rows -->

        <hr class="my-5"/>


        <!--/ Responsive Table -->
    </div>
    <!-- / Content -->



    <div class="content-backdrop fade"></div>
    </div>

@endsection
