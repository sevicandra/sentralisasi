@if (Auth::guard('web')->check())
    @can('sys_admin', auth()->user()->id)
        @php
            $notif = 0;
        @endphp
        @if ($honorariumKirim + $dataPembayaranLainnyaDraft > 0)
            @php
                $notif += $honorariumKirim + $dataPembayaranLainnyaDraft;
            @endphp
        @endif
        <x-module-button name="Data Payment" url="/data-payment" icon="img/ico/data-payment.png" notif="{{ $notif }}" />
    @endcan
@endif
