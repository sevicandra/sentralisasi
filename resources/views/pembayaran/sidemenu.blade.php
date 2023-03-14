@if (Auth::guard('web')->check())
    @php
        $gate=['plt_admin_satker', 'opr_monitoring']
    @endphp
@else
    @php
    $gate=['admin_satker']
    @endphp
@endif

@canany($gate, auth()->user()->id)
<span>
    Halaman Utama
</span>
<div>
    <a href="/belanja-51">
        <span></span>
        <span>Beranda</span>
    </a>
</div>
<div>
    <a href="/belanja-51/uang-makan">
        <span></span>
        <span>Uang Makan</span>
    </a>
</div>

<div>
    <a href="/belanja-51/uang-lembur">
        <span></span>
        <span>Uang Lembur</span>
    </a>
</div>
@endcan
@if (Auth::guard('web')->check())
@can('sys_admin', auth()->user()->id)
    <span>
        Monitoring
    </span>
    <div>
        <a href="/belanja-51/dokumen-uang-makan">
            <span></span>
            <span>Dokumen Uang Makan
                @if ($uangMakanKirim >0)
                <span class="position-relative">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $uangMakanKirim }}
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </span>
                @endif
            </span>
        </a>
    </div>
    <div>
        <a href="/belanja-51/dokumen-uang-lembur">
            <span></span>
            <span>Dokumen Uang Lembur
                @if ($uangLemburKirim >0)
                <span class="position-relative">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $uangLemburKirim }}
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </span>
                @endif
            </span>
        </a>
    </div>
@endcan    
@endif
