@if (Auth::guard('web')->check())
    @php
        $gate=['plt_admin_satker', 'opr_rumdin']
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
    <a href="/sewa-rumdin">
        <span></span>
        <span>Beranda</span>
    </a>
</div>

<div>
    <a href="/sewa-rumdin/reject">
        <span></span>
        <span>Reject
            @if ($rumdinReject >0)
            <span class="position-relative">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $rumdinReject }}
                    <span class="visually-hidden">unread messages</span>
                </span>
            </span>
            @endif
        </span>
    </a>
</div>

<div>
    <a href="/sewa-rumdin/non-aktif">
        <span></span>
        <span>Non Aktif</span>
    </a>
</div>

@endcan
    

@if (Auth::guard('web')->check())
@can('sys_admin', auth()->user()->id)
<span>
    Monitoring Pusat
</span>
<div>
    <a href="/sewa-rumdin/monitoring">
        <span></span>
        <span>Monitoring</span>
    </a>
</div>
<div>
    <a href="/sewa-rumdin/usulan">
        <span></span>
        <span>Usulan Potongan
            @if ($rumdinUsulan >0)
            <span class="position-relative">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $rumdinUsulan }}
                    <span class="visually-hidden">unread messages</span>
                </span>
            </span>
            @endif
        </span>
    </a>
</div>
<div>
    <a href="/sewa-rumdin/penghentian">
        <span></span>
        <span>Usulan Penghentian
            @if ($rumdinPenghentian >0)
            <span class="position-relative">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $rumdinPenghentian }}
                    <span class="visually-hidden">unread messages</span>
                </span>
            </span>
            @endif
        </span>
    </a>
</div>
@endcan    
@endif
