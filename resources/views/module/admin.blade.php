@if (Auth::guard('web')->check())
    @php
        $gate = ['plt_admin_satker', 'sys_admin', 'admin_pusat'];
    @endphp
@else
    @php
        $gate = ['admin_satker'];
    @endphp
@endif

@canany($gate, auth()->user()->id)
    <x-module-button name="Admin" url="/admin" icon="img/ico/admin.png" />
@endcanany
