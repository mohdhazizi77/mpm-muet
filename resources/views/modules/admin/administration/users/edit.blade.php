@extends('layouts.master-mpm')
@section('title')
    Administration
@endsection
@section('css')
    {{-- <!-- DataTables --> --}}

    <link href="{{ URL::asset('build/libs/jquery-datatables-checkboxes-1.2.12/css/dataTables.checkboxes.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('build/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/classic.min.css') }}"/> <!-- 'classic' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/monolith.min.css') }}"/> <!-- 'monolith' theme -->
    <link rel="stylesheet" href="{{ URL::asset('build/libs/@simonwep/pickr/themes/nano.min.css') }}"/> <!-- 'nano' theme -->
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Administration
        @endslot
        @slot('title')
            Users
        @endslot
    @endcomponent
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row py-4">
        <div class="col-lg-12">
            <div class="card rounded-0 bg-white mx-n4 mt-n4 border-top">
                <div class="px-4">
                    <form action={{ route('users.update', ['user' => $user->id]) }} method="POST">
                        @csrf
                        @method('POST')
                        <div class="row py-4">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                                </div>
                            </div><!--end col-->

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" autocomplete="off" value="{{ $user->email }}">
                                </div>
                            </div><!--end col-->

                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="phonenumber" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" id="phonenumber" name="phonenumber" autocomplete="off" value="{{ $user->phone_num }}">
                                </div>
                            </div><!--end col-->

                            <div class="col-6">
                                <label for="role" class="form-label">Role</label>
                                <select name="role" id="" class="form-control">
                                    @foreach ($role as $role)
                                        <option value="{{ $role->name }}" {{ ($user->getRoleNames()[0] == $role->name) ? "selected" : "" }} >{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-6">
                                <label for="role" class="form-label">Status</label>
                                <select name="status" id="" class="form-control">
                                    <option value=""></option>
                                    @foreach (array('Active', 'Inactive' ) as $k => $v)
                                        <option value={{ $k }} {{ ($user->is_deleted == $k) ? "selected" : "" }} >{{ $v }}</option>   
                                    @endforeach
                                </select>                        
                            </div>

                        </div><!--end row-->

                        
                        <div class="row">
                            <div class="col-xxl-12 align-self-center">
                                <div class="float-start my-3">
                                    {{--                                <button id="button-export-xlsx" type="button" class="btn btn-soft-secondary waves-effect float-end mx-1">EXPORT XLSX</button>--}}
                                </div>
                                <div class="float-end my-3">
                                    <button onclick="history.back()" type="button" class="btn btn-soft-dark waves-effect" style="margin-right: 5px">Back</button>
                                    <button class="btn btn-soft-success waves-effect float-end" type="submit">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- end card body -->
                </div>
                <!-- end card -->

            </div>
            <!--end col-->
        </div>

        @endsection
        @section('script')
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

            <script>


                $(document).ready(function () {

                    $('#button-export-xlsx').on('click', function (e) {

                        e.preventDefault();
                        window.location.href = 'pos-new/export-xlsx';

                    })

                    $("#basicDate").flatpickr(
                        {
                            mode: "range",
                            dateFormat: "d-m-Y",
                        }
                    );
                });


            </script>

            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

            <script src="{{ URL::asset('build/libs/datatables/datatables.min.js') }}"></script>
            <script src="{{ URL::asset('build/libs/jquery-datatables-checkboxes-1.2.12/js/dataTables.checkboxes.js') }}"></script>

@endsection

