@extends('layout.main')
@section('aside-menu')
    @include('data-payment.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 flex-wrap py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap">
                @foreach ($tahun as $item)
                    <a href="{{ config('app.url') }}/data-payment/upload/honorarium/?thn={{ $item->tahun }}"
                        class="btn btn-xs btn-outline btn-primary @if ((!$thn && $item->tahun === date('Y')) || $item->tahun === $thn) btn-active @endif">{{ $item->tahun }}</a>
                @endforeach
            </div>
            <div class="w-full flex gap-1 flex-wrap">
                @foreach ($bulan as $item)
                    <a href="{{ config('app.url') }}/data-payment/upload/honorarium/?thn={{ $thn }}&bln={{ $item->bulan }}"
                        class="btn btn-xs btn-outline btn-primary @if ((!$bln && $item->bulan === date('m')) || $item->bulan === $bln) btn-active @endif">{{ $item->bulan }}</a>
                @endforeach
            </div>
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 pb-2">
            <div>
                <div>
                    @include('layout.flashmessage')
                </div>
            </div>
            <div class="overflow-x-auto overflow-y-auto h-full w-full">
                <x-table class="collapse">
                    <x-table.header>
                        <tr class="*:border-x *:text-center">
                            <x-table.header.column>No</x-table.header.column>
                            <x-table.header.column>Satker</x-table.header.column>
                            <x-table.header.column>Jml Pegawai</x-tabl.header.column>
                            <x-table.header.column>Bruto</x-tabl.header.column>
                            <x-table.header.column>PPh</x-tabl.header.column>
                            <x-table.header.column>Netto</x-tabl.header.column>
                            <x-table.header.column>File</x-table.header.column>
                            <x-table.header.column>#</x-tabl.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->nmsatker }}</x-table.body.column>
                                <x-table.body.column class="text-center">{{ $item->jmh }}</x-table.body.column>
                                <x-table.body.column class="text-right">{{ number_format($item->bruto, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column class="text-right">{{ number_format($item->pph, 2, ',', '.') }}</x-table.body.column>
                                <x-table.body.column class="text-right">{{ number_format($item->bruto - $item->pph, 2, ',', '.') }}
                                </x-table.body.column>
                                <x-table.body.column class="text-center">
                                    <form action="/data-payment/upload/honorarium/{{ $item->file }}/dokumen"
                                        method="get" target="_blank">
                                        @csrf
                                        <button class="btn btn-xs btn-outline btn-primary">file</button>
                                    </form>
                                </x-table.body.column>
                                <x-table.body.column>
                                  <div class="w-full h-full flex gap-1 justify-center">
                                    <form action="/data-payment/upload/honorarium/{{ $item->file }}" method="post">
                                        @can('adm_server', auth()->user()->id)
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Apakah Anda yakin akan menghapus data ini?');"
                                                type="submit" class="btn btn-xs btn-error">tolak</button>
                                        @endcan
                                        <a href="/data-payment/upload/honorarium/{{ $item->file }}/detail"
                                            data-toggle="tooltip" data-placement="bottom" title="detail"
                                            class="btn btn-xs btn-primary">detail</a>
                                    </form>

                                  </div>
                                </x-table.body.column>
                            </tr>
                        @endforeach
                    </x-table.body>
                </x-table>
            </div>
        </div>
        <div id="paginator">
            {{ $data->links() }}
        </div>
    </div>
@endsection
