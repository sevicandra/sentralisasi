@extends('layout.main')
@section('aside-menu')
    @include('pembayaran.sidemenu')
@endsection         
@section('main-content')

    <div id="main-content-header">
        <div class="row">
        </div>
    </div>
    <div id="main-content">
        <div>
            <div >
                @include('layout.flashmessage')
            </div>
        </div>
        <div class="table-warper">
                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr class="align-middle">
                            <th>No</th>
                            <th>Uraian</th>
                            <th>Tgl</th>
                            <th>File</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < 100; $i++)
                        <tr class="align-middle">
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endfor
                    </tbody>
                </table>
        </div>
    </div>
    <div id="paginator">
        {{-- {{$data->links()}} --}}
    </div>


@endsection