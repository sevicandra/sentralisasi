@extends('layout.index')

@section('head')
<link rel="stylesheet" href="/css/home.css">
@endsection

@section('content')
<div class="main-content-warper">
    <a href="/monitoring" class="main-menu" style="text-decoration: none; color:#555555"> 
        <div class="content">
            <div>
                <img src="/img/ico/monitoring.png" alt="" style="max-height: 100%; width:auto">
            </div>
            <span>Monitoring</span>
        </div>
    </a>
    <a href="/belanja-51" class="main-menu" style="text-decoration: none; color:#555555"> 
        <div class="content">
            <div>
                <img src="/img/ico/belanja_51.png" alt="" style="max-height: 100%; width:auto">
            </div>
            <span>Belanja 51</span>
        </div>
    </a>
    <a href="/admin" class="main-menu" style="text-decoration: none; color:#555555"> 
        <div class="content">
            <div>
                <img src="/img/ico/admin.png" alt="" style="max-height: 100%; width:auto" >
            </div>
            <span>Admin</span>
        </div>
    </a>
</div>    

@endsection
