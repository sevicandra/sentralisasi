@if (Auth::guard('web')->check())
    @php
        $gate = ['sys_admin'];
    @endphp
@else
    @php
        $gate = [];
    @endphp
@endif

@canany($gate, auth()->user()->id)
    <li>
        <h2 class="menu-title">Halaman Utama</h2>
        <ul>
            <li><a href="/belanja-51-monitoring/">Beranda</a></li>
        </ul>
    </li>
    <li>
        <h2 class="menu-title">Vertikal</h2>
        <ul>
            <li>
                <h2 class="menu-title">Uang Makan</h2>
                <ul>
                    <li><a href="/belanja-51-monitoring/vertikal/uang-makan">Permohonan</a></li>
                    <li><a href="/belanja-51-monitoring/vertikal/uang-makan/monitoring">Monitoring</a></li>
                </ul>
            </li>
            <li>
                <h2 class="menu-title">Uang Lembur</h2>
                <ul>
                    <li><a href="/belanja-51-monitoring/vertikal/uang-lembur">Permohonan</a></li>
                    <li><a href="/belanja-51-monitoring/vertikal/uang-lembur/monitoring">Monitoring</a></li>
                </ul>
            </li>
        </ul>
    </li>
    <li>
        <h2 class="menu-title">Pusat</h2>
        <ul>
            <li>
                <h2 class="menu-title">Uang Makan</h2>
                <ul>
                    <li><a href="/belanja-51-monitoring/pusat/uang-makan">Permohonan</a></li>
                    <li><a href="/belanja-51-monitoring/pusat/uang-makan/monitoring">Monitoring</a></li>
                </ul>
            </li>
            <li>
                <h2 class="menu-title">Uang Lembur</h2>
                <ul>
                    <li><a href="/belanja-51-monitoring/pusat/uang-lembur">Permohonan</a></li>
                    <li><a href="/belanja-51-monitoring/pusat/uang-lembur/monitoring">Monitoring</a></li>
                </ul>
            </li>
        </ul>
    </li>
@endcan

