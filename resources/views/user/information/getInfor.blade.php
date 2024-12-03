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
    <title>Lấy thông tin</title>
</head>

<body>
    <form id="inforForm" action="{{ route('user.infor') }} method="POST">
        @csrf
        <div class="input-group mb-3">
            <span class="input-group-text">Tên</span>
            <input name="name" type="text" class="form-control" aria-label="Sizing example input"
                aria-describedby="inputGroup-sizing-default">
        </div>
        <div class="input-group mb-3">
            <span class="input-group-text">Số điện thoại</span>
            <input name="phone" type="text" class="form-control" aria-label="Sizing example input"
                aria-describedby="inputGroup-sizing-default">
        </div>
        <select class="form-select select2_init" name="city" id="">
            @foreach ($cities as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
            @endforeach
        </select>
        <button type="button" id="confirmInforBtn" onclick="confirmInforButton()">Xác nhận</button>
    </form>
    <script>
        $(function() {
            $(".select2_init").select2({})
        });

        function isVietnamesePhoneNumber(number) {
            return /^(0|84)(2(0[3-9]|1[0-6|8|9]|2[0-2|5-9]|3[2-9]|4[0-9]|5[1|2|4-9]|6[0-3|9]|7[0-7]|8[0-9]|9[0-4|6|7|9])|3[2-9]|5[5|6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])([0-9]{7})$/
                .test(number);
        };
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        function confirmInforButton() {
            var name = $('input[name="name"]').val();
            var phone = $('input[name="phone"]').val();
            var city = $('select[name="city"]').val();
            var isValid = true;
            if (name == '' || phone == '' || city == '') {
                toastr["error"]("Vui lòng nhâp đầy đủ thông tin");
                isValid = false;
                return;
            }
            if (!isVietnamesePhoneNumber(phone)) {
                toastr["warning"]("Số điện thoại không hợp lệ");
                isValid = false;
                return;
            }
            if (phone.startsWith('84')) {
                phone = '0' + phone.slice(2);
            }
            // if (isValid) {
            //     $('#inforForm').attr('action', '{{ route('user.infor') }}');
            //     $('#inforForm').attr('method', 'POST');
            //     var csrfToken = $('input[name="_token"]').val();
            //     $('input[name="_token"]').val(csrfToken);

            //     $('#inforForm').submit();
            // }
            if(isValid){
                var csrfToken = $('input[name="_token"]').val();

                $.ajax({
                    url: '{{ route('user.infor') }}',
                    type: 'POST',
                    data: {
                        _token: csrfToken,
                        name: name,
                        phone: phone,
                        city: city
                    },
                    success: function(response) {
                        if (response.status === 400) {
                            toastr["warning"](response.message);
                        } else if (response.status === 500) {
                            window.location.href = '{{ route('user.verifyOtp') }}';
                        } else {
                            toastr["error"]("Có lỗi xảy ra, vui lòng thử lại.");
                        }
                    },
                    error: function() {
                        toastr["error"]("Có lỗi xảy ra, vui lòng thử lại.");
                    }
                });
            }
        }
    </script>
</body>

</html>
