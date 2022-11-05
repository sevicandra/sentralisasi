@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">

    </div>
    <div id="main-content">
        <div>
            <div >
                @include('layout.flashmessage')
            </div>
        </div>
        <div class="table-warper" style="overflow-x:auto">
            @yield('beranda_content')
        </div>
    </div>
    <div id="paginator">
        {{$data->links()}}
    </div>


@endsection