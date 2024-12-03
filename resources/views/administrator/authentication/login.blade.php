<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login V1</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/png" href="images/icons/favicon.ico" />
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/administrator/login/vendor/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/administrator/login/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/administrator/login/vendor/animate/animate.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/administrator/login/vendor/css-hamburgers/hamburgers.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/administrator/login/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/administrator/login/css/main.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/toastr/css/toastr.css') }}">
	<meta name="robots" content="noindex, follow">
</head>
<body>
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="d-flex align-items-center login100-pic js-tilt" data-tilt>
					<img src="{{ asset('assets/images/logo_infi.png') }}" alt="IMG">
				</div>
				<form action="" method="POST" class="login100-form validate-form">
                    @csrf
					<span class="login100-form-title">
						Admin Login
					</span>
					<div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate="Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					<div class="container-login100-form-btn">
						<button type="submit" class="login100-form-btn">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="{{ asset('assets/administrator/login/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
	<script src="{{ asset('assets/administrator/login/vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{ asset('assets/administrator/login/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
	<script src="{{ asset('assets/administrator/login/vendor/tilt/tilt.jquery.min.js')}}"></script>
	<script>
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="{{ asset('assets/administrator/login/js/gtag.js') }}"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag() { dataLayer.push(arguments); }
		gtag('js', new Date());

		gtag('config', 'UA-23581568-13');
	</script>
	<script src="{{ asset('assets/administrator/login/js/main.js')}}"></script>
	<script defer
    src="{{ asset('assets/administrator/login/js/beacon.min.js')}}"
    integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
    data-cf-beacon='{"rayId":"8dc13063ea5b851d","version":"2024.10.4","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"cd0b4b3a733644fc843ef0b185f98241","b":1}'
    crossorigin="anonymous"></script>
    <script src="{{ asset('assets/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
@if (session('message'))
    <script>
        toastr["info"]("{{ session('message') }}");
    </script>
    {{ session()->forget('message') }}
@endif
@if (session('error'))
    <script>
        toastr["warning"]("{{ session('error') }}");
    </script>
    {{ session()->forget('error') }}
@endif
