@extends('layouts.secondary')

@section('content')
@livewireStyles
    @include('layouts.includes.header')
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Reports</span></h4>

            <!-- Basic Bootstrap Table -->


            <!-- Hoverable Table rows -->
            <div class="card">
                @include('layouts.includes.message')

                <h5 class="card-header">Calculate Revenue</h5>

                <div class="card-body">
                    <livewire:reports />
                </div>


            </div>
        </div>

        <!--/ Hoverable Table rows -->

        <hr class="my-5"/>


        <!--/ Responsive Table -->
    </div>
    <!-- / Content -->



    <div class="content-backdrop fade"></div>



@livewireScripts
@endsection
