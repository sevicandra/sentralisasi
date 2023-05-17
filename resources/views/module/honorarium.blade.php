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
<a href="/honorarium" class="main-menu position-relative" style="text-decoration: none; color:#555555"> 
    <div class="content">
        <div>
            <img src="/img/ico/honorarium.png" alt="Honorarium Icon" style="max-height: 100%; width:auto">
        </div>
        <span>Honorarium</span>
    </div>
    @if ($honorariumDraft > 0)
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
    {{ $honorariumDraft }}
    <span class="visually-hidden">unread messages</span>
    </span>
    @endif
</a>
    
@endcanany