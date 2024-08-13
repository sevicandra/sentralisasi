<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description"
        content="Dengan Alika Sentralisasi, kami hadirkan pengalaman terbaik pelaksanaan sentralisasi belanja pegawai di layar Anda">
    @vite('resources/css/app.css')
    <link rel="shortcut icon" href="/img/alika.png" type="image/x-icon">
    @section('head')

    @show
    <title>SENTRALISASI</title>
</head>

<body class="min-h-screen bg-base-100">
    <div class="h-screen overflow-hidden grid grid-rows-[auto_1fr]">
        <header class="shadow">
            <div class="h-full w-full max-w-7xl mx-auto flex justify-between items-center px-4 py-1">
                <div class="hidden md:block">
                    <a class="flex gap-2" href="{{ config('app.url') }}">
                        <span><img src="/img/alika.png" alt="logo alika" height="30px" width="30px"></span>
                        <span>
                            <h1 class="font-bold text-xl">
                                ALIKA SENTRALISASI
                            </h1>
                        </span>
                    </a>
                </div>
                <div class="md:hidden">
                    <a href="{{ config('app.url') }}">
                        <img src="/img/alika.png" alt="logo alika" height="24px" width="24px">
                    </a>
                </div>
                <div class="flex gap-2">
                    <div class="dropdown">
                        <div tabindex="0" role="button" class="btn m-1 btn-ghost">
                            <div class="avatar">
                                <div
                                    class="ring-primary ring-offset-base-100 w-8 rounded-full ring ring-offset-1 ring-sm">
                                    <img src="{{ session()->get('gravatar') }}" />
                                </div>
                            </div>
                            <span class="hidden md:block">{{ session()->get('name') }}</span>
                        </div>
                        <ul tabindex="0"
                            class="menu dropdown-content bg-base-200 rounded-box z-[1] w-52 p-2 shadow-lg">
                            <li>
                                <a href="{{ config('app.url') }}/logout">
                                    <img src="/img/ico/logout.png" alt="" height="25px" width="25px">
                                    <span>Logout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </header>
        <main class="overflow-hidden">
            <div class="h-full w-full max-w-7xl mx-auto overflow-x-visible border-x">
                @yield('content')
            </div>
        </main>
    </div>
</body>
@section('footer')

@show

</html>
