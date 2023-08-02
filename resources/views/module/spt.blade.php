@if (Auth::guard('web')->check())
    @php
        $gate=['opr_spt', 'plt_admin_satker', 'sys_admin']
    @endphp
@else
    @php
    $gate=['admin_satker']
    @endphp
@endif
@canany($gate, auth()->user()->id)
<a href="/spt" class="main-menu" style="text-decoration: none; color:#555555"> 
    <div class="content">
        <div>
            <img src="/img/ico/spt.png" alt="monitoring icon" style="max-height: 100%; width:auto">
        </div>
        <span>Monitoring</span>
    </div>
</a>
    
@endcanany