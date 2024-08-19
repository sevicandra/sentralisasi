@extends('layout.main')
@section('aside-menu')
    @include('belanja-51.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex gap-2 flex-wrap py-2 px-4">
            <div class="breadcrumbs text-sm">
                <ul>
                    <li><a href="/belanja-51-v2/uang-makan/create">Periode</a></li>
                    <li>
                        <span class="btn btn-xs btn-ghost btn-active">
                            Preview
                        </span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 gap-2 pb-2">
            <div class="flex flex-col gap-2">
                <p class="text-xs">Mohon untuk melakukan verifikasi jumlah pegawai dan kehadiran sebelum melanjutkan</p>
                <div class="flex">
                    <form action="" method="get">
                        <div class="join">
                            <input class="input input-xs input-bordered join-item" type="date" name="min"
                                min={{ $minDate }} max="{{ $maxDate }}" value="{{ request('min') ?? $minDate }}"
                                required />
                            <input class="input input-xs input-bordered join-item" type="date" name="max"
                                min={{ $minDate }} max="{{ $maxDate }}" value="{{ request('max') ?? $maxDate }}"
                                required />
                            <button class="btn btn-xs join-item btn-neutral" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="h-full w-full overflow-hidden">
                <div class="flex flex-col gap-2 w-full max-w-2xl h-full overflow-hidden">
                    <div class="overflow-x-auto overflow-y-auto">
                        <x-table>
                            <x-table.header>
                                <tr class="*:border-x *:text-center">
                                    <x-table.header.column>No</x-table.header.column>
                                    <x-table.header.column>Nama</x-table.header.column>
                                    <x-table.header.column>NIP</x-table.header.column>
                                    <x-table.header.column>Jumlah Hari</x-table.header.column>
                                </tr>
                            </x-table.header>
                            <x-table.body>
                                @foreach ($data as $item)
                                    <tr class="*:border">
                                        <x-table.body.column
                                            class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                        <x-table.body.column>{{ $item->nama }}</x-table.body.column>
                                        <x-table.body.column>{{ $item->nip }}</x-table.body.column>
                                        <x-table.body.column class="text-center">{{ $item->jml }}</x-table.body.column>
                                    </tr>
                                @endforeach
                            </x-table.body>
                        </x-table>
                    </div>
                    <div class="px-4 py-2">
                        {{ $data->links() }}
                    </div>
                    <div class="flex gap-2 p-2 justify-end">
                        <a href="/belanja-51-v2/uang-makan/create" class="btn btn-xs btn-secondary">Kembali</a>
                        <button type="button" class="btn btn-xs btn-success"
                            onclick="proses_modal.showModal()">Proses</button>
                    </div>
                </div>
            </div>
        </div>
        <div>
            {{-- {{$data->links()}} --}}
        </div>
        <dialog id="proses_modal" class="modal">
            <div class="modal-box">
                <form action="" method="POST" id="form-non-aktif"
                    onsubmit="return confirm('Apakah anda yakin melakukan proses permohonan pembayaran uang makan?')">
                    @csrf
                    <div class="flex flex-col gap-2 w-full max-w-2xl">
                        <div class="flex flex-col">
                            <div class="flex flex-col">
                                <x-input name="uraian"
                                    value="{{ old('uraian', 'Permohonan Pembayaran Uang Makan Periode Bulan ' . \Carbon\Carbon::createFromDate(null, $bln)->translatedFormat('F') . ' Tahun ' . $thn) }}"
                                    label="Uraian:" size="w-full" :required="true" />
                                <x-select name="penandatangan" label="Penandatangan:" size="w-full" :required="true">
                                    @foreach ($approval as $item)
                                        <option value="{{ $item->nip }}">{{ $item->nama }}</option>
                                    @endforeach
                                    @if ($admin)
                                        <option value='{{ $admin->nip }}'>{{ $admin->nama }}</option>
                                    @endif
                                </x-select>
                                <x-input name="jabatan"
                                    value="{{ old('jabatan', $satker->jnssatker == 1 ? 'Kepala Bagian / Kepala Sub Direktorat ' . $satker->nmsatker : ($satker->jnssatker == 2 ? 'Kepala Bagian Umum ' . $satker->nmsatker : 'Kepala ' . $satker->nmsatker)) }}"
                                    label="Jabatan Penandatangan:" size="w-full" :required="true" />
                            </div>
                        </div>
                        <div class="flex gap-2 p-2">
                            <button type="submit" class="btn btn-xs btn-success">lanjutkan</button>
                        </div>
                    </div>
                </form>
            </div>
            <form method="dialog" class="modal-backdrop">
                <button>close</button>
            </form>
        </dialog>
    </div>
@endsection
