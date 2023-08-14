@extends('layout.index')

@section('head')
<link rel="stylesheet" href="/css/home.css">
@endsection

@section('content')
<div class="main-content-warper">
    @can('monitoring')
        @include('module.monitoring')
    @endcan
    @can('belanja_51')
        @include('module.belanja51')
    @endcan
    @can('honorarium')
        @include('module.honorarium')
    @endcan
        @include('module.dataPayment')
    @can('spt')
        @include('module.spt')
    @endcan
    @can('rumdin')
        @include('module.rumdin')
    @endcan
    @include('module.admin')
</div>
@endsection
