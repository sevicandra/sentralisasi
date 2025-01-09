@if (Auth::guard('web')->check())
    @php
        $gate = ['opr_spt', 'plt_admin_satker', 'sys_admin', 'admin_pusat'];
    @endphp
@else
    @php
        $gate = ['admin_satker'];
    @endphp
@endif
@canany($gate, auth()->user()->id)
    <x-module-button name="SPT" url="/spt" icon="img/ico/spt.png" />
@endcanany
