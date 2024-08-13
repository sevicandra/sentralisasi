@if (Auth::guard('web')->check())
    @php
        $gate = ['plt_admin_satker', 'opr_honor'];
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

    @if ($honorariumDraft > 0)
        @php
            $notif += $honorariumDraft;
        @endphp
    @endif
    <x-module-button name="Honorarium" url="/honorarium" icon="img/ico/honorarium.png" notif="{{ $notif }}" />
@endcanany
