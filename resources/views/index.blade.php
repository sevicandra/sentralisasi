@extends('layout.index')

@section('head')
<link rel="stylesheet" href="/css/home.css">
@endsection

@section('content')
<div class="main-content-warper">
    <a href="/monitoring" class="main-menu"> 
        <div class="content">
            <div>
                <img src="" alt="" style="max-height: 100%; width:auto">
            </div>
            <span>Monitoring</span>
        </div>
    </a>
    <a href="/tukin" class="main-menu"> 
        <div class="content">
            <div>
                <img src="" alt="" style="max-height: 100%; width:auto">
            </div>
            <span>Tunjangan Kinerja</span>
        </div>
    </a>
    <a href="/admin" class="main-menu"> 
        <div class="content">
            <div>
                <img src="/img/ico/admin.png" alt="" style="max-height: 100%; width:auto">
            </div>
            <span>Admin</span>
        </div>
    </a>
</div>    
@endsection
