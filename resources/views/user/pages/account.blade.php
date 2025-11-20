@extends('layouts.client')

@section('title', 'Tài khoản')
@section('breadcrumb', 'Tài khoản')

@section('content')

    <div class="liton__wishlist-area pb-70">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ltn__product-tab-area">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="ltn__tab-menu-list mb-50">
                                        <div class="nav">
                                            <a class="active show" data-bs-toggle="tab" href="#liton_tab_dashboard">Bảng
                                                điều khiển <i class="fas fa-home"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_orders">Đơn hàng <i
                                                    class="fas fa-file-alt"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_address">Địa chỉ <i
                                                    class="fas fa-map-marker-alt"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_account">Chi tiết tài khoản <i
                                                    class="fas fa-user"></i></a>
                                            <a data-bs-toggle="tab" href="#liton_tab_password">Đổi mật khẩu <i
                                                    class="fas fa-key"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="tab-content">

                                        <!-- ... (Tab Dashboard và Orders giữ nguyên) ... -->
                                        <div class="tab-pane fade active show" id="liton_tab_dashboard">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <p>Xin chào <strong>{{ $user->email }}</strong> (không phải
                                                    <strong>{{ $user->email }}</strong>?
                                                    <small><a href="{{ route('logout') }}">Đăng xuất</a></small> )
                                                </p>
                                                <p>Từ bảng điều khiển tài khoản của bạn, bạn có thể xem <span>đơn hàng gần
                                                        đây</span>, quản lý <span>địa chỉ giao hàng và thanh toán</span>,
                                                    và <span>chỉnh sửa mật khẩu và chi tiết tài khoản</span>.</p>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="liton_tab_orders">
                                             <div class="ltn__myaccount-tab-content-inner">
                                                <!-- ... nội dung đơn hàng ... -->
                                            </div>
                                        </div>

                                        <!-- ============================================= -->
                                        <!-- PHẦN 1: SỬA LẠI TAB ĐỊA CHỈ (HTML) -->
                                        <!-- ============================================= -->
                                        <div class="tab-pane fade" id="liton_tab_address">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <p>Các địa chỉ sau sẽ được sử dụng trên trang thanh toán theo mặc định.</p>
                                                <div class="table-responsive">
                                                   <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Tên người nhận</th>
                                                                <th>Địa chỉ</th>
                                                                <th>Thành phố</th>
                                                                <th>Số điện thoại</th>
                                                                <th>Mặc định</th>
                                                                <th>Hành động</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            {{-- Đảm bảo $addresses được truyền từ Controller --}}
                                                            @if(isset($addresses) && $addresses->count() > 0)
                                                                @foreach($addresses as $address)
                                                                <tr>
                                                                    <td>{{ $address->full_name }}</td>
                                                                    <td>{{ $address->address }}</td>
                                                                    <td>{{ $address->city }}</td>
                                                                    <td>{{ $address->phone }}</td>
                                                                    <td>
                                                                        @if($address->default)
                                                                            <span class="badge bg-success">Mặc định</span>
                                                                        @else
                                                                            <!-- THÊM CLASS "form-set-default" -->
                                                                            <form action="{{ route('account.addresses.update', $address->id) }}" method="POST" class="d-inline form-set-default">
                                                                                @csrf
                                                                                @method('PUT')
                                                                                <button type="submit" class="btn btn-effect-1 btn-warning btn-sm">Chọn</button>
                                                                            </form>
                                                                        @endif
                                                                    </td>
                                                                    <td>
                                                                        <!-- THÊM CLASS "form-delete-address" và XÓA onclick="" -->
                                                                        <form action="{{ route('account.addresses.delete', $address->id) }}" method="POST" class="d-inline form-delete-address">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td colspan="6" class="text-center">Bạn chưa có địa chỉ nào.</td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <button class="btn theme-btn-1 btn-effect-1 mt-3" data-bs-toggle="modal"
                                            data-bs-target="#addAddressModal">Thêm địa chỉ mới</button>
                                            </div>
                                        </div>
                                        <!-- ============================================= -->
                                        <!-- HẾT PHẦN SỬA TAB ĐỊA CHỈ -->
                                        <!-- ============================================= -->


                                        <!-- Modal Thêm Địa Chỉ (Giữ nguyên) -->
                                        <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
                                            <!-- ... (toàn bộ nội dung modal giữ nguyên) ... -->
                                            <div class="modal-dialog">
                                                <div class="modal-content" style="padding: 5px 10px">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addAddressModalLabel">Thêm địa chỉ mới</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('account.addresses.add') }}" method="POST" id="addAddressForm">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label for="full_name" class="form-lable">Tên người dùng</label>
                                                                <input type="text" class="form-control" id="full_name" name="full_name" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="address" class="form-lable">Địa chỉ</label>
                                                                <input type="text" class="form-control" id="address" name="address" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="city" class="form-lable">Thành phố</label>
                                                                <input type="text" class="form-control" id="city" name="city" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="phone" class="form-lable">Số điện thoại</label>
                                                                <input type="text" class="form-control" id="phone" name="phone" required>
                                                            </div>
                                                            <div class="mb-3 form-check" >
                                                                <input type="checkbox" class="form-check-input" id="default" name="default">
                                                                <label for="default" class="form-lable">Đặt làm địa chỉ mặc định</label>
                                                            </div>
                                                            <button type="submit" id="btn-add-address" class="btn theme-btn-1 btn btn-block">Lưu địa chỉ</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tab Chi tiết tài khoản (Giữ nguyên) -->
                                        <div class="tab-pane fade" id="liton_tab_account">
                                            <!-- ... (toàn bộ nội dung tab giữ nguyên) ... -->
                                             <div class="ltn__myaccount-tab-content-inner">
                                                <div class="ltn__form-box">
                                                    <form id="update-account-form" action="{{ route('account.update') }}">
                                                        <!-- ... (các input) ... -->
                                                         <div class="row mb-50">
                                                            <div class="col-md-6">
                                                                <label for="ltn__name">Họ và tên:</label>
                                                                <input type="text" name="ltn__name" id="ltn__name" value="{{ $user->name }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="ltn__phone_number">Số điện thoại:</label>
                                                                <input type="number" name="ltn__phone_number" id="ltn__phone_number" value="{{ $user->phone_number ?? '' }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="ltn__email">Email (không được thay đổi)</label>
                                                                <input type="email" name="ltn__email" id="ltn__email" value="{{ $user->email }}" readonly>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="ltn__address">Địa chỉ:</label>
                                                                <input type="text" name="ltn__address" id="ltn__address" value="{{ $user->address ?? '' }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="btn-wrapper">
                                                            <button type="submit" id="btn-update-info" class="btn theme-btn-1 btn-effect-1 text-uppercase">Cập nhật</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tab Đổi mật khẩu (Giữ nguyên) -->
                                        <div class="tab-pane fade" id="liton_tab_password">
                                            <!-- ... (toàn bộ nội dung tab giữ nguyên) ... -->
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <div class="ltn__form-box">
                                                    <form action="{{ route('account.change-password') }}" method="POST" id="change-password-form">
                                                        <!-- ... (các input) ... -->
                                                        <fieldset>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label>Mật khẩu hiện tại</label>
                                                                    <input type="password" name="current_password" required>
                                                                    <label>Mật khẩu mới:</label>
                                                                    <input type="password" name="new_password" required>
                                                                    <label>Xác nhận mật khẩu mới:</label>
                                                                    <input type="password" name="new_password_confirmation" autocomplete="new-password" required>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="btn-wrapper">
                                                            <button type="submit" id="btn-change-password" class="btn theme-btn-1 btn-effect-1 text-uppercase">Đổi mật khẩu</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


