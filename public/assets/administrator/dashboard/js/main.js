$(document).ready(function () {
    $('.action-delete').click(function(e) {
        e.preventDefault();
        let urlRequest = $(this).data("url");
        let that = $(this);
        Swal.fire({
            title: "Bạn chắc chứ?",
            text: "Bạn sẽ không thể lấy được dữ liệu ban đầu",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Tôi đồng ý!",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: urlRequest,
                    success: function (response) {
                        if (response.status == 200) {
                            that.parent().parent().parent().remove();
                            Swal.fire({
                                title: "Xóa thành công",
                                text: "Dữ liệu của bạn đã bị xóa",
                                icon: "success",
                            }).then(() => {
                                // window.location.reload();
                            });
                        } else if (response.status == 500) {
                            location.reload();
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            title: "Xóa thất bại",
                            text: "Có lỗi xảy ra. Vui lòng thử lại.",
                            icon: "error",
                        }).then(() => {
                            // window.location.reload();
                        });
                    },
                });
            }
        });
    });
    $('.action-multi-delete').click(function(e) {
        e.preventDefault();
        var selectedIds = [];
        $('tbody .row-checkbox:checked').each(function() {
            selectedIds.push($(this).data('id'));
        });
        if (selectedIds.length > 0) {
            let urlRequest = $(this).data('url');
            Swal.fire({
                title: "Bạn chắc chứ?",
                text: "Bạn sẽ không thể lấy được dữ liệu ban đầu",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#2a2af9",
                cancelButtonColor: "#ff0000",
                confirmButtonText: "Tôi đồng ý!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    var formData = new FormData();
                    selectedIds.forEach(function(id) {
                        formData.append('ids[]', id);
                    });
                    formData.append('_token', csrfToken);
                    $.ajax({
                        type: 'POST',
                        url: urlRequest,
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if(response.status == 200) {
                                Swal.fire({
                                    title: "Xóa thành công",
                                    text: "Dữ liệu của bạn đã bị xóa",
                                    icon: "success",
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else if (response.status == 500) {
                                location.reload();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log(xhr.responseText);
                            console.log(xhr.statusText);
                            console.log(status);
                            console.log(error);
                            Swal.fire({
                                title: "Xóa thất bại",
                                text: "Có lỗi xảy ra. Vui lòng thử lại.",
                                icon: "error",
                            }).then(() => {
                                // window.location.reload();
                            });
                        }
                    })
                }
            });
        }
    });
    // Handle row checkbox change
    $(".row-checkbox").change(function () {
        var $row = $(this).closest("tr");
        var $actionDelete = $row.find(".action-delete");
        var $actionMultiDelete = $row.find(".action-multi-delete");

        if ($(this).is(":checked")) {
            $actionDelete.addClass("d-none");
            $actionMultiDelete.removeClass("d-none");
        } else {
            $actionDelete.removeClass("d-none");
            $actionMultiDelete.addClass("d-none");
        }

        // Update header checkbox state
        var allChecked =
            $("tbody .row-checkbox").length ===
            $("tbody .row-checkbox:checked").length;
        $("#select-all").prop("checked", allChecked);
    });

    // Handle header checkbox change
    $("#select-all").change(function () {
        var isChecked = $(this).is(":checked");
        $("tbody .row-checkbox").prop("checked", isChecked).trigger("change");
    });
    "use strict";
    $("input[name='image_path']").on("change", function () {
        previewSelectedImage.call(this);
    });
    $("input[name='image_front_path']").on("change", function () {
        previewSelectedImage.call(this);
    });
    $("input[name='image_back_path']").on("change", function () {
        previewSelectedImage.call(this);
    });

    $(".upload-button").on("click", function () {
        $(this).closest('.your-brand').find("input[name='image_path']").click();
        $(this).closest('.your-brand').find("input[name='image_front_path']").click();
        $(this).closest('.your-brand').find("input[name='image_back_path']").click();
    });
    $('.btn-open-import').on('click', function(e) {
        e.preventDefault();
        $('input[name="import_excel"]').click();
    });
    $('input[name="import_excel"]').on('change', function() {
        importFileExcel(this);
    });
    $('.btn-search').on('click', function() {
        searchWithQuerySearch(this);
    });
    $('input[name="search"]').on('keypress', function (e) {
        if(e.which === 13){

           //Disable textbox to prevent multiple submit
           $(this).attr("disabled", "disabled");
           searchWithQuerySearch(this);
           $(this).removeAttr("disabled");
        }
  });
});
$(function() {
    $(".select2_init").select2({
    });
    $('input[name="created_at"]').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });
    $('input[name="created_at"]').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
        searchWithQueryDate(this);
    });

    $('input[name="created_at"]').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        searchWithQuerySearch(this);
    });
});
function previewSelectedImage() {
    var input = this;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(input).closest('.your-brand').find('.upload-pic').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
function searchWithQueryDate()
{
    var value = $('input[name="created_at"]').val();
    value = value.replaceAll(" - ", "?");
    value = value.replaceAll("/", "-");
    value += "?";
    value += $('input[name="search"]').val();
    var url = queryUrl.replace(':query', encodeURIComponent(value));
    window.location.href = url;
}
function searchWithQuerySearch()
{
    var value = $('input[name="created_at"]').val();
    var search = $('input[name="search"]').val();
    if(!value && !search){
        window.location.href = reloadUrl;
        return;
    }
    if(!value){
        value += "?";
    }else{
        value = value.replaceAll(" - ", "?");
        value = value.replaceAll("/", "-");
    }
    value += "?";
    value += search;
    var url = queryUrl.replace(':query', encodeURIComponent(value));
    window.location.href = url;
}
