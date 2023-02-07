@if (Auth::guard('web')->check())
    @php
        $gate=['plt_admin_satker', 'opr_honor']
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
    <a href="/honorarium">
        <span></span>
        <span>Beranda</span>
    </a>
</div>
@endcan
