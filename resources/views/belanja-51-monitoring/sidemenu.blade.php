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
                    <li><a href="/belanja-51-monitoring/vertikal/uang-makan">Permohonan
                            @if ($permohonanMakanVertikal > 0)
                                <div class="absolute top-1/2 -translate-y-1/2 end-1 badge badge-warning shadow border">
                                    {{ $permohonanMakanVertikal }}
                                </div>
                            @endif
                        </a></li>
                    <li><a href="/belanja-51-monitoring/vertikal/uang-makan/monitoring">Monitoring</a></li>
                </ul>
            </li>
            <li>
                <h2 class="menu-title">Uang Lembur</h2>
                <ul>
                    <li><a href="/belanja-51-monitoring/vertikal/uang-lembur">Permohonan
                            @if ($permohonanLemburVertikal > 0)
                                <div class="absolute top-1/2 -translate-y-1/2 end-1 badge badge-warning shadow border">
                                    {{ $permohonanLemburVertikal }}
                                </div>
                            @endif
                        </a></li>
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
                    <li><a href="/belanja-51-monitoring/pusat/uang-makan">Permohonan
                            @if ($permohonanMakanPusat > 0)
                                <div class="absolute top-1/2 -translate-y-1/2 end-1 badge badge-warning shadow border">
                                    {{ $permohonanMakanPusat }}
                                </div>
                            @endif
                        </a></li>
                    <li><a href="/belanja-51-monitoring/pusat/uang-makan/monitoring">Monitoring</a></li>
                </ul>
            </li>
            <li>
                <h2 class="menu-title">Uang Lembur</h2>
                <ul>
                    <li><a href="/belanja-51-monitoring/pusat/uang-lembur">Permohonan
                            @if ($permohonanLemburPusat > 0)
                                <div class="absolute top-1/2 -translate-y-1/2 end-1 badge badge-warning shadow border">
                                    {{ $permohonanLemburPusat }}
                                </div>
                            @endif
                        </a></li>
                    <li><a href="/belanja-51-monitoring/pusat/uang-lembur/monitoring">Monitoring</a></li>
                </ul>
            </li>
        </ul>
    </li>
@endcan
