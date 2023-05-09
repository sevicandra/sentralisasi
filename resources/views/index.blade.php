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
    <a href="/belanja-51" class="main-menu position-relative" style="text-decoration: none; color:#555555"> 
        <div class="content">
            <div>
                <img src="/img/ico/belanja_51.png" alt=" Belanja 51 Icon" style="max-height: 100%; width:auto">
            </div>
            <span>Belanja 51</span>
        </div>
        @if (Auth::guard('web')->check())
            @canany(['plt_admin_satker', 'opr_belanja_51', 'sys_admin'], auth()->user()->id)
                @php
                    $notif = 0;
                    $notif += $uangLemburDraft;
                    $notif += $uangMakanDraft;
                @endphp
                @can('sys_admin', auth()->user()->id)
                @php
                    $notif += $uangLemburKirim;
                    $notif += $uangMakanKirim;
                @endphp
                @endcan

                @if ($notif > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                {{ $notif }}
                <span class="visually-hidden">unread messages</span>
                </span>
                @endif
            @endcan
        @else
            @if ($uangLemburDraft+$uangMakanDraft > 0)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ $uangLemburDraft+$uangMakanDraft }}
            <span class="visually-hidden">unread messages</span>
            </span>
            @endif
        @endif
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
