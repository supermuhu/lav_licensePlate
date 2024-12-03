@extends('administrator.layouts.master')
@section('content-header')
    @include('administrator.components.content-header', [
        'route' => route('cars'),
        'name' => 'Xe',
        'key' => 'Thêm',
    ])
@endsection
@section('title')
    <title>Admin Cars</title>
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
                                    <span class="d-block mb-2">Thông tin của xe</span>
                                    <span class="fs-12 fw-normal text-muted text-truncate-1-line">Thông tin sau đây là thị công khai, hãy cẩn thận! </span>
                                </h5>
                            </div>
                            <div class="row mb-4 align-items-center">
                                <div class="col-lg-4">
                                    <label class="fw-semibold">Ảnh mặt trước: </label>
                                </div>
                                <div class="col-lg-8">
                                    <div class="mb-4 mb-md-0 d-flex gap-4 your-brand">
                                        <div
                                            class="wd-100 ht-100 position-relative overflow-hidden border border-gray-2 rounded">
                                            <img src="{{ asset('assets/images/default/front-car.png') }}"
                                                class="upload-pic img-fluid rounded h-100 w-100 object-fit-contain img-status-none"
                                                alt="">
                                            <div
                                                class="position-absolute start-50 top-50 end-0 bottom-0 translate-middle h-100 w-100 hstack align-items-center justify-content-center c-pointer upload-button">
                                                <i class="feather feather-camera" aria-hidden="true"></i>
                                            </div>
                                            <input class="file-upload" type="file" accept="image/*" name="image_front_path">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4 align-items-center">
                                <div class="col-lg-4">
                                    <label class="fw-semibold">Ảnh mặt sau: </label>
                                </div>
                                <div class="col-lg-8">
                                    <div class="mb-4 mb-md-0 d-flex gap-4 your-brand">
                                        <div
                                            class="wd-100 ht-100 position-relative overflow-hidden border border-gray-2 rounded">
                                            <img src="{{ asset('assets/images/default/back-car.png') }}"
                                                class="upload-pic img-fluid rounded h-100 w-100 object-fit-contain img-status-none"
                                                alt="">
                                            <div
                                                class="position-absolute start-50 top-50 end-0 bottom-0 translate-middle h-100 w-100 hstack align-items-center justify-content-center c-pointer upload-button">
                                                <i class="fa-solid fa-camera"></i>
                                            </div>
                                            <input class="file-upload" type="file" accept="image/*" name="image_back_path">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4 align-items-center">
                                <div class="col-lg-4">
                                    <label for="fullnameInput" class="fw-semibold">Tên xe: </label>
                                </div>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <div class="input-group-text"><i class="fa-solid fa-car"></i></div>
                                        <input type="text" class="form-control" id="fullnameInput" placeholder="Tên" name="name">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-4 align-items-center">
                                <div class="col-lg-4">
                                    <label for="fullnameInput" class="fw-semibold">Hãng xe: </label>
                                </div>
                                <div class="col-lg-8">
                                    <div class="input-group">
                                        <select class="form-select select2_init" name="typeCar_id" id="">
                                            @foreach ($typecars as $typecar)
                                                <option value="{{ $typecar->id }}">{{ $typecar->name }}</option>
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
                var typeCar_id = $('select[name="typeCar_id"]').val();
                var image_front_path = $('input[name="image_front_path"]')[0].files[0];
                if (!image_front_path) {
                    toastr["warning"]("Vui lòng chọn ảnh mặt trước cho xe");
                    return;
                }
                var image_back_path = $('input[name="image_back_path"]')[0].files[0];
                if (!image_back_path) {
                    toastr["warning"]("Vui lòng chọn ảnh mặt sau cho xe");
                    return;
                }
                if (name == '') {
                    toastr["warning"]("Vui lòng nhâp đầy đủ thông tin");
                    return;
                }
                $('#btn-create').prop('disabled', true);
                formData = new FormData();
                formData.append('_token', csrfToken);
                formData.append('name',name);
                formData.append('image_front_path', image_front_path);
                formData.append('image_back_path', image_back_path);
                formData.append('typeCar_id', typeCar_id);
                $.ajax({
                    url: '{{ route('cars.store') }}',
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
                                window.location.href = '{{ route('cars') }}';
                            });
                        }else if(response.status == 400){
                            Swal.fire({
                                title: "Thêm thất bại",
                                text: "Xe đã tồn tại",
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
                        // console.log(xhr.responseText);
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
