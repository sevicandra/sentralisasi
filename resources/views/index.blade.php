@extends('layout.index')

@section('head')
<link rel="stylesheet" href="/css/home.css">
@endsection

@section('content')
<div class="main-content-warper">
    @include('module.monitoring')
    @include('module.belanja51')
    @include('module.honorarium')
    @include('module.dataPayment')
    @include('module.admin')
</div>
@endsection
