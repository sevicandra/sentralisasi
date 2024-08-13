@if (Auth::guard('web')->check())
    @php
        $gate = ['plt_admin_satker', 'opr_spt'];
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
            <li><a href="/spt">Beranda</a></li>
        </ul>
    </li>

@endcan


@if (Auth::guard('web')->check())
    @can('sys_admin', auth()->user()->id)
        <li>
            <h2 class="menu-title">Monitoring Pusat</h2>
            <ul>
                <li><a href="/spt-monitoring">Monitoring SPT</a></li>
            </ul>
        </li>
    @endcan
@endif
