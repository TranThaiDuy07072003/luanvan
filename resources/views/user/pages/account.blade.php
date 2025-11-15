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
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Đơn hàng</th>
                                                                <th>Ngày đặt</th>
                                                                <th>Trạng thái</th>
                                                                <th>Tổng cộng</th>
                                                                <th>Hành động</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>Jun 22, 2019</td>
                                                                <td>Pending</td>
                                                                <td>$3000</td>
                                                                <td><a href="cart.html">View</a></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>

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
                                                            <tr>
                                                                <td>1</td>
                                                                <td>Jun 22, 2019</td>
                                                                <td>Pending</td>
                                                                <td>$3000</td>
                                                                <td>Yes</td>
                                                                <td>
                                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                                        onclick="return confirm('Bạn có chắc muốn xóa địa chỉ này ?')">Xóa</button>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <button class="btn theme-btn-1 btn-effect-1 mt-3">Thêm địa chỉ mới</button>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="liton_tab_account">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <div class="ltn__form-box">
                                                    <form id="update-account-form">

                                                        <div class="row mb-50">
                                                            <div class="col-md-6">
                                                                <label for="ltn__name">Họ và tên:</label>
                                                                <input type="text" name="ltn__name" id="ltn__name"
                                                                    value="{{ $user->name }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="ltn__phone_number">Số điện thoại:</label>
                                                                <input type="number" name="ltn__phone_number"
                                                                    id="ltn__phone_number"
                                                                    value="{{ $user->phone_number ?? '' }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="ltn__email">Email (không được thay đổi)</label>
                                                                <input type="email" name="ltn__email" id="ltn__email"
                                                                    value="{{ $user->email }}" readonly>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="ltn__address">Địa chỉ:</label>
                                                                <input type="text" name="ltn__address" id="ltn__address"
                                                                    value="{{ $user->address ?? '' }}" required>
                                                            </div>
                                                        </div>

                                                        <div class="btn-wrapper">
                                                            <button type="submit" id="btn-update-info"
                                                                class="btn theme-btn-1 btn-effect-1 text-uppercase">Cập
                                                                nhật</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="liton_tab_password">
                                            <div class="ltn__myaccount-tab-content-inner">
                                                <div class="ltn__form-box">
                                                    <form action="#" method="POST" id="change-password-form">
                                                        <fieldset>
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <label>Mật khẩu hiện tại</label>
                                                                    <input type="password" name="current_password" required>
                                                                    <label>Mật khẩu mới:</label>
                                                                    <input type="password" name="new_password" required>
                                                                    <label>Xác nhận mật khẩu mới:</label>
                                                                    <input type="password" name="confirm_new_password"
                                                                        autocomplete="new-password" required>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <div class="btn-wrapper">
                                                            <button type="submit"
                                                                class="btn theme-btn-1 btn-effect-1 text-uppercase">Đổi mật
                                                                khẩu</button>
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

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#update-account-form').on('submit', function(e) {
                e.preventDefault();

                let btn = $('#btn-update-info');
                let originalText = btn.text();

                btn.prop('disabled', true).text('Đang lưu...');

                let formData = new FormData(this);

                // --- THÊM DÒNG NÀY ĐỂ SỬA LỖI ---
                formData.append('_method', 'PUT');
                // --------------------------------

                $.ajax({
                    url: "{{ route('account.update') }}",
                    type: 'POST', // VẪN GIỮ LÀ POST (Laravel sẽ tự hiểu là PUT nhờ dòng trên)
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message, 'Thành công!');
                            $('input[name="ltn__name"]').val(response.user.name);
                            $('input[name="ltn__phone_number"]').val(response.user
                            .phone_number);
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
        });
    </script>
@endpush
