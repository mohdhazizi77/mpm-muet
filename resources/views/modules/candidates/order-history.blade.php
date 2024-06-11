@extends('layouts.master-candidate')
@section('title')
    MUET Online Certificate
@endsection

@section('css')

@endsection

@section('content')

    <div class="container">
        <div class="row">

            <div class="row py-4">
                <div class="col-lg-12">
                    <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">
                        <div class="px-4">
                            <div class="row">
                                <div class="col-xxl-12 align-self-center">
                                    <div class="py-4">
                                        <h2 class="">ORDER LIST</h2>
                                        <!-- Striped Rows -->
                                        <table id="orderTable" data-id="{{ $cryptId }}" class="table table-striped text-center">
                                            <thead>
                                                <tr class="text-center bg-dark-subtle">
                                                    <th scope="col">NO.</th>
                                                    {{-- <th scope="col">ORDER ID</th> --}}
                                                    <th scope="col">DATE TIME</th>
                                                    <th scope="col">DETAIL</th>
                                                    <th scope="col">PAYMENT STATUS</th>
                                                    <th scope="col">ACTION</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {{-- <tr class="align-middle">
                                                <th scope="row">1</th>
                                                <td>09/12/2023 12:30:00</td>
                                                <td></td>
                                                <td><h5><span class="badge rounded-pill bg-info">PROCESSING</span></h5></td>
                                            </tr>
                                            <tr class="align-middle">
                                                <th scope="row">2</th>
                                                <td>10/12/2023 13:30:00</td>
                                                <td>Tracking Number : <a target="_blank" href="https://www.tracking.my/pos/ABC123">ABC123</a></td>
                                                <td><h5><span class="badge rounded-pill bg-success">COMPLETED</span></h5></td>
                                            </tr> --}}

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                </div>
                <!--end col-->
            </div>

            <div>

                <x-button.back></x-button.back>
            </div>


        </div>
    </div>
@endsection

