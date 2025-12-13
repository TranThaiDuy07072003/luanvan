@extends('layouts.admin')
@section('title', 'Quản lý Món Ăn')

@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>DANH SÁCH MÓN ĂN</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Công thức nấu ăn</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a href="{{ route('admin.recipes.add') }}" class="btn btn-success text-white"><i
                                            class="fa fa-plus"></i> Thêm Món Mới</a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Hình ảnh</th>
                                        <th>Tên Món</th>
                                        <th>Số lượng nguyên liệu</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($recipes as $recipe)
                                        <tr>
                                            <td>{{ $recipe->id }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $recipe->image) }}" width="80px">
                                            </td>
                                            <td>
                                                <strong>{{ $recipe->name }}</strong><br>
                                                <small>{{ Str::limit($recipe->description, 50) }}</small>
                                            </td>
                                            <td>
                                                <span class="badge badge-info"
                                                    style="font-size: 14px;">{{ $recipe->products_count }} loại</span>
                                            </td>
                                            <td>
                                                {{-- Nút Sửa/Xóa sau này làm tiếp --}}
                                                <button class="btn btn-sm btn-primary">Sửa</button>
                                                <a href="javascript:void(0)" class="btn btn-sm btn-danger btn-delete-recipe"
                                                    data-id="{{ $recipe->id }}">
                                                    <i class="fa fa-trash"></i> Xóa
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // XỬ LÝ SỰ KIỆN CLICK NÚT XÓA
        $(document).on('click', '.btn-delete-recipe', function(e) {
            e.preventDefault();

            let btn = $(this);
            let id = btn.data('id');
            let row = btn.closest('tr'); // Lấy dòng chứa nút bấm để tí nữa xóa

            if (confirm("Bạn có chắc chắn muốn xóa món ăn này không? Hành động này không thể hoàn tác!")) {
                $.ajax({
                    url: "{{ route('admin.recipes.delete') }}", // Gọi route xóa
                    type: 'POST',
                    data: {
                        id: id,
                        _token: $('meta[name="csrf-token"]').attr('content') // Token bảo mật Laravel
                    },
                    beforeSend: function() {
                        btn.text('Đang xóa...'); // Hiệu ứng nhỏ cho người dùng biết
                    },
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message); // Hiện thông báo xanh
                            row.fadeOut(500, function() { $(this).remove(); }); // Hiệu ứng biến mất dòng đó
                        } else {
                            toastr.error(response.message); // Hiện thông báo đỏ
                            btn.html('<i class="fa fa-trash"></i> Xóa'); // Trả lại nút cũ
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr);
                        toastr.error("Có lỗi xảy ra, vui lòng thử lại.");
                        btn.html('<i class="fa fa-trash"></i> Xóa');
                    }
                });
            }
        });
    });
</script>
@endsection
