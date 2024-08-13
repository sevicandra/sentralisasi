@extends('layout.main')
@section('aside-menu')
    @include('pembayaran.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex flex-col gap-2 py-2 px-4">
            <div class="w-full flex gap-1 flex-wrap">
                @foreach ($tahun as $item)
                    <a href="{{ config('app.url') }}/belanja-51/index/{{ $item }}"
                        class="btn btn-xs btn-outline btn-primary @if ($item === $thn) btn-active @endif">{{ $item }}</a>
                @endforeach
            </div>
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 pb-2">
            <div></div>
            <div class="overflow-x-auto overflow-y-auto h-full w-full p-2">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                    <div class="border rounded-box p-2">
                        <div class="text-lg">
                            <h3>
                                Permohonan Pembayaran Uang Makan
                            </h3>
                        </div>
                        <div>
                            <table class="table table-sm">
                                <thead>
                                    <tr class="*:border">
                                        <th class="text-center">Bulan</th>
                                        <th class="text-center">Dokumen</th>
                                        <th class="text-center">#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <tr class="*:border">
                                            <td class="text-center">{{ $i }}</td>
                                            <td class="text-center">{{ $uangMakan->where('bulan', $i)->count() }}</td>
                                            <td class="text-center">
                                                @if ($uangMakan->where('bulan', $i)->count() > 0)
                                                    <a class="btn btn-xs btn-outline btn-primary"
                                                        href="/belanja-51/uang-makan/{{ $thn }}/{{ $uangMakan->where('bulan', $i)->first()->bulan }}/detail">detail</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="border rounded-box p-2">

                        <div class="text-lg">
                            <h3>
                                Permohonan Pembayaran Uang Lembur
                            </h3>
                        </div>
                        <div>
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr class="*:border">
                                            <th class="text-center">Bulan</th>
                                            <th class="text-center">Dokumen</th>
                                            <th class="text-center">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <tr class="*:border">
                                                <td class="text-center">{{ $i }}</td>
                                                <td class="text-center">{{ $uangLembur->where('bulan', $i)->count() }}</td>
                                                <td class="text-center">
                                                    @if ($uangLembur->where('bulan', $i)->count() > 0)
                                                        <a class="btn btn-xs btn-outline btn-primary"
                                                            href="/belanja-51/uang-lembur/{{ $thn }}/{{ $uangLembur->where('bulan', $i)->first()->bulan }}/detail">detail</a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div>
            {{-- {{$data->links()}} --}}
        </div>
    </div>
@endsection
