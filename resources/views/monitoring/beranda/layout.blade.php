@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
        <div class="row">
            <div class="row">
                <div class="row">
                    <div class="col-lg-12">
                        @foreach ($tahun as $item)
                            <a href="{{ Request::url() }}?jns={{request('jns')}}&thn={{$item->tahun}}" class="btn btn-sm btn-outline-success @if ($item->tahun === request('thn')|| request('thn') === null && $item->tahun === date('Y')) active @endif ml-1 mt-1 mb-1">{{$item->tahun}}</a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="row">
                    <div class="col-lg-12">
                        <a href="{{ Request::url() }}?jns=gaji-rutin&thn={{request('thn')}}" class="btn btn-sm btn-outline-success @if (request('jns') === "gaji-rutin" || request('jns') === null) active @endif ml-1 mt-1 mb-1">gaji rutin</a>
                        <a href="{{ Request::url() }}?jns=kekurangan-gaji&thn={{request('thn')}}" class="btn btn-sm btn-outline-success @if (request('jns') === "kekurangan-gaji") active @endif ml-1 mt-1 mb-1">kekurangangaji</a>
                        <a href="{{ Request::url() }}?jns=uang-makan&thn={{request('thn')}}" class="btn btn-sm btn-outline-success @if (request('jns') === "uang-makan") active @endif ml-1 mt-1 mb-1">uang makan</a>
                        <a href="{{ Request::url() }}?jns=uang-lembur&thn={{request('thn')}}" class="btn btn-sm btn-outline-success @if (request('jns') === "uang-lembur") active @endif ml-1 mt-1 mb-1">uang lembur</a>
                        <a href="{{ Request::url() }}?jns=tukin-rutin&thn={{request('thn')}}" class="btn btn-sm btn-outline-success @if (request('jns') === "tukin-rutin") active @endif ml-1 mt-1 mb-1">tukin rutin</a>
                        <a href="{{ Request::url() }}?jns=kekurangan-tukin&thn={{request('thn')}}" class="btn btn-sm btn-outline-success @if (request('jns') === "kekurangan-tukin") active @endif ml-1 mt-1 mb-1">kekurangan tukin</a>
                    </div>
                </div>
            </div>
        </div>
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
        {{-- {{$data->links()}} --}}
    </div>


@endsection