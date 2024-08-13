@if (Auth::guard('web')->check())
    @php
        $gate = ['opr_rumdin', 'plt_admin_satker', 'sys_admin'];
    @endphp
@else
    @php
        $gate = ['admin_satker'];
    @endphp
@endif
@canany($gate, auth()->user()->id)
    @php
        $notif = 0;
    @endphp
    @if (Auth::guard('web')->check())
        @canany(['plt_admin_satker', 'opr_rumdin', 'sys_admin'], auth()->user()->id)
            @php
                $notif += $rumdinReject;
            @endphp
            @can('sys_admin', auth()->user()->id)
                @php
                    $notif += $rumdinUsulan;
                    $notif += $rumdinPenghentian;
                @endphp
            @endcan
        @endcan
    @else
        @php
            $notif += $rumdinReject;
        @endphp
    @endif

    <x-module-button name="Sewa Rumah" url="/sewa-rumdin" icon="img/ico/rumdin.png" notif="{{ $notif }}" />
@endcanany
