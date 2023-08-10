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
    <a href="/sewa-rumdin" class="main-menu position-relative" style="text-decoration: none; color:#555555">
        <div class="content">
            <div>
                <img src="/img/ico/rumdin.png" alt="monitoring icon" style="max-height: 100%; width:auto">
            </div>
            <span>Sewa Rumah</span>
        </div>
        @if (Auth::guard('web')->check())
            @canany(['plt_admin_satker', 'opr_rumdin', 'sys_admin'], auth()->user()->id)
                @php
                    $notif = 0;
                    $notif += $rumdinReject;
                @endphp
                @can('sys_admin', auth()->user()->id)
                    @php
                        $notif += $rumdinUsulan;
                        $notif += $rumdinPenghentian;
                    @endphp
                @endcan

                @if ($notif > 0)
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $notif }}
                        <span class="visually-hidden">unread messages</span>
                    </span>
                @endif
            @endcan
        @else
            @if ($rumdinReject > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $rumdinReject }}
                    <span class="visually-hidden">unread messages</span>
                </span>
            @endif
        @endif
    </a>

@endcanany
