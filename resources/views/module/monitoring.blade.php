@if (Auth::guard('web')->check())
    @php
        $gate = ['plt_admin_satker', 'opr_monitoring', 'sys_admin'];
    @endphp
@else
    @php
        $gate = ['admin_satker'];
    @endphp
@endif
@canany($gate, auth()->user()->id)
    <x-module-button name="Monitoring" url="/monitoring" icon="img/ico/monitoring.png" />
@endcanany
