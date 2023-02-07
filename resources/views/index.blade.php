@extends('layout.index')

@section('head')
<link rel="stylesheet" href="/css/home.css">
@endsection

@section('content')
<div class="main-content-warper">
    <a href="/monitoring" class="main-menu" style="text-decoration: none; color:#555555"> 
        <div class="content">
            <div>
                <img src="/img/ico/monitoring.png" alt="monitoring icon" style="max-height: 100%; width:auto">
            </div>
            <span>Monitoring</span>
        </div>
    </a>
    <a href="/belanja-51" class="main-menu" style="text-decoration: none; color:#555555"> 
        <div class="content">
            <div>
                <img src="/img/ico/belanja_51.png" alt=" Belanja 51 Icon" style="max-height: 100%; width:auto">
            </div>
            <span>Belanja 51</span>
        </div>
    </a>
    <a href="/honorarium" class="main-menu" style="text-decoration: none; color:#555555"> 
        <div class="content">
            <div>
                <img src="/img/ico/honorarium.png" alt="Honorarium Icon" style="max-height: 100%; width:auto">
            </div>
            <span>Honorarium</span>
        </div>
    </a>
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
