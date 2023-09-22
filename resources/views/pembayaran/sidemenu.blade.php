@if (Auth::guard('web')->check())
    @php
        $gate=['plt_admin_satker', 'opr_belanja_51']
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
        <span>Uang Makan
            @if ($uangMakanDraft >0)
            <span class="position-relative">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $uangMakanDraft }}
                    <span class="visually-hidden">unread messages</span>
                </span>
            </span>
            @endif
        </span>
    </a>
</div>

<div>
    <a href="/belanja-51/uang-lembur">
        <span></span>
        <span>Uang Lembur
            @if ($uangLemburDraft >0)
            <span class="position-relative">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $uangLemburDraft }}
                    <span class="visually-hidden">unread messages</span>
                </span>
            </span>
            @endif
        </span>
    </a>
</div>
@endcan

@can('wilayah', [auth()->user()->kdsatker])
    <span>
        Monitoring Wilayah
    </span>
    <div>
        <a href="/belanja-51/wilayah/uang-makan">
            <span></span>
            <span>Dokumen Uang Makan</span>
        </a>
    </div>
    <div>
        <a href="/belanja-51/wilayah/uang-lembur">
            <span></span>
            <span>Dokumen Uang Lembur</span>
        </a>
    </div>
@endcan


@if (Auth::guard('web')->check())
@can('sys_admin', auth()->user()->id)
    <span>
        Monitoring Pusat
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
