@extends('layout.main')
@section('aside-menu')
    @include('monitoring.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 flex-wrap py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap">
                @foreach ($tahun as $item)
                    <a href="{{ config('app.url') }}/monitoring/pelaporan/{{ $satker->kdsatker }}/pph-pasal-21/{{ $nip }}/{{ $item->tahun }}"
                        class="btn btn-xs btn-primary btn-outline @if ($thn === $item->tahun) btn-active @endif">{{ $item->tahun }}</a>
                @endforeach
            </div>
        </div>
        <div class="overflow-hidden px-4 pb-2">
            <iframe class="w-full h-full" src="data:application/pdf;base64,{{ base64_encode($formA2) }}"
                frameborder="0"></iframe>
        </div>
        <div>
            {{-- {{$data->links()}} --}}
        </div>
    </div>
@endsection