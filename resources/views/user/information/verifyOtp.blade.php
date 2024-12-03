<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap_v5.3/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/select2_4.1.0-rc.0/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/toastr/css/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <script src="{{ asset('assets/jquery_3.7.1/jquery.js') }}"></script>
    <script src="{{ asset('assets/bootstrap_v5.3/js/bootstrap.bundle.js') }}"></script>
    <script src="{{ asset('assets/canvasjs/canvasjs-chart-3.10.13/canvasjs.min.js') }}"></script>
    <script src="{{ asset('assets/html2canvas_0.5.0/html2canvas.js') }}"></script>
    <script src="{{ asset('assets/select2_4.1.0-rc.0/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/toastr/js/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <title>Lấy thông tin</title>
</head>

<body>
    <div class="container">
        <div class="otp-container">
            <h2 class="text-center">OTP Verification</h2>
            <form action="{{ route('user.verifyOtp') }}" method="post">
                @csrf
                <div class="form-group mt-3">
                    <label for="otp">Enter OTP</label>
                    <input type="text" id="otp" name="otp" class="form-control otp-input" maxlength="6"
                        required value="{{ $otp }}">
                </div>
                <div class="form-group d-flex justify-content-center mt-3">
                    <button type="submit" class="btn btn-success btn-block">Verify OTP</button>
                </div>
                <div class="form-group d-flex justify-content-end">
                    <a href="{{ route('user.changeOtp') }}" class="text-decoration-none text-success">Resend OTP</a>
                </div>
            </form>
        </div>
    </div>
</body>
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
