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
    @php
        $notif = 0;

    @endphp

    @if (Auth::guard('web')->check())
        @canany(['plt_admin_satker', 'opr_belanja_51', 'sys_admin'], auth()->user()->id)
            @php
                $notif += $uangLemburDraft;
                $notif += $uangMakanDraft;
            @endphp
            @can('sys_admin', auth()->user()->id)
                @php
                    $notif += $uangLemburKirim;
                    $notif += $uangMakanKirim;
                @endphp
            @endcan

        @endcan
    @else
        @php
            $notif += $uangLemburDraft;
            $notif += $uangMakanDraft;
        @endphp
    @endif
    <x-module-button name="Belanja 51 v1" url="/belanja-51" icon="img/ico/belanja_51.png" notif="{{ $notif }}" />
@endcanany
