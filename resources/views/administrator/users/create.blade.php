@extends('administrator.layouts.master')
@section('content-header')
    @include('administrator.components.content-header', [
        'route' => route('admin-users'),
        'name' => 'Người dùng',
        'key' => 'Thêm',
    ])
@endsection
@section('title')
    <title>Admin Users</title>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card border-top-0">
                <div class="card-header p-0">
                    <ul class="nav nav-tabs flex-wrap w-100 text-center customers-nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item flex-fill border-top" role="presentation">
                            <a href="javascript:void(0);" class="nav-link active" data-bs-toggle="tab"
                                data-bs-target="#informationTab" role="tab">Thông tin</a>
                        </li>
                        {{-- <li class="nav-item flex-fill border-top" role="presentation">
                        <a href="javascript:void(0);" class="nav-link" data-bs-toggle="tab" data-bs-target="#passwordTab" role="tab">Password</a>
                    </li>
                    <li class="nav-item flex-fill border-top" role="presentation">
                        <a href="javascript:void(0);" class="nav-link" data-bs-toggle="tab" data-bs-target="#billingTab" role="tab">Billing & Shipping</a>
                    </li>
                    <li class="nav-item flex-fill border-top" role="presentation">
                        <a href="javascript:void(0);" class="nav-link" data-bs-toggle="tab" data-bs-target="#subscriptionTab" role="tab">Subscription</a>
                    </li>
                    <li class="nav-item flex-fill border-top" role="presentation">
                        <a href="javascript:void(0);" class="nav-link" data-bs-toggle="tab" data-bs-target="#notificationsTab" role="tab">Notifications</a>
                    </li>
                    <li class="nav-item flex-fill border-top" role="presentation">
                        <a href="javascript:void(0);" class="nav-link" data-bs-toggle="tab" data-bs-target="#connectionTab" role="tab">Connection</a>
                    </li> --}}
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="informationTab" role="tabpanel">
                        <div class="card-body personal-info">
                            <div class="mb-4 d-flex align-items-center justify-content-between">
                                <h5 class="fw-bold mb-0 me-4">
                                    <span class="d-block mb-2">Thông tin người dùng:</span>
                                    <span class="fs-12 fw-normal text-muted text-truncate-1-line">Thông tin sau đây là thị công khai, hãy cẩn thận! </span>
                                </h5>
                            </div>
                            <div class="row mb-4 align-items-center">
                                <div class="col-lg-4">
                                    <label for="fullnameInput" class="fw-semibold">Tên người dùng: </label>
                                </div>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fa-solid fa-user"></i></div>
                                        <input type="text" class="form-control" id="fullnameInput" placeholder="Tên" name="name">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4 align-items-center">
                                <div class="col-lg-4">
                                    <label for="fullnameInput" class="fw-semibold">Mật khẩu: </label>
                                </div>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fa-solid fa-lock"></i></div>
                                        <input type="password" class="form-control" id="fullnameInput" placeholder="Mật khẩu" name="password" value="1">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4 align-items-center">
                                <div class="col-lg-4">
                                    <label for="fullnameInput" class="fw-semibold">Số điện thoại: </label>
                                </div>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fa-solid fa-phone"></i></div>
                                        <input type="text" class="form-control" id="fullnameInput" placeholder="Điện thoại" name="phone">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4 align-items-center">
                                <div class="col-lg-4">
                                    <label for="fullnameInput" class="fw-semibold">Thành phố: </label>
                                </div>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <select class="form-select select2_init" name="city_id" id="">
                                            @foreach ($cities as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1 align-items-center">
                                <div class="col-lg-1">
                                    <button class="btn btn-primary" type="button" id="btn-create">Tạo</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            $('#btn-create').on('click', function() {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var name = $('input[name="name"]').val();
                var password = $('input[name="password"]').val();
                var phone = $('input[name="phone"]').val();
                var city_id = $('select[name="city_id"]').val();
                if(name == '' || password == ''){
                    Swal.fire({
                        title: "Thêm thất bại",
                        text: "Dữ liệu của bạn không thể rỗng.",
                        icon: "error",
                    });
                    return;
                }
                if(!isVietnamesePhoneNumber(phone)){
                    Swal.fire({
                        title: "Thêm thất bại",
                        text: "Số điện thoại không hợp lệ.",
                        icon: "error",
                    });
                    return;
                }

                $('#btn-create').prop('disabled', true);
                formData = new FormData();
                formData.append('_token', csrfToken);
                formData.append('name',name);
                formData.append('password',password);
                formData.append('phone',phone);
                formData.append('city_id',city_id);
                $.ajax({
                    url: '{{ route('admin-users.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if(response.status == 200){
                            Swal.fire({
                                title: "Thêm thành công",
                                text: "Dữ liệu của bạn đã được thêm.",
                                icon: "success",
                            }).then(() => {
                                window.location.href = '{{ route('admin-users') }}';
                            });
                        }else if(response.status == 400){
                            Swal.fire({
                                title: "Thêm thất bại",
                                text: "Số điện thoại đã tồn tại",
                                icon: "info",
                            }).then(() => {
                                // window.location.reload();
                                $('#btn-create').prop('disabled', false);
                            });
                        }else if(response.status == 500){
                            Swal.fire({
                                title: "Thêm thất bại",
                                text: "Có lỗi xảy ra. Vui lòng thử lại.",
                                icon: "error",
                            }).then(() => {
                                // window.location.reload();
                                $('#btn-create').prop('disabled', false);
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText);
                        Swal.fire({
                            title: "Thêm thất bại",
                            text: "Có lỗi xảy ra. Vui lòng thử lại.",
                            icon: "error",
                        }).then(() => {
                            // window.location.reload();
                            $('#btn-create').prop('disabled', false);
                        });
                    }
                });
            });
        });
    </script>
@endsection
