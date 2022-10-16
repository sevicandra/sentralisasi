@extends('layout.index')

@section('head')
    <link rel="stylesheet" href="/css/main.css">
    @section('main-head')
        
    @show
@endsection

@section('content')
<div class="content-warper">
    <nav class="content-nav">
        <div class="content-aside-toggle" id="content-toggle">
            <img id="content-aside-toggle-ico" src="/img/ico/toggle-inactive.png" alt="" style="height: 30px">
        </div>
        @if (isset($pageTitle))
        <div id="page-title">
            <h1 class="h3">{{ $pageTitle }}</h1>
        </div>   
        @endif
    </nav>
    <aside>
        <div class="content-aside aside-menu">
            @section('aside-menu')
                
            @show
        </div>
    </aside>
    <div class="content-main">
        <div class="main">
            @yield('main-content')
        </div>
        <div class="content-toggle">
            <div class="content-toggle-aside aside-menu">
                @section('aside-menu')
                    
                @show
            </div>
            <div id="content-toggle-offzone">

            </div>
        </div>
    </div>
    <div class="sub-title">

    </div>

</div>
@endsection

@section('footer')

<script src="/js/main.js"></script>
    @section('main-footer')
            
    @show
@endsection