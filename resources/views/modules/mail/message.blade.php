@extends('modules.mail.app')

@section('content')
@if(isset($subject) && $subject !== null && $subject !== '')
    <h3 style="text-align: center">{{ $subject }}</h3>
@endif

@if(isset($word) && $word !== null && $word !== '')
    <p class="p">
        {!! $word !!}
    </p>
@endif

@if(isset($linkUrl) && $linkUrl !== null && $linkUrl !== '')
    <div style="text-align: center; padding-top: 10px; padding-bottom: 30px;">
        <a class="btn btn-primary p" style="color: #fff; background-color: #3699ff; border-color: #3699ff;" href="{{ $linkUrl }}">Pergi ke Halaman</a>
    </div>
@endif

@endsection