<!-- ============================================= -->
<!-- PHẦN 2: SỬA LẠI TOÀN BỘ SCRIPT -->
<!-- ============================================= -->
@push('scripts')
    <script>
        $(document).ready(function() {

            // --- SCRIPT 1: CẬP NHẬT THÔNG TIN ---
            $('#update-account-form').on('submit', function(e) {
                e.preventDefault();
                let btn = $('#btn-update-info');
                let originalText = btn.text();
                btn.prop('disabled', true).text('Đang lưu...');
                let formData = new FormData(this);
                formData.append('_method', 'PUT');

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message, 'Thành công!');
                            $('input[name="ltn__name"]').val(response.user.name);
                            $('input[name="ltn__phone_number"]').val(response.user.phone_number);
                            $('input[name="ltn__address"]').val(response.user.address);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0], 'Lỗi nhập liệu');
                            });
                        } else {
                            toastr.error('Có lỗi xảy ra, vui lòng thử lại.', 'Lỗi hệ thống');
                        }
                    },
                    complete: function() {
                        btn.prop('disabled', false).text(originalText);
                    }
                });
            });

            
            // --- SCRIPT 2: ĐỔI MẬT KHẨU ---
            $('#change-password-form').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let btn = $('#btn-change-password');
                let originalText = btn.text();
                btn.prop('disabled', true).text('Đang xử lý...');
                let formData = new FormData(this);

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message, 'Thành công!');
                            form[0].reset();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value[0], 'Lỗi');
                            });
                        } else {
                            toastr.error('Có lỗi xảy ra, vui lòng thử lại.', 'Lỗi hệ thống');
                        }
                    },
                    complete: function() {
                        btn.prop('disabled', false).text(originalText);
                    }
                });
            });

            // --- SCRIPT 3: THÊM ĐỊA CHỈ (Modal) ---
            $('#addAddressForm').on('submit', function(e) {
                e.preventDefault();
                let form = $(this);
                let btn = $('#btn-add-address');
                let originalText = btn.text();
                btn.prop('disabled', true).text('Đang lưu...');
                $('.error-message').remove();
                let formData = new FormData(this);

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message, 'Thành công!');
                            $('#addAddressModal').modal('hide');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                let input = $('#' + key);
                                input.after('<p class="error-message text-danger" style="font-size: 0.9em;">' + value[0] + '</p>');
                            });
                            toastr.error('Vui lòng kiểm tra lại thông tin.', 'Lỗi nhập liệu');
                        } else {
                            toastr.error('Có lỗi xảy ra, vui lòng thử lại.', 'Lỗi hệ thống');
                        }
                    },
                    complete: function() {
                        btn.prop('disabled', false).text(originalText);
                    }
                });
            });


            // --- SCRIPT 4: CHỌN ĐỊA CHỈ MẶC ĐỊNH (MỚI) ---
            $(document).on('submit', '.form-set-default', function(e) {
                e.preventDefault();

                let form = $(this);
                let btn = form.find('button[type="submit"]');
                btn.prop('disabled', true).text('Đang chọn...');

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message, 'Thành công!');
                            setTimeout(() => location.reload(), 1000);
                        }
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr);
                        toastr.error('Có lỗi xảy ra, vui lòng thử lại.', 'Lỗi hệ thống');
                        btn.prop('disabled', false).text('Chọn');
                    }
                });
            });

            // --- SCRIPT 5: XÓA ĐỊA CHỈ (MỚI) ---
            $(document).on('submit', '.form-delete-address', function(e) {
                e.preventDefault();

                if (!confirm('Bạn có chắc muốn xóa địa chỉ này?')) {
                    return false;
                }

                let form = $(this);
                let btn = form.find('button[type="submit"]');
                btn.prop('disabled', true).text('Đang xóa...');

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: form.serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message, 'Thành công!');
                            setTimeout(() => location.reload(), 1000);
                        }
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr);
                        if (xhr.status === 422 && xhr.responseJSON.message) {
                            toastr.error(xhr.responseJSON.message, 'Lỗi');
                        } else {
                            toastr.error('Có lỗi xảy ra, vui lòng thử lại.', 'Lỗi hệ thống');
                        }
                        btn.prop('disabled', false).text('Xóa');
                    }
                });
            });

        });
    </script>
@endpush
