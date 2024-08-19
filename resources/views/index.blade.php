@extends('layout.index')

@section('content')
    <div class="flex h-full justify-center items-center gap-x-4 flex-wrap overflow-auto py-2 px-4">
        @can('monitoring')
            @include('module.monitoring')
        @endcan
        @can('belanja_51')
            @include('module.belanja51')
            @include('module.belanja51-v2')
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
