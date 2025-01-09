<li>
    <h2 class="menu-title">Halaman Utama</h2>
    <ul>
        <li><a href="/admin/user">User</a></li>
        <li><a href="/admin/penandatangan">Penandatangan</a></li>
    </ul>
</li>
@if (Auth::guard('web')->check())
    @can('sys_admin', auth()->user()->id)
        <li>
            <h2 class="menu-title">Referensi</h2>
            <ul>
                <li><a href="/admin/role">Role</a></li>
                <li><a href="/admin/satker">Satker</a></li>
                <li><a href="/admin/admin-satker">Admin Satker</a></li>
                <li><a href="/admin/bulan">Bulan</a></li>
                <li><a href="/admin/ref-penandatangan">Penandatangan</a></li>
                <li><a href="/admin/ref-nomor">Nomor</a></li>
                <li><a href="/admin/ref-kop">Kop</a></li>
            </ul>
        </li>
        <div class="absolute bottom-0 start-0 p-3 text-base-content">
            V.1.8.1
        </div>
    @endcan
@endif
