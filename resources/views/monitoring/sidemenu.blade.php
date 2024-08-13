@if (Auth::guard('web')->check())
    @php
        $gate = ['plt_admin_satker', 'opr_monitoring'];
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
            <li><a href="/monitoring/rincian">Rincian</a></li>
            <li><a href="/monitoring/laporan">Laporan</a></li>

        </ul>
    </li>
@endcan
@if (Auth::guard('web')->check())
    @can('sys_admin', auth()->user()->id)
        <li>
            <h2 class="menu-title">Monitoring Pusat</h2>
            <ul>
                <li><a href="/monitoring/penghasilan">Penghasilan</a></li>
                <li><a href="/monitoring/pelaporan">Pelaporan</a></li>
            </ul>
        </li>
    @endcan
@endif
