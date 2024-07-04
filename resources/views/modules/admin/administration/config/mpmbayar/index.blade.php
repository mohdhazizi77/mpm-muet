@extends('layouts.master-mpm')
@section('title')
    POS Management
@endsection
@section('css')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Administration
        @endslot
        @slot('title')
            MPM Bayar Integration
        @endslot
    @endcomponent

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row py-1 px-3">
        <div class="col-lg-12">
            <div class="card rounded-0 bg-white mx-n4  border-top card-custom mb-2">
                <div class="card-body">
                    <form action="{{ route('config.mpmbayar.update') }}" method="POST">
                        @csrf

                        <div class="form-group mt-2">
                            <label for="url">URL</label>
                            <input type="text" class="form-control" id="url" name="url" value="{{ old('url', $configMpmBayar->url ?? '') }}" required>
                        </div>

                        <div class="form-group mt-2">
                            <label for="token">Token</label>
                            <input type="text" class="form-control" id="token" name="token" value="{{ old('token', $configMpmBayar->token ?? '') }}" required>
                        </div>

                        <div class="form-group mt-2">
                            <label for="secret_key">Secret Key</label>
                            <input type="text" class="form-control" id="secret_key" name="secret_key" value="{{ old('secret_key', $configMpmBayar->secret_key ?? '') }}" required>
                        </div>
                        <input type="hidden" name="id" value="{{ old('secret_key', $configMpmBayar->id ?? '') }}">
                        <button type="submit" class="btn btn-primary mt-2 float-end">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5">
    </div>
@endsection
@section('script')

@endsection
