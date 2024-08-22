@if (Auth::guard('web')->check())
    @php
        $gate = ['opr_belanja_51_pusat', 'approver_pusat'];
    @endphp
@else
    @php
        $gate = [];
    @endphp
@endif
@canany($gate, auth()->user()->id)
    <x-module-button name="Belanja 51 Pusat" url="/belanja-51-pusat" icon="img/ico/belanja_51.png" />
@endcanany
