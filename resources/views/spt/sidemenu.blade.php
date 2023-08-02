@if (Auth::guard('web')->check())
    @php
        $gate=['plt_admin_satker', 'opr_spt']
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
    <a href="/spt">
        <span></span>
        <span>Beranda</span>
    </a>
</div>
@endcan
    

@if (Auth::guard('web')->check())
@can('sys_admin', auth()->user()->id)
<span>
    Monitoring Pusat
</span>
<div>
    <a href="/spt-monitoring">
        <span></span>
        <span>Monitoring SPT</span>
    </a>
</div>
@endcan    
@endif
