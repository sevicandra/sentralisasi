@extends('layout.main')
@section('aside-menu')
    @include('belanja-51.sidemenu')
@endsection
@section('main-content')
    <div class="h-full grid grid-rows-[auto_1fr_auto] grid-cols-1 gap-2">
        <div class="flex gap-2 flex-wrap py-2 px-4">
            <div class="breadcrumbs text-sm">
                <ul>
                    <li><a href="/belanja-51-vertikal/uang-lembur/create">Periode</a></li>
                    <li>
                        <span class="btn btn-xs btn-ghost btn-active">
                            Preview
                        </span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="grid grid-rows-[auto_1fr] grid-cols-1 overflow-hidden px-4 gap-2 pb-2 max-w-3xl">
            <div class="flex flex-col gap-2">
                <p class="text-xs">Mohon untuk melakukan verifikasi jumlah pegawai dan kehadiran sebelum melanjutkan</p>
                <div class="flex justify-between">
                    <div class="flex">
                        <form action="" method="get">
                            <div class="join">
                                <input class="input input-xs input-bordered join-item" type="date" name="min"
                                    min={{ $minDate }} max="{{ $maxDate }}"
                                    value="{{ request('min') ?? $minDate }}" required />
                                <input class="input input-xs input-bordered join-item" type="date" name="max"
                                    min={{ $minDate }} max="{{ $maxDate }}"
                                    value="{{ request('max') ?? $maxDate }}" required />
                                <button class="btn btn-xs join-item btn-neutral" type="submit">Cari</button>
                            </div>
                        </form>
                    </div>
                    <div>
                        <input type="text" class="input input-xs input-bordered" id="searchInput" placeholder="Cari...">
                    </div>
                </div>
            </div>
            <div class="h-full w-full overflow-hidden">
                <form action="" method="POST" class="h-full w-full overflow-hidden"
                    onsubmit="return confirm('Apakah anda yakin melakukan proses permohonan pembayaran uang makan?')">
                    <div class="flex flex-col gap-2 w-full h-full overflow-hidden">
                        <div class="h-full w-full grid grid-rows-[1fr_auto] overflow-hidden">
                            <div class="overflow-x-auto overflow-y-auto h-full w-full">
                                @error('data')
                                    <p class="text-xs text-red-500">{{ $message }}</p>
                                @enderror
                                <x-table class="collapse" size='table-xs'>
                                    <x-table.header>
                                        <tr class="*:border-x *:text-center">
                                            <x-table.header.column>No</x-table.header.column>
                                            <x-table.header.column>Nama</x-table.header.column>
                                            <x-table.header.column>NIP</x-table.header.column>
                                            <x-table.header.column>Jumlah Jam Hari Kerja</x-table.header.column>
                                            <x-table.header.column>Jumlah Jam Hari Libur</x-table.header.column>
                                            <x-table.header.column> <input type="checkbox" class="checkbox checkbox-sm"
                                                    id="select-all" /></x-table.header.column>
                                        </tr>
                                    </x-table.header>
                                    <x-table.body>
                                        @foreach ($data as $item)
                                            <tr class="*:border tableBody">
                                                <x-table.body.column
                                                    class="text-center">{{ $loop->iteration }}</x-table.body.column>
                                                <x-table.body.column>{{ $item->nama }}</x-table.body.column>
                                                <x-table.body.column>{{ $item->nip }}</x-table.body.column>
                                                <x-table.body.column
                                                    class="text-center">{{ $item->jumlahjamkerja }}</x-table.body.column>
                                                <x-table.body.column
                                                    class="text-center">{{ $item->jumlahjamlibur }}</x-table.body.column>
                                                <x-table.body.column class="text-center">
                                                    <input type="checkbox" class="checkbox checkbox-sm checkbox-selected"
                                                        name="data[]" value="{{ $item->nip }}" />
                                                </x-table.body.column>
                                            </tr>
                                        @endforeach
                                    </x-table.body>
                                </x-table>
                            </div>
                            <div class="p-2">
                                @csrf
                                <x-input name="uraian"
                                    value="{{ old('uraian', 'Permohonan Pembayaran Uang Lembur Periode Bulan ' . \Carbon\Carbon::createFromDate(null, $bln)->translatedFormat('F') . ' Tahun ' . $thn) }}"
                                    label="Uraian:" size="w-full" :required="true" />
                                <x-select name="penandatangan" label="Penandatangan:" size="w-full" :required="true">
                                    @foreach ($approval as $item)
                                        <option value="{{ $item->nip }}/{{ $item->nama }}">{{ $item->nama }}
                                        </option>
                                    @endforeach
                                    @if ($admin)
                                        <option value='{{ $admin->nip }}/{{ $item->nama }}'>{{ $admin->nama }}
                                        </option>
                                    @endif
                                </x-select>
                                <x-input name="jabatan"
                                    value="{{ old('jabatan', $satker->jnssatker == 1 ? 'Kepala Bagian / Kepala Sub Direktorat ' . $satker->nmsatker : ($satker->jnssatker == 2 ? 'Kepala Bagian Umum ' . $satker->nmsatker : 'Kepala ' . $satker->nmsatker)) }}"
                                    label="Jabatan Penandatangan:" size="w-full" :required="true" />
                            </div>
                        </div>
                        <div class="flex gap-2 p-2 justify-end">
                            <a href="/belanja-51-vertikal/uang-lembur/create" class="btn btn-xs btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-xs btn-success">Proses</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div>
            {{-- {{$data->links()}} --}}
        </div>
    </div>
@endsection

@section('head')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
@endsection

@section('footer')
    <script>
        // Fungsi untuk mengatur status "Select All" berdasarkan status checkbox individual
        function updateSelectAllStatus() {
            var selectAllCheckbox = document.getElementById('select-all');
            var checkboxes = document.querySelectorAll('.checkbox-selected');
            var allChecked = Array.from(checkboxes).every(function(checkbox) {
                return checkbox.checked;
            });
            selectAllCheckbox.checked = allChecked;
        }

        // Event listener untuk checkbox "Select All"
        document.getElementById('select-all').addEventListener('change', function() {
            var checkboxes = document.querySelectorAll('.checkbox-selected');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = this.checked;
            }.bind(this));
        });

        // Event listener untuk setiap checkbox individual
        document.querySelectorAll('.checkbox-selected').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateSelectAllStatus();
            });
        });

        // Panggil fungsi untuk mengatur status "Select All" pada halaman pertama kali dimuat
        updateSelectAllStatus();
    </script>
    <script>
        $(document).ready(function() {
            $('#searchInput').on('keyup', function() {
                var searchText = $(this).val().toLowerCase();
                $('.tableBody').each(function() {
                    var name = $(this).find('td').eq(1).text().toLowerCase();
                    var nip = $(this).find('td').eq(2).text().toLowerCase();
                    if (name.indexOf(searchText) !== -1 || nip.indexOf(searchText) !== -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
@endsection
