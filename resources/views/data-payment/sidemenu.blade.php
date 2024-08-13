@canany(['sys_admin'], auth()->user()->id)
    <li>
        <h2 class="menu-title">Halaman Utama</h2>
        <ul>
            <li><a href="/data-payment/server">Data Server</a></li>
        </ul>
    </li>
    <li>
        <h2 class="menu-title">Data Pending</h2>
        <ul>
            <li>
                <a href="/data-payment/honorarium">Honorarium
                    @if ($honorariumKirim > 0)
                        <div class="badge badge-warning badge-sm">{{ $honorariumKirim }}</div>
                    @endif
                </a>
            </li>
            <li>
                <a href="/data-payment/lain">Pembayaran Lainnya
                    @if ($dataPembayaranLainnyaDraft > 0)
                        <div class="badge badge-warning badge-sm">{{ $dataPembayaranLainnyaDraft }}</div>
                    @endif
                </a>
            </li>
        </ul>
    </li>
    <li>
        <h2 class="menu-title">Data Upload</h2>
        <ul>
            <li>
                <a href="/data-payment/upload/honorarium">Honorarium</a>
            </li>
            <li>
                <a href="/data-payment/upload/lain">Pembayaran Lainnya</a>
            </li>
        </ul>
    </li>
@endcan
