@if(Session::has('berhasil'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <span>
        <strong>Selamat!</strong> {{ Session::get('berhasil') }}
    </span>
    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
</div>
@elseif(Session::has('gagal'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <span>
        <strong>Maaf!</strong> {{ Session::get('gagal') }}
    </span>
    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
</div>
@elseif(Session::has('pesan'))
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <span>
        <strong>Perhatian!</strong> {{ Session::get('pesan') }}
    </span>
    <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
</div>
@endif