@if (Auth::guard('web')->check())
@can('sys_admin', auth()->user()->id)
<a href="/data-payment" class="main-menu position-relative" style="text-decoration: none; color:#555555"> 
    <div class="content">
        <div>
            <img src="/img/ico/data-payment.png" alt="Data Payment Icon" style="max-height: 100%; width:auto">
        </div>
        <span>Data Payment</span>
    </div>
    @if ($honorariumKirim+$dataPembayaranLainnyaDraft > 0)
    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
    {{ $honorariumKirim+$dataPembayaranLainnyaDraft }}
    <span class="visually-hidden">unread messages</span>
    </span>
    @endif
</a>
@endcan
@endif