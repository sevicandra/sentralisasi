@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">

    </div>
    <div id="main-content">

    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection