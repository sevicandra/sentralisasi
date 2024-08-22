@if (Auth::guard('web')->check())
    @php
        $gate = ['sys_admin'];
    @endphp
@else
    @php
        $gate = [];
    @endphp
@endif
@canany($gate, auth()->user()->id)
    <x-module-button name="Monitoring Belanja 51" url="/belanja-51-monitoring" icon="img/ico/payment_monitoring.png" notif="{{ $permohonanMakanPusat + $permohonanMakanVertikal + $permohonanLemburPusat + $permohonanLemburVertikal }}"/>
@endcanany
