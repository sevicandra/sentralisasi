<span>
    Halaman Utama
</span>
<div>
    <a href="/admin/user">
        <span></span>
        <span>User</span>
    </a>
</div>
<div>
    <a href="/admin/penandatangan">
        <span></span>
        <span>Penandatangan</span>
    </a>
</div>
@if (Auth::guard('web')->check())
@can('sys_admin', auth()->user()->id)
<span>
    Referensi
</span>
<div>
    <a href="/admin/role">
        <span></span>
        <span>Role</span>
    </a>
</div>
<div>
    <a href="/admin/satker">
        <span></span>
        <span>Satker</span>
    </a>
</div>
<div>
    <a href="/admin/admin-satker">
        <span></span>
        <span>Admin Satker</span>
    </a>
</div>
<div>
    <a href="/admin/bulan">
        <span></span>
        <span>Bulan</span>
    </a>
</div>

<div>
    <a href="/admin/ref-penandatangan">
        <span></span>
        <span>Penandatangan</span>
    </a>
</div>
    
<div class="position-fixed bottom-0 end-0 p-3 text-white">
    V.1.6.1
</div>
@endcan
@endif
