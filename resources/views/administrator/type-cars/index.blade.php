@extends('administrator.layouts.master')
@section('content-header')
    @include('administrator.components.content-header', [
        'route' => route('type-cars'),
        'name' => 'Type-cars',
        'key' => 'View',
    ])
@endsection
@section('title')
    <title>Admin Type-cars</title>
@endsection
@section('content')
    <div class="page-wrapper">
        <div class="page-content">
            <div class="container">
                <div class="row mb-4">
                    @can('typecar_list')
                    <div class="h-100 col-md-6 d-flex align-items-center">
                        <input placeholder="MM/DD/YYYY" class="pointer me-1" type="text" name="created_at" readonly value="{{ $dateQuery ?? '' }}">
                        <input placeholder="Search" type="text" name="search" class=" me-1" value="{{ $search ?? '' }}">
                        <button type="button" class="btn btn-search me-1"><i class="fa-solid fa-search"></i></button>
                        <a href="{{ route('type-cars') }}" class="btn btn-danger"><i class="fa-solid fa-brush"></i></a>
                    </div>
                    @endcan
                    <div class="col-md-6">
                        <div class="w-100 d-flex justify-content-end align-items-center">
                            @can('typecar_add')
                            <div class="d-flex align-items-center import-frame">
                                <input class="pe-auto" type="file" name="import_excel" id="" accept=".xlsx, .xls">
                                <button type="button" class="btn btn-light mr-1 btn-import"><i>Import</i></button>
                            </div>
                            <a href="#" class="btn btn-open-import"><i
                                    class="fa-solid fa-download"></i></a>
                            @endcan
                            <a href="{{ route('type-cars.export') }}" class="btn btn-custom ms-1"><i
                                    class="fa-solid fa-file-excel"></i></a>
                            @can('typecar_add')
                            <a href="{{ route('type-cars.create') }}" class="btn btn-success ms-1"><i
                                    class="fa-solid fa-plus"></i></a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-custom align-middle">
                            <thead>
                                <tr>
                                    <th class="col-width-50" scope="col" class="table-check-delete"><input
                                            type="checkbox" name="" id="select-all"></th>
                                    <th class="col-width-50" scope="col">Id</th>
                                    <th scope="col">Tên</th>
                                    <th class="col-width-100" scope="col">Hình ảnh</th>
                                    <th scope="col">Ngày tạo</th>
                                    <th class="col-width-100" scope="col">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($typecars as $typecar)
                                    <tr>
                                        <td scope="col"><input type="checkbox" class="row-checkbox"
                                                data-id={{ $typecar->id }} value="{{ $typecar->id }}"></td>
                                        <td scope="col">{{ $typecar->id }}</td>
                                        <td scope="col">
                                            <input class="input-name bg-secondary-subtle p-2 w-100 d-none"
                                                type="text" value="{{ $typecar->name }}" name="name">
                                            <p class="p-0 m-0 data-name">{{ $typecar->name }}</p>
                                        </td>
                                        <td scope="col">
                                            <div class="col-lg-8">
                                                <div class="mb-4 mb-md-0 d-flex gap-4 your-brand">
                                                    <div
                                                        class="wd-100 ht-100 position-relative overflow-hidden border border-gray-2 rounded">
                                                        <img src="{{ $typecar->image_path }}"
                                                            class="upload-pic img-fluid rounded h-100 w-100 object-fit-contain"
                                                            alt="">
                                                        <div
                                                            class="d-none position-absolute start-50 top-50 end-0 bottom-0 translate-middle h-100 w-100 hstack align-items-center justify-content-center c-pointer upload-button">
                                                            <i class="fa-solid fa-camera"></i>
                                                        </div>
                                                        <input class="d-none" type="file" accept="image/*"
                                                            name="image_path">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td scope="col" class="w-25">
                                            {{ $typecar->created_at }}
                                        </td>
                                        <td scope="col">
                                            <div class="p-0 m-0 d-flex justify-content-center">
                                                @can('typecar_edit')
                                                <a class="btn btn-primary edit-button" href="#"><i
                                                        class="fa-solid fa-pen"></i></a>
                                                @endcan
                                                @can('typecar_delete')
                                                <a data-url="{{ route('type-cars.delete', ['id' => $typecar->id]) }}"
                                                    class="btn btn-danger action-delete ms-1 " href="#"><i
                                                        class="fa-solid fa-trash-can"></i></a>
                                                <a data-url="{{ route('type-cars.multiDelete') }}"
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
                        {{ $typecars->links() }}
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
        var queryUrl = "{{ route('type-cars.query', ['query' => ':query']) }}";
        var reloadUrl = "{{ route('type-cars') }}";
        $(document).ready(function() {
            $('.edit-button').on('click', function(event) {
                event.preventDefault();
                enableEdit.call(this);
            });
            // Xử lý sự kiện thay đổi của .input-name
            $('.input-name').on('change', function() {
                changeNameInput.call(this);
            });
            // Xử lý sự kiện thay đổi của input[name="image_path"]
            $('input[name="image_path"]').on('change', function() {
                changeImageInput.call(this);
            });
        });
        function importFileExcel(input) {
            var file = input.files[0];
            if (file) {
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var excelFile = file;
                var formData = new FormData();
                formData.append('import_excel', excelFile);
                formData.append('_token', csrfToken);
                $.ajax({
                    url: '{{ route('type-cars.import') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if(response.status == 200){
                            Swal.fire({
                                title: "Thêm thành công",
                                text: "Tệp của bạn đã được thêm.",
                                icon: "success",
                            }).then(() => {
                                window.location.reload();
                            });
                        }else if(response.status == 500){
                            Swal.fire({
                                title: "Thêm thất bại",
                                text: "Có lỗi xảy ra. Vui lòng thử lại.",
                                icon: "error",
                            }).then(() => {
                                // window.location.reload();
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
                        });
                    }
                });
            }
        }
        function enableEdit(){
            var row = $(this).closest('tr');
            var isEditing = row.find('.input-name').hasClass('d-none');
            if (isEditing) {
                row.find('.input-name').removeClass('d-none');
                row.find('.upload-button').removeClass('d-none');
                row.find('input[name="image_path"]').removeClass('d-none');
                row.find('.data-name').addClass('d-none');
                $(this).addClass('btn-secondary');
            } else {
                row.find('.input-name').addClass('d-none');
                row.find('.upload-button').addClass('d-none');
                row.find('input[name="image_path"]').addClass('d-none');
                row.find('.data-name').removeClass('d-none');
                $(this).removeClass('btn-secondary');
            }
        }
        function changeNameInput() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var row = $(this).closest('tr');
            var id = row.find('input[type="checkbox"]').val();
            var name = row.find('.input-name').val();
            if(name == ''){
                Swal.fire({
                    title: "Sửa thất bại",
                    text: "Dữ liệu của bạn không thể rỗng.",
                    icon: "error",
                });
                return;
            }
            var formData = new FormData();
            formData.append('id', id);
            formData.append('name', name);
            formData.append('_token', csrfToken);
            $.ajax({
                url: '{{ route('type-cars.edit') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.status == 200){
                        row.find('.data-name').text(name);
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
                    // console.log(xhr.responseText);
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
        function changeImageInput() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var row = $(this).closest('tr');
            var id = row.find('input[type="checkbox"]').val();
            var name = row.find('.input-name').val();
            var formData = new FormData();
            formData.append('id', id);
            formData.append('name', name);
            formData.append('_token', csrfToken);
            if (this.files.length > 0) {
                formData.append('image_path', this.files[0]);
            }
            $.ajax({
                url: '{{ route('type-cars.edit') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.status == 500){
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
                    // console.log(xhr.responseText);
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
    </script>
@endsection
