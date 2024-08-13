@if (Auth::guard('web')->check())
    @php
        $gate = ['plt_admin_satker', 'opr_belanja_51'];
    @endphp
@else
    @php
        $gate = ['admin_satker'];
    @endphp
@endif

@canany($gate, auth()->user()->id)
    <li>
        <h2 class="menu-title">Halaman Utama</h2>
        <ul>
            <li><a href="/belanja-51">Beranda</a></li>
            <li><a href="/belanja-51/uang-makan">Uang Makan</a></li>
            <li><a href="/belanja-51/uang-lembur">Uang Lembur</a></li>

        </ul>
    </li>
@endcan

@can('wilayah', [auth()->user()->kdsatker])
    <li>
        <h2 class="menu-title">Monitoring Wilayah</h2>
        <ul>
            <li><a href="/belanja-51/wilayah/uang-makan">Dokumen Uang Makan</a></li>
            <li><a href="/belanja-51/wilayah/uang-lembur">Dokumen Uang Lembur</a></li>

        </ul>
    </li>
@endcan


@if (Auth::guard('web')->check())
    @can('sys_admin', auth()->user()->id)
        <li>
            <h2 class="menu-title">Monitoring Pusat</h2>
            <ul>
                <li><a href="/belanja-51/dokumen-uang-makan">Dokumen Uang Makan
                        @if ($uangMakanKirim > 0)
                            <div class="absolute top-1/2 -translate-y-1/2 end-1 badge badge-warning shadow border">
                                {{ $uangMakanKirim }}
                            </div>
                        @endif
                    </a></li>
                <li>
                    <a href="/belanja-51/dokumen-uang-lembur">Dokumen Uang Lembur
                        @if ($uangLemburKirim > 0)
                            <div class="absolute top-1/2 -translate-y-1/2 end-1 badge badge-warning shadow border">
                                {{ $uangLemburKirim }}
                            </div>
                        @endif
                    </a>
                </li>
            </ul>
        </li>
    @endcan
@endif
