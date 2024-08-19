@if (Auth::guard('web')->check())
    @php
        $gate = ['plt_admin_satker', 'opr_belanja_51'];
        $gate2 = ['approver'];
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
            <li><a href="/belanja-51-v2/">Beranda</a></li>
        </ul>
    </li>
    <li>
        <h2 class="menu-title">Uang Makan</h2>
        <ul>
            <li><a href="/belanja-51-v2/uang-makan/absensi">Absensi</a></li>
            <li><a href="/belanja-51-v2/uang-makan/permohonan">Permohonan</a></li>
            <li><a href="/belanja-51-v2/uang-makan/arsip">Arsip</a></li>
        </ul>
    </li>
    <li>
        <h2 class="menu-title">Uang Lembur</h2>
        <ul>
            <li><a href="/belanja-51-v2/uang-lembur/absensi">Absensi</a></li>
            <li><a href="/belanja-51-v2/uang-lembur/permohonan">Permohonan</a></li>
            <li><a href="/belanja-51-v2/uang-lembur/arsip">Arsip</a></li>

        </ul>
    </li>
@endcan

@canany($gate2, auth()->user()->id)
    <li>
        <h2 class="menu-title">TTE</h2>
        <ul>
            <li><a href="/belanja-51-v2/tte">Permohonan</a></li>
        </ul>
        <ul>
            <li><a href="/belanja-51-v2/arsip">Arsip</a></li>
        </ul>
    </li>

@endcanany
