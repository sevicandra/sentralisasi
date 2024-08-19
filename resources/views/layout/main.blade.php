@extends('layout.index')

@section('head')
@section('main-head')

@show
@endsection

@section('content')
<div class="h-full grid grid-rows-[auto_1fr] grid-cols-[0px_1fr] md:grid-cols-[250px_1fr] overflow-hidden">
    <nav class="col-start-2 row-start-1 flex drop-shadow bg-accent text-accent-content py-2 px-4 gap-2 items-center">
        <label for="content-toggle" class="md:hidden">
            <img src="/img/ico/toggle-inactive.png" alt="" style="height: 30px">
        </label>
        @if (isset($pageTitle))
            <div>
                <h3 class="font-bold text-xl">{{ $pageTitle }}</h3>
            </div>
        @endif
    </nav>
    <aside class="col-start-1 row-start-2 overflow-x-hidden">
        <ul class="menu bg-base-100 h-full w-full overflow-y-auto border-r border-neutral-content relative">
            @section('aside-menu')

            @show
        </ul>
    </aside>
    <div class="col-start-2 row-start-2 overflow-hidden">
        <div class="h-full overflow-hidden">
            @yield('main-content')
        </div>
        <div class="md:hidden">
            <div class="drawer drawer-start">
                <input id="content-toggle" type="checkbox" class="drawer-toggle" />
                <div class="drawer-content">
                </div>
                <div class="drawer-side z-50">
                    <label for="content-toggle" aria-label="close sidebar" class="drawer-overlay"></label>

                    <div class="bg-base-100 h-full w-full max-w-xs">
                        <div class="p-2 flex justify-end">
                            <label for="content-toggle" class="md:hidden">
                                x
                            </label>
                        </div>
                        <ul class="menu bg-base-100 h-full w-full overflow-y-auto relative">
                            @section('aside-menu')

                            @show
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-start-1 row-start-1 bg-accent/30 border-r border-neutral-content">

    </div>
</div>
@endsection

@section('footer')

@section('main-footer')

@show
@endsection
