@if (Auth::guard('web')->check())
@can('sys_admin', auth()->user()->id)
<a href="/data-payment" class="main-menu" style="text-decoration: none; color:#555555"> 
    <div class="content">
        <div>
            <img src="/img/ico/data-payment.png" alt="Data Payment Icon" style="max-height: 100%; width:auto">
        </div>
        <span>Data Payment</span>
    </div>
</a>
@endcan
@endif