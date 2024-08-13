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
    <li>
        <h2 class="menu-title">Halaman Utama</h2>
        <ul>
            <li><a href="/honorarium">Beranda
                    @if ($honorariumDraft > 0)
                        <div class="absolute top-1/2 -translate-y-1/2 end-1 badge badge-warning shadow border">
                            {{ $honorariumDraft }}
                        </div>
                    @endif
                </a></li>
        </ul>
    </li>
@endcan
