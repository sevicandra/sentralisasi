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
{{-- <div>
    <a href="/monitoring">
        <span></span>
        <span>Beranda</span>
    </a>
</div> --}}
<div>
<a href="/monitoring/rincian">
    <span></span>
    <span>Rincian</span>
</a>
</div>
<div>
    <a href="/monitoring/laporan">
        <span></span>
        <span>Laporan</span>
    </a>
</div>
@endcan
    

@if (Auth::guard('web')->check())
@can('sys_admin', auth()->user()->id)
<span>
    Monitoring Pusat
</span>
<div>
    <a href="/monitoring/penghasilan">
        <span></span>
        <span>Penghasilan</span>
    </a>
</div>
<div>
<a href="/monitoring/pelaporan">
    <span></span>
    <span>Pelaporan</span>
</a>
</div>
@endcan    
@endif
