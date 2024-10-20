@extends('layouts.master-mpm')
@section('title')
    POS Management
@endsection
@section('css')


@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            POS Management
        @endslot
        @slot('title')
            Tracking
        @endslot
    @endcomponent

    <div class="row px-1">
        <div class="card rounded-0 bg-white border-top px-2">
            <div class="p-2">
                <div class="row mb-3">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 mt-2">
                        <label for="text-search" class="form-label">Consignment Note Number:</label>
                        <input type="text" id="trackingNo" class="form-control" placeholder="">
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6 mt-2" style="align-content: end;">
                            <button id="trackBtn" class="btn btn-primary">Track</button>
                            <button id="resetTrackBtn" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row py-4 px-3">
        <div class="col-lg-12">
            <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">
                <div class="px-1">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card rounded-0 bg-white border-top p-2">
                                <label for="" class="my-3">TRACKING NUMBER : <span class="textTrackingNo">-</span> </label>
                                {{-- <table id="trackShippingTable" data-id="{{ $cryptId }}" data-trackno="{{ $order->tracking_number }}" class="table table-striped text-center"> --}}
                                <table id="AdminTrackShippingTable" class="table table-striped text-center">
                                    <thead>
                                        <tr class="text-center bg-dark-subtle">
                                            <th scope="col">#</th>
                                            <th scope="col">DATE AND TIME</th>
                                            <th scope="col">DETAIL</th>
                                            {{-- <th scope="col">STATUS</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <!-- end card body -->
                            </div>
                            <!-- end card -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
@section('script')

@endsection

