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
    <title>SENTRALISASI</title>
</head>

<body class="h-screen">
    <main class="w-full h-full max-w-7xl mx-auto">
        <div class="overflow-hidden text-center grid place-items-center h-full w-full">
            <div class="flex flex-col gap-2">
                <h1 class="text-3xl font-normal">Hai!, Selamat Datang di Alika Sentralisasi.</h1>
                <p class="font-light">Dengan Alika Sentralisasi, kami hadirkan pengalaman terbaik pelaksanaan
                    sentralisasi belanja pegawai di layar Anda.</p>
                @include('layout.flashmessage')
                <div>
                    <a class="btn btn-outline btn-primary" href="/sso">Login Menggunakan Kemenkeu ID</a>
                </div>
            </div>
        </div>
    </main>
</body>

</html>
