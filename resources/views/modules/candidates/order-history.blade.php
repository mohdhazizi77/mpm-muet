@extends('layouts.master-candidate')
@section('title')
    MUET Online Certificate
@endsection

@section('css')
    <style>
    </style>
@endsection

@section('content')

    <div class="container">
        {{-- <div class="container-fluid"> --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">
                        <div class="px-4">
                            <div class="py-4">
                                <h4 class="mb-4">TRANSACTION LIST</h4>
                                <!-- Striped Rows -->
                                <table id="orderTable" data-id="{{ $cryptId }}" class="table fs-12 w-100 table-striped dt-responsive nowrap dataTable"
                                        style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr class="text-center bg-dark-subtle">
                                            <th scope="col">#</th>
                                            <th scope="col">DATE CREATED</th>
                                            <th scope="col">REFERENCE ID</th>
                                            <th scope="col">TYPE</th>
                                            <th scope="col">STATUS</th>
                                            <th scope="col">ACTION</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Example rows (commented out) --}}
                                        {{-- <tr class="align-middle">
                                            <th scope="row">1</th>
                                            <td>09/12/2023 12:30:00</td>
                                            <td></td>
                                            <td><h5><span class="badge rounded-pill bg-info">PROCESSING</span></h5></td>
                                            <td>Action buttons</td>
                                        </tr>
                                        <tr class="align-middle">
                                            <th scope="row">2</th>
                                            <td>10/12/2023 13:30:00</td>
                                            <td>Tracking Number : <a target="_blank" href="https://www.tracking.my/pos/ABC123">ABC123</a></td>
                                            <td><h5><span class="badge rounded-pill bg-success">COMPLETED</span></h5></td>
                                            <td>Action buttons</td>
                                        </tr> --}}
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

            <div class="row mt-4">
                <div class="col-lg-12">
                    {{-- <x-button.back></x-button.back> --}}
                    <a href="{{ route('candidate.index') }}" class="btn btn-soft-dark fs-12 btn-label btn-border btn-outline-dark waves-effect waves-light w-lg float-start"><i class="ri-reply-fill label-icon align-middle fs-12 me-2"></i>BACK TO MAIN PAGE</a>
                </div>
            </div>
        {{-- </div> --}}
    </div>
@endsection

