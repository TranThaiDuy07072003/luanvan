@extends('layouts.admin')

@section('title', 'Thêm Món Ăn')

{{-- 1. ĐẨY CSS LÊN ĐẦU TRANG --}}
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--single {
            height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
    </style>
@endsection

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>QUẢN LÝ MÓN ĂN</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Thêm Món Ăn Mới</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            <form action="{{ route('admin.recipes.add') }}" method="POST" enctype="multipart/form-data"
                                class="form-horizontal form-label-left">
                                @csrf

                                {{-- PHẦN 1: THÔNG TIN CHUNG --}}
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Tên Món Ăn <span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" name="name" required class="form-control"
                                            placeholder="Ví dụ: Canh chua cá lóc">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Mô Tả</label>
                                    <div class="col-md-6 col-sm-6">
                                        <textarea name="description" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Hình Ảnh <span
                                            class="required">*</span></label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="file" name="image" required class="form-control" accept="image/*">
                                    </div>
                                </div>

                                <div class="ln_solid"></div>

                                {{-- PHẦN 2: CHỌN NGUYÊN LIỆU --}}
                                <h2 class="text-center text-success">Thành Phần Nguyên Liệu</h2>
                                <p class="text-center text-muted">Tìm kiếm và thêm các nguyên liệu cần thiết cho món này</p>

                                <div class="col-md-10 offset-md-1">
                                    <table class="table table-bordered" id="ingredients-table">
                                        <thead>
                                            <tr class="headings">
                                                <th style="width: 50%">Tên Nguyên Liệu (Gõ để tìm)</th>
                                                <th style="width: 15%">Đơn Vị</th>
                                                <th style="width: 15%">Hành động</th>
                                            </tr>
                                        </thead>
                                        <tbody id="ingredients-body">
                                            <tr class="ingredient-row">
                                                <td>
                                                    <select name="products[]" class="form-control product-select"
                                                        style="width: 100%" required>
                                                        <option value="">Gõ tên rau củ...</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" readonly class="form-control unit-display"
                                                        style="background: white; border: none;">
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm btn-remove-row"><i
                                                            class="fa fa-close"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <button type="button" class="btn btn-info btn-sm" id="btn-add-row"><i
                                            class="fa fa-plus"></i> Thêm dòng nguyên liệu</button>
                                </div>

                                <div class="clearfix"></div>
                                <div class="ln_solid"></div>

                                <div class="form-group row">
                                    <div class="col-md-9 col-sm-9 offset-md-3">
                                        <a href="{{ route('admin.recipes.index') }}" class="btn btn-secondary">Hủy</a>
                                        <button type="submit" class="btn btn-success">Lưu Món Ăn</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- 2. ĐẨY JS XUỐNG CUỐI TRANG (Sau khi jQuery đã load) --}}
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {

            // 1. Khởi tạo Select2 cho dòng đầu tiên
            initSelect2($('.product-select'));

            // 2. Sự kiện nút "Thêm dòng"
            $('#btn-add-row').click(function() {
                let newRow = `
                <tr class="ingredient-row">
                    <td>
                        <select name="products[]" class="form-control product-select" style="width: 100%" required>
                            <option value="">Gõ tên rau củ...</option>
                        </select>
                    </td>
                    <td>
                        <input type="text" readonly class="form-control unit-display" style="background: white; border: none;">
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm btn-remove-row"><i class="fa fa-close"></i></button>
                    </td>
                </tr>
            `;
                $('#ingredients-body').append(newRow);

                // Khởi tạo Select2 cho dòng vừa thêm
                initSelect2($('#ingredients-body tr:last .product-select'));
            });

            // 3. Sự kiện nút "Xóa dòng"
            $(document).on('click', '.btn-remove-row', function() {
                if ($('.ingredient-row').length > 1) {
                    $(this).closest('tr').remove();
                } else {
                    alert('Món ăn phải có ít nhất 1 nguyên liệu!');
                }
            });

            // HÀM CẤU HÌNH SELECT2 (TÌM KIẾM AJAX)
            function initSelect2(element) {
                element.select2({
                    placeholder: 'Gõ tên sản phẩm để tìm...',
                    allowClear: true,
                    ajax: {
                        url: "{{ route('admin.recipes.search_products') }}",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            return {
                                term: params.term
                            };
                        },
                        processResults: function(data) {
                            return {
                                results: data.results
                            };
                        },
                        cache: true
                    }
                });

                element.on('select2:select', function(e) {
                    var data = e.params.data;
                    $(this).closest('tr').find('.unit-display').val(data.unit);
                });
            }
        });
    </script>
@endsection
