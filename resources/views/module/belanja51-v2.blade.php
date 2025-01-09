@if (Auth::guard('web')->check())
    @php
        $gate = ['opr_belanja_51_vertikal', 'approver_vertikal'];
    @endphp
@else
    @php
        $gate = ['admin_satker'];
    @endphp
@endif
@canany($gate, auth()->user()->id)

    <x-module-button name="Belanja 51 Vertikal" url="/belanja-51-vertikal" icon="img/ico/belanja_51.png" notif="{{ $notifBelanja51TolakVertikal }}"/>
@endcanany
