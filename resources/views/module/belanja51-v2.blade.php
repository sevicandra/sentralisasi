@if (Auth::guard('web')->check())
    @php
        $gate = ['plt_admin_satker', 'opr_belanja_51', 'sys_admin'];
    @endphp
@else
    @php
        $gate = ['admin_satker'];
    @endphp
@endif
@canany($gate, auth()->user()->id)
    <x-module-button name="Belanja 51 V2" url="/belanja-51-v2" icon="img/ico/belanja_51.png" />
@endcanany
