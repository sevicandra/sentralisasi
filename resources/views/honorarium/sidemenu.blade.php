@if (Auth::guard('web')->check())
    @php
        $gate=['plt_admin_satker', 'opr_honor']
    @endphp
@else
    @php
    $gate=['admin_satker']
    @endphp
@endif

@canany($gate, auth()->user()->id)
<span>
    Halaman Utama
</span>
<div>
    <a href="/honorarium">
        <span></span>
        <span>
            Beranda
            @if ($honorariumDraft >0)
            <span class="position-relative">
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $honorariumDraft }}
                    <span class="visually-hidden">unread messages</span>
                </span>
            </span>
            @endif
        </span>
    </a>
</div>
@endcan
