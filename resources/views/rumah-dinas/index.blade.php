@extends('layout.main')
@section('aside-menu')
    @include('rumah-dinas.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex gap-2 flex-wrap py-2 px-4">
            <div class="flex justify-end w-full">
                <a href="/sewa-rumdin/create" class="btn btn-xs btn-primary">
                    Tambah
                </a>
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
                        <tr class="*:text-center *:border-x">
                            <x-table.header.column>No</x-table.header.column>
                            <x-table.header.column>Nama</x-table.header.column>
                            <x-table.header.column>NIP</x-table.header.column>
                            <x-table.header.column>Nomor SIP</x-table.header.column>
                            <x-table.header.column>Tanggal SIP</x-table.header.column>
                            <x-table.header.column>TMT</x-table.header.column>
                            <x-table.header.column>Tanggal Kirim</x-table.header.column>
                            <x-table.header.column>Nilai Sewa</x-table.header.column>
                            <x-table.header.column>file</x-table.header.column>
                            <x-table.header.column>Status</x-table.header.column>
                            <x-table.header.column>Action</x-table.h>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column class="whitespace-nowrap">{{ $item->nama }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nip }}</x-table.body.column>
                                <x-table.body.column class="whitespace-nowrap">{{ $item->nomor_sip }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-center whitespace-nowrap">{{ $item->tanggal_sip }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-center whitespace-nowrap">{{ $item->tmt }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-center whitespace-nowrap">{{ $item->tanggal_kirim }}</x-table.body.column>
                                <x-table.body.column
                                    class="text-right">{{ number_format($item->nilai_potongan, 0, ',', '.') }}</x-table.body.column>
                                <x-table.body.column>
                                    @if ($item->file)
                                        <form action="/sewa-rumdin/{{ $item->id }}/dokumen" method="post"
                                            target="_blank">
                                            @csrf
                                            @method('patch')
                                            <button class="btn btn-xs btn-outline btn-primary">file</button>
                                        </form>
                                    @endif
                                </x-table.body.column>
                                <x-table.body.column
                                    class="text-center">{{ str_replace('_', ' ', $item->status) }}</x-table.body.column>
                                <x-table.body.column class="min-w-64">
                                    <div class="flex flex-wrap gap-1 w-full h-full justify-center">
                                        @if ($item->status === 'draft')
                                            <a href="sewa-rumdin/{{ $item->id }}/edit"
                                                class="btn btn-xs btn-secondary">Ubah</a>
                                            <form action="sewa-rumdin/{{ $item->id }}/delete" method="post"
                                                onsubmit="return confirm('Apakah Anda yakin akan menghapus data ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-xs btn-error">Hapus</button>
                                            </form>
                                            <a href="sewa-rumdin/{{ $item->id }}/kirim" class="btn btn-xs btn-success"
                                                onclick="return confirm('Apakah Anda yakin akan mengirim data ini?');">Kirim</a>
                                        @elseif($item->status === 'aktif')
                                            <button type="button" value="{{ $item->id }}"
                                                onclick="penghentian_modal_{{ $loop->iteration }}.showModal()"
                                                class="btn btn-xs btn-error non-aktif-btn">
                                                Non Aktif
                                            </button>
                                            <dialog id="{{ 'penghentian_modal_' . $loop->iteration }}" class="modal">
                                                <div class="modal-box">
                                                    <form action="/sewa-rumdin/{{ $item->id }}/non-aktif"
                                                        method="POST" id="form-non-aktif">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="flex flex-col gap-2 w-full max-w-2xl">
                                                            <div class="flex flex-col">
                                                                <div class="flex flex-col">
                                                                    <x-input name="alasan_penghentian"
                                                                        value="{{ old('alasan_penghentian') }}"
                                                                        label="Alasan Penghentian:" size="w-full"
                                                                        :required="true" />

                                                                    <x-input type="date" name="tanggal_selesai"
                                                                        value="{{ old('tanggal_selesai') }}"
                                                                        label="TMT Penghentian:" size="w-full"
                                                                        :required="true" />
                                                                </div>
                                                            </div>
                                                            <div class="flex gap-2 p-2">
                                                                <button type="submit"
                                                                    class="btn btn-xs btn-success">Simpan</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <form method="dialog" class="modal-backdrop">
                                                    <button>close</button>
                                                </form>
                                            </dialog>
                                        @elseif($item->status === 'usulan_non_aktif')
                                            <form action="sewa-rumdin/{{ $item->id }}/cancel-non-aktif" method="post"
                                                onsubmit="return confirm('Apakah Anda yakin akan membatalkan usulan ini?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-xs btn-warning">
                                                    batal
                                                </button>
                                            </form>
                                        @elseif($item->status === 'pengajuan')
                                            <form action="sewa-rumdin/{{ $item->id }}/cancel-pengajuan" method="post"
                                                onsubmit="return confirm('Apakah Anda yakin akan membatalkan usulan ini?');">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-xs btn-warning">
                                                    batal
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </x-table.body.column>
                            </tr>
                        @endforeach
                    </x-table.body>
                </x-table>
            </div>
        </div>
        <div class="px-4 py-2">
            {{ $data->links() }}
        </div>
    </div>
@endsection
