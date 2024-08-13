@if (Auth::guard('web')->check())
    @php
        $gate = ['plt_admin_satker', 'opr_rumdin'];
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
            <li><a href="/sewa-rumdin">Beranda</a></li>
            <li><a href="/sewa-rumdin/reject">Reject
                    @if ($rumdinReject > 0)
                        <div class="absolute top-1/2 -translate-y-1/2 end-1 badge badge-warning shadow border">
                            {{ $rumdinReject }}
                        </div>
                    @endif
                </a></li>
            <li><a href="/sewa-rumdin/non-aktif">Non Aktif</a></li>
        </ul>
    </li>
@endcan

@can('wilayah', [auth()->user()->kdsatker])
    <li>
        <h2 class="menu-title">Monitoring Wilayah</h2>
        <ul>
            <li><a href="/sewa-rumdin/wilayah/monitoring">Monitoring</a></li>
        </ul>
    </li>
@endcan

@if (Auth::guard('web')->check())
    @can('sys_admin', auth()->user()->id)
        <li>
            <h2 class="menu-title">Monitoring Pusat</h2>
            <ul>
                <li><a href="/sewa-rumdin/monitoring">Monitoring</a></li>
                <li><a href="/sewa-rumdin/monitoring-nonaktif">Monitoring Non Aktif</a></li>
                <li>
                    <a href="/sewa-rumdin/usulan">Usulan Potongan
                        @if ($rumdinUsulan > 0)
                            <div class="absolute top-1/2 -translate-y-1/2 end-1 badge badge-warning shadow border">
                                {{ $rumdinUsulan }}
                            </div>
                        @endif
                    </a>
                </li>
                <li>
                    <a href="/sewa-rumdin/penghentian">Usulan Penghentian
                        @if ($rumdinPenghentian > 0)
                            <div class="absolute top-1/2 -translate-y-1/2 end-1 badge badge-warning shadow border">
                                {{ $rumdinPenghentian }}
                            </div>
                        @endif
                    </a>
                </li>
            </ul>
        </li>
    @endcan
@endif
