@extends('administrator.layouts.master')
@section('content-header')
    @include('administrator.components.content-header', [
        'route' => route('admin-users'),
        'name' => 'Người dùng',
        'key' => 'Danh sách',
    ])
@endsection
@section('title')
    <title>Admin User</title>
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container">
                <div class="row mb-4">
                    <div class="h-100 col-md-6 d-flex align-items-center">
                        <input placeholder="MM/DD/YYYY" class="pointer me-1" type="text" name="created_at" readonly value="{{ $dateQuery ?? '' }}">
                        <input placeholder="Search" type="text" name="search" class=" me-1" value="{{ $search ?? '' }}">
                        <button type="button" class="btn btn-search me-1"><i class="fa-solid fa-search"></i></button>
                        <a href="{{ route('admin-users') }}" class="btn btn-danger"><i class="fa-solid fa-brush"></i></a>
                    </div>
                    <div class="col-md-6">
                        <div class="w-100 d-flex justify-content-end align-items-center">
                            {{-- <div class="d-flex align-items-center import-frame">
                                <input type="file" name="import_excel" id="" accept=".xlsx, .xls">
                                <button type="button" class="btn btn-light mr-1 btn-import"><i>Import</i></button>
                            </div>
                            <a href="#" class="btn btn-open-import"><i class="fa-solid fa-download"></i></a> --}}
                            <a href="{{ route('admin-users.export') }}" class="btn btn-custom ms-1"><i
                                    class="fa-solid fa-file-excel"></i></a>
                            @can('user_add')
                            <a href="{{ route('admin-users.create') }}" class="btn btn-success ms-1"><i
                                    class="fa-solid fa-plus"></i></a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12 table-responsive">
                        <table class="table table-striped table-bordered table-custom align-middle">
                            <thead>
                                <tr>
                                    <th class="col-width-50" scope="col" class="table-check-delete"><input
                                            type="checkbox" name="" id="select-all"></th>
                                    <th class="col-width-50" scope="col">Id</th>
                                    <th scope="col-width-100">Tên</th>
                                    <th class="col-width-100" scope="col">Số điện thoại</th>
                                    <th class="col-width-100" scope="col">Xác thực</th>
                                    <th class="col-width-100" scope="col">Thành phố</th>
                                    <th class="col-width-100" scope="col">Biển số</th>
                                    <th class="col-width-100" scope="col">Ngày tạo</th>
                                    <th class="col-width-100" scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td scope="col"><input type="checkbox" class="row-checkbox"
                                                data-id={{ $user->id }} value="{{ $user->id }}"></td>
                                        <td scope="col">{{ $user->id }}</td>
                                        <td scope="col" class="w-50">
                                            <input class="input-name bg-secondary-subtle p-2 w-100 d-none"
                                                type="text" value="{{ $user->name }}" name="name">
                                            <p class="p-0 m-0 data-name">{{ $user->name }}</p>
                                        </td>
                                        <td scope="col" class="w-25">
                                            <input class="input-phone number bg-secondary-subtle p-2 w-100 d-none"
                                                type="text" value="{{ $user->phone }}" name="phone">
                                            <p class="p-0 m-0 data-phone">{{ $user->phone }}</p>
                                        </td>
                                        <td scope="col">
                                            <select class="form-select select2_init" disabled name="phone_verified_at" id="">
                                                <option value="0" {{ $user->phone_verified_at != null ? ' selected' : ''}}>Đã xác thực</option>
                                                <option value="1" {{ $user->phone_verified_at == null ? ' selected' : ''}}>Chưa xác thực</option>
                                            </select>
                                        </td>
                                        <td scope="col">
                                            <select class="form-select select2_init" disabled name="city_id" id="">
                                                @foreach ($cities as $city)
                                                    <option value="{{ $city->id }}" {{ $user->city_id == $city->id ? ' selected' : '' }}>{{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td scope="col">
                                            <div class="container">
                                                <div class="row overflow-scroll" style="height: 100px !important;">
                                                    @foreach ($user->licensePlate as $licensePlate)
                                                        <div class="col-lg-8 mb-2">
                                                            <div class="mb-4 mb-md-0 d-flex gap-4 your-brand">
                                                                <div
                                                                    class="wd-100 ht-100 position-relative overflow-hidden border border-gray-2 rounded">
                                                                    <img src="{{ $licensePlate->image_path }}"
                                                                        class="upload-pic img-fluid rounded h-100 w-100 object-fit-contain"
                                                                        alt="">
                                                                    {{-- <div
                                                                        class="d-none position-absolute start-50 top-50 end-0 bottom-0 translate-middle h-100 w-100 hstack align-items-center justify-content-center c-pointer upload-button">
                                                                        <i class="feather feather-camera" aria-hidden="true"></i>
                                                                    </div>
                                                                    <input class="d-none" type="file" accept="image/*"
                                                                        name="image_path"> --}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                        <td scope="col" class="w-25">
                                            {{ $user->created_at }}
                                        </td>
                                        <td scope="col">
                                            <div class="p-0 m-0 d-flex justify-content-center">
                                                @can('user_edit')
                                                <a class="btn btn-primary edit-button" href="#"><i
                                                        class="fa-solid fa-pen"></i></a>
                                                @endcan
                                                @can('user_delete')
                                                <a data-url="{{ route('admin-users.delete', ['id' => $user->id]) }}"
                                                    class="btn btn-danger action-delete ms-1 " href="#"><i
                                                        class="fa-solid fa-trash-can"></i></a>
                                                <a data-url="{{ route('admin-users.multiDelete') }}"
                                                    class="btn btn-warning action-multi-delete ms-1 d-none"
                                                    href="#"><i class="fa-solid fa-trash-can-arrow-up"></i></a>
                                                @endcan
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-12">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <style>

    </style>
@endsection

@section('script')
    <script>
        var queryUrl = "{{ route('admin-users.query', ['query' => ':query']) }}";
        var reloadUrl = "{{ route('admin-users') }}";
        $(document).ready(function() {
            $('.edit-button').on('click', function(event) {
                event.preventDefault();
                enableEdit.call(this);
            });
            // Xử lý sự kiện thay đổi của .input-name
            $('.input-name').on('change', function() {
                changeNameInput.call(this);
            });
            $('.input-phone').on('change', function() {
                changeNameInput.call(this);
            });
            $('.form-select').on('change', function() {
                changeNameInput.call(this);
            });
            // // Xử lý sự kiện thay đổi của input[name="image_path"]
            // $('input[name="image_front_path"]').on('change', function() {
            //     changeImageInput.call(this);
            // });
            // $('input[name="image_back_path"]').on('change', function() {
            //     changeImageInput.call(this);
            // });
            // $('.btn-import').on('click', function(event) {
            //     event.preventDefault();
            //     importFileExcel.call(this);
            // });
        });
        // function importFileExcel(){
        //     var csrfToken = $('meta[name="csrf-token"]').attr('content');
        //     var excelFile = $('input[name="import_excel"]')[0].files[0];
        //     if (!excelFile) {
        //         toastr["warning"]("Chưa chọn tệp để chèn dữ liệu");
        //         return;
        //     }
        //     var formData = new FormData();
        //     formData.append('import_excel', excelFile);
        //     formData.append('_token', csrfToken);
        //     $.ajax({
        //         url: '{{ route('cars.import') }}',
        //         type: 'POST',
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function(response) {
        //             if(response.status == 200){
        //                 Swal.fire({
        //                     title: "Thêm thành công",
        //                     text: "Tệp của bạn đã được thêm.",
        //                     icon: "success",
        //                 }).then(() => {
        //                     window.location.reload();
        //                 });
        //             }else if(response.status == 500){
        //                 Swal.fire({
        //                     title: "Thêm thất bại",
        //                     text: "Có lỗi xảy ra. Vui lòng thử lại.",
        //                     icon: "error",
        //                 }).then(() => {
        //                     window.location.reload();
        //                 });
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             console.log(xhr.responseText);
        //             Swal.fire({
        //                 title: "Thêm thất bại",
        //                 text: "Có lỗi xảy ra. Vui lòng thử lại.",
        //                 icon: "error",
        //             }).then(() => {
        //                 window.location.reload();
        //             });
        //         }
        //     });
        // }
        function enableEdit(){
            var row = $(this).closest('tr');
            var isEditing = row.find('.input-name').hasClass('d-none');
            if (isEditing) {
                row.find('.input-name').removeClass('d-none');
                row.find('.input-phone').removeClass('d-none');
                row.find('.upload-button').removeClass('d-none');
                row.find('.form-select').prop("disabled", false);
                row.find('input[name="image_path"]').removeClass('d-none');
                row.find('.data-name').addClass('d-none');
                row.find('.data-phone').addClass('d-none');
                $(this).addClass('btn-secondary');
            } else {
                row.find('.input-name').addClass('d-none');
                row.find('.input-phone').addClass('d-none');
                row.find('.upload-button').addClass('d-none');
                row.find('.form-select').prop("disabled", true);
                row.find('input[name="image_path"]').addClass('d-none');
                row.find('.data-name').removeClass('d-none');
                row.find('.data-phone').removeClass('d-none');
                $(this).removeClass('btn-secondary');
            }
        }
        function changeNameInput() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var row = $(this).closest('tr');
            var id = row.find('input[type="checkbox"]').val();
            var name = row.find('.input-name').val();
            var phone = row.find('.input-phone').val();
            var phone_verified_at = row.find('select[name="phone_verified_at"]').val();
            var city_id = row.find('select[name="city_id"]').val();
            if(name == ''){
                Swal.fire({
                    title: "Sửa thất bại",
                    text: "Dữ liệu của bạn không thể rỗng.",
                    icon: "error",
                });
                return;
            }
            if(!isVietnamesePhoneNumber(phone)){
                Swal.fire({
                    title: "Sửa thất bại",
                    text: "Số điện thoại không hợp lệ.",
                    icon: "error",
                });
                return;
            }
            if (phone.startsWith('84')) {
                phone = '0' + phone.slice(2);
            }
            var formData = new FormData();
            formData.append('id', id);
            formData.append('name', name);
            formData.append('phone', phone);
            formData.append('phone_verified_at', phone_verified_at);
            formData.append('city_id', city_id);
            formData.append('_token', csrfToken);
            $.ajax({
                url: '{{ route('admin-users.edit') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.status == 200){
                        row.find('.data-name').text(name);
                        row.find('.data-phone').text(phone);
                    }else if(response.status == 500){
                        Swal.fire({
                            title: "Sửa thất bại",
                            text: "Có lỗi xảy ra. Vui lòng thử lại.",
                            icon: "error",
                        }).then(() => {
                            // window.location.reload();
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                    Swal.fire({
                        title: "Sửa thất bại",
                        text: "Có lỗi xảy ra. Vui lòng thử lại.",
                        icon: "error",
                    }).then(() => {
                        // window.location.reload();
                    });
                }
            });
        }
        // function changeImageInput() {
        //     var csrfToken = $('meta[name="csrf-token"]').attr('content');
        //     var row = $(this).closest('tr');
        //     var id = row.find('input[type="checkbox"]').val();
        //     var name = row.find('.input-name').val();
        //     var typeCar_id = row.find('select[name="typeCar_id"]').val();
        //     var formData = new FormData();
        //     formData.append('id', id);
        //     formData.append('name', name);
        //     formData.append('typeCar_id', typeCar_id);
        //     formData.append('_token', csrfToken);
        //     if (this.files.length > 0) {
        //         var inputName = $(this).attr('name');
        //         if (inputName === 'image_front_path') {
        //             formData.append('image_front_path', this.files[0]);
        //         } else if (inputName === 'image_back_path') {
        //             formData.append('image_back_path', this.files[0]);
        //         }
        //     }
        //     $.ajax({
        //         url: '{{ route('cars.edit') }}',
        //         type: 'POST',
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function(response) {
        //             if(response.status == 500){
        //                 Swal.fire({
        //                     title: "Sửa thất bại",
        //                     text: "Có lỗi xảy ra. Vui lòng thử lại.",
        //                     icon: "error",
        //                 }).then(() => {
        //                     window.location.reload();
        //                 });
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             // console.log(xhr.responseText);
        //             Swal.fire({
        //                 title: "Sửa thất bại",
        //                 text: "Có lỗi xảy ra. Vui lòng thử lại.",
        //                 icon: "error",
        //             }).then(() => {
        //                 window.location.reload();
        //             });
        //         }
        //     });
        // }
    </script>
@endsection
