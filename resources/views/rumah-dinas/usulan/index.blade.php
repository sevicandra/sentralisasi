@extends('layout.main')
@section('aside-menu')
    @include('rumah-dinas.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex gap-2 flex-wrap py-2 px-4">
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
                            <x-table.header.column>Satker</x-table.header.column>
                            <x-table.header.column>Nomor SIP</x-table.header.column>
                            <x-table.header.column>Tanggal SIP</x-table.header.column>
                            <x-table.header.column>TMT</x-table.header.column>
                            <x-table.header.column>Tanggal Kirim</x-table.header.column>
                            <x-table.header.column>Nilai Sewa</x-table.header.column>
                            <x-table.header.column>file</x-table.header.column>
                            <x-table.header.column>Action</x-table.header.column>
                        </tr>
                    </x-table.header>
                    <x-table.body>
                        @foreach ($data as $item)
                            <tr class="*:border">
                                <x-table.body.column class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                <x-table.body.column class="whitespace-nowrap">{{ $item->nama }}</x-table.body.column>
                                <x-table.body.column>{{ $item->nip }}</x-table.body.column>
                                <x-table.body.column class="whitespace-nowrap">{{ $item->nmsatker }}</x-table.body.column>
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
                                        <form action="/sewa-rumdin/usulan/{{ $item->id }}/dokumen" method="post"
                                            target="_blank">
                                            @csrf
                                            @method('patch')
                                            <button class="btn btn-xs btn-outline btn-primary">file</button>
                                        </form>
                                    @endif
                                </x-table.body.column>
                                <x-table.body.column>
                                    <div class="h-full w-full flex gap-1 justify-center">
                                        <button type="button" value="{{ $item->id }}"
                                            onclick="penolakan_modal_{{ $loop->iteration }}.showModal()"
                                            class="btn btn-xs btn-error reject-btn">
                                            Tolak
                                        </button>
                                        <dialog id="{{ 'penolakan_modal_' . $loop->iteration }}" class="modal">
                                            <div class="modal-box">
                                                <form action="/sewa-rumdin/usulan/{{ $item->id }}/tolak" method="POST"
                                                    id="form-non-aktif">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="flex flex-col gap-2 w-full max-w-2xl">
                                                        <div class="flex flex-col">
                                                            <div class="flex flex-col">
                                                                <x-input name="catatan" value="{{ old('catatan') }}"
                                                                    label="Catatan:" size="w-full" :required="true" />
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
                                        <form action="/sewa-rumdin/usulan/{{ $item->id }}/approve" method="post"
                                            onsubmit="return confirm('Apakah Anda yakin ?');">
                                            @csrf
                                            @method('PATCH')
                                            <div class="btn-group">
                                                <button class="btn btn-xs btn-success">Approve</button>
                                            </div>
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
