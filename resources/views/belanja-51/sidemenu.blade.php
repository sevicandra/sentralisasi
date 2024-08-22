@if (Auth::guard('web')->check())
    @php
        $gate = ['plt_admin_satker', 'opr_belanja_51_vertikal'];
        $gate2 = ['approver_vertikal'];
    @endphp
@else
    @php
        $gate = ['admin_satker'];
        $gate2 = ['admin_satker'];
    @endphp
@endif

@canany($gate, auth()->user()->id)
    <li>
        <h2 class="menu-title">Halaman Utama</h2>
        <ul>
            <li><a href="/belanja-51-vertikal/">Beranda
                    @if ($notifBelanja51Tolak > 0)
                        <div class="absolute top-1/2 -translate-y-1/2 end-1 badge badge-warning shadow border">
                            {{ $notifBelanja51Tolak }}
                        </div>
                    @endif
                </a></li>
        </ul>
    </li>
    <li>
        <h2 class="menu-title">Uang Makan</h2>
        <ul>
            <li><a href="/belanja-51-vertikal/uang-makan/absensi">Absensi</a></li>
            <li><a href="/belanja-51-vertikal/uang-makan/permohonan">Permohonan</a></li>
            <li><a href="/belanja-51-vertikal/uang-makan/arsip">Arsip</a></li>
        </ul>
    </li>
    <li>
        <h2 class="menu-title">Uang Lembur</h2>
        <ul>
            <li><a href="/belanja-51-vertikal/uang-lembur/absensi">Absensi</a></li>
            <li><a href="/belanja-51-vertikal/uang-lembur/permohonan">Permohonan</a></li>
            <li><a href="/belanja-51-vertikal/uang-lembur/arsip">Arsip</a></li>

        </ul>
    </li>
@endcan

@canany($gate2, auth()->user()->id)
    <li>
        <h2 class="menu-title">TTE</h2>
        <ul>
            <li><a href="/belanja-51-vertikal/tte">Konsep</a></li>
            <li><a href="/belanja-51-vertikal/tte/arsip">Arsip</a></li>
        </ul>
    </li>

@endcanany
