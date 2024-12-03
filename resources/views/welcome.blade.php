<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <title>Laravel</title>
</head>

<body>
    {{-- <form id="licensePlateForm" method="post">
        @csrf
        <select class="form-select select2_init" name="city" id="">
            @foreach ($cities as $city)
                <option value="{{ $city->id }}">{{ $city->name }}</option>
            @endforeach
        </select> --}}
        <button class="m-3 btn btn-primary" type="button" id="generateButton" onclick="generatePlate()">Generate License Plate</button>
    {{-- </form> --}}
    <div style="width: fit-content;" id="licensePlate">
        <h3 style="background: white; color: black;"></h3>
    </div>
    <h4></h4>
    <h5></h5>
    <script>
        $(function() {
            $(".select2_init").select2({
            })
        });
        function generatePlate() {
            $('#generateButton').prop('disabled', true);
            $.ajax({
                url: '{{ route('plate.create') }}',
                method: 'post',
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function(response) {
                    if (response.status == 500) {
                        $('#licensePlate h3').text(response.data);
                        $('h4').text('Định giá khoảng ' + response.price + ' Triệu VNĐ');
                        $('h5').text(response.message);
                        var div = document.getElementById('licensePlate');
                        html2canvas(div).then(function(canvas) {
                            var imgData = canvas.toDataURL('image/png');
                            document.body.append(canvas);
                            console.log(imgData);
                            storeData(response, imgData)
                        });
                    } else if (response.status == 400) {
                        $('#licensePlate h3').text('');
                        $('h4').text('');
                        $('h5').text(response.message);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }

        function storeData(data, imgData) {
            var formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('license_number', data.data);
            formData.append('price', data.price);

            var byteString = atob(imgData.split(',')[1]);
            var mimeString = imgData.split(',')[0].split(':')[1].split(';')[0];
            var ab = new ArrayBuffer(byteString.length);
            var ia = new Uint8Array(ab);
            for (var i = 0; i <byteString.length; i++) {
                ia[i] = byteString.charCodeAt(i);
            }
            var blob = new Blob([ab], {
                type: mimeString
            });
            formData.append('image_path', blob, 'license_plate.png');
            $.ajax({
                url: '{{ route('plate.store') }}',
                method: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function(storeResponse) {
                    if (storeResponse.status == 500) {
                        console.log('Biển số đã được lưu:', storeResponse);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
        $(document).ready(function() {
            $.ajax({
                url: '{{ route('plate.check') }}',
                method: 'get',
                success: function(response) {
                    if (response.status == 400) {
                        $('#generateButton').prop('disabled', true);
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
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
