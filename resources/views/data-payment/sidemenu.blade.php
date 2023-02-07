
@canany(['sys_admin'], auth()->user()->id)
<span>
    Halaman Utama
</span>
{{-- <div>
    <a href="/data-payment">
        <span></span>
        <span>Pending</span>
    </a>
</div> --}}
<div>
    <a href="/data-payment/server">
        <span></span>
        <span>Data Server</span>
    </a>
</div>
<span>
    Data Pending
</span>
<div>
    <a href="/data-payment/honorarium">
        <span></span>
        <span>Honorarium</span>
    </a>
</div>
<div>
    <a href="/data-payment/lain">
        <span></span>
        <span>Pembayaran Lainnya</span>
    </a>
</div>
<span>
    Data Upload
</span>
<div>
    <a href="/data-payment/upload/honorarium">
        <span></span>
        <span>Honorarium</span>
    </a>
</div>
<div>
    <a href="/data-payment/upload/lain">
        <span></span>
        <span>Pembayaran Lainnya</span>
    </a>
</div>
@endcan
