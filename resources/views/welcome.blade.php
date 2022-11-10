
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<title>Monev</title>
	<link rel="shortcut icon" href="/img/monev.png" type=" image/x-icon">
	<link href="/css/bootstrap.min.css" rel="stylesheet">

	<style>
		.bd-placeholder-img {
			font-size: 1.125rem;
			text-anchor: middle;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}

		@media (min-width: 768px) {
			.bd-placeholder-img-lg {
				font-size: 3.5rem;
			}
		}
	</style>


</head>

<body>

	<main>
		<div class="position-relative overflow-hidden p-3 p-md-5 m-md-3 text-center">
			<div class="col-md-6 p-lg-5 mx-auto my-5">
				<h1 class="display-4 font-weight-normal">Hai!, Selamat Datang di Monev Tagihan.</h1>
				<p class="font-weight-light mt-4">Dengan alat bantu monev perbendaharaan, kami hadirkan kemudahan dalam mengakses informasi pelaksanaan anggaran di layar Anda.</p>
				@include('layout.flashmessage')
				<a class="btn btn-outline-primary mb-3" href="/sso">Login Menggunakan Kemenkeu ID</a>
			</div>
		</div>
	</main>

	<script src="/js/bootstrap.min.js"></script>

</body>

</html>