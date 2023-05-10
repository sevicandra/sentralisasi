@if (Auth::guard('web')->check())
    @php
        $gate=['plt_admin_satker', 'sys_admin']
    @endphp
@else
    @php
    $gate=['admin_satker']
    @endphp
@endif

@canany($gate, auth()->user()->id)
<a href="/admin" class="main-menu" style="text-decoration: none; color:#555555"> 
    <div class="content">
        <div>
            <img src="/img/ico/admin.png" alt="" style="max-height: 100%; width:auto" >
        </div>
        <span>Admin</span>
    </div>
</a>
@endcanany