@extends('layouts.admin')

@section('title', 'Quản lý người dùng')

@section('content')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>DANH SÁCH NGƯỜI DÙNG</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Tất Cả Thành Viên</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>

                        <div class="x_content">

                            {{-- 1. KHUNG LỌC (FILTER) - GIỐNG PRODUCTS --}}
                            <div class="filter-box mb-4" style="margin-bottom: 20px; padding: 15px; background: #f7f7f7; border: 1px solid #e6e9ed;">
                                <form action="{{ route('admin.users.index') }}" method="GET">
                                    <div class="row align-items-end">

                                        {{-- Lọc theo Vai Trò --}}
                                        <div class="col-md-4">
                                            <label><strong>Lọc theo Vai trò:</strong></label>
                                            <select name="role_name" class="form-control" style="width: 300px">
                                                <option value="">-- Tất cả vai trò --</option>
                                                <option value="customer" {{ request('role_name') == 'customer' ? 'selected' : '' }}>Khách hàng</option>
                                                <option value="staff" {{ request('role_name') == 'staff' ? 'selected' : '' }}>Nhân viên</option>
                                                <option value="admin" {{ request('role_name') == 'admin' ? 'selected' : '' }}>Quản trị viên</option>
                                            </select>
                                        </div>

                                        {{-- Lọc theo Trạng Thái --}}
                                        <div class="col-md-4" style="margin-left: -36px">
                                            <label><strong>Lọc theo Trạng thái:</strong></label>
                                            <select name="status" class="form-control" style="width: 300px">
                                                <option value="">-- Tất cả --</option>
                                                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Hoạt động</option>
                                                <option value="banned" {{ request('status') == 'banned' ? 'selected' : '' }}>Đã chặn</option>
                                                <option value="delete" {{ request('status') == 'delete' ? 'selected' : '' }}>Đã xóa</option>
                                            </select>
                                        </div>

                                        {{-- Nút Lọc & Reset --}}
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary" style="margin-top: 5px; margin-left: -14px;">
                                                <i class="fa fa-filter"></i> Lọc dữ liệu
                                            </button>
                                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary" style="margin-top: 5px;">
                                                <i class="fa fa-refresh"></i> Reset
                                            </a>

                                            {{-- Nút Thêm Nhân Viên đưa vào đây luôn cho gọn --}}
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addStaffModal" style="margin-top: 5px; float: right;">
                                                <i class="fa fa-plus"></i> Thêm Nhân Viên
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- 2. BẢNG DỮ LIỆU (TABLE) --}}
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-box table-responsive">
                                        <p class="text-muted font-13 m-b-30">
                                            Danh sách bao gồm Khách hàng, Nhân viên và Quản trị viên. Sử dụng ô Tìm kiếm bên phải để lọc nhanh.
                                        </p>

                                        {{-- ID="datatable-buttons" LÀ CHÌA KHÓA ĐỂ CÓ THANH TÌM KIẾM TỰ ĐỘNG --}}
                                        <table id="datatable-buttons" class="table table-striped table-bordered" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th class="text-center">Avatar</th>
                                                    <th>Thông tin</th>
                                                    <th>Liên hệ</th>
                                                    <th class="text-center">Vai trò</th>
                                                    <th class="text-center">Trạng thái</th>
                                                    <th class="text-center">Hành động</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach ($users as $user)
                                                    <tr>
                                                        <td class="text-center align-middle">{{ $user->id }}</td>

                                                        <td class="text-center align-middle">
                                                            <img src="{{ asset('storage/' . ($user->avatar ?? 'uploads/users/default-avatar.png')) }}"
                                                                 alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                                        </td>

                                                        <td class="align-middle">
                                                            <strong>{{ $user->name }}</strong><br>
                                                            <small>{{ $user->email }}</small>
                                                        </td>

                                                        <td class="align-middle">
                                                            <i class="fa fa-phone"></i> {{ $user->phone_number }}<br>
                                                            <i class="fa fa-map-marker"></i> {{ Str::limit($user->address, 20) }}
                                                        </td>

                                                        <td class="text-center align-middle">
                                                            @if($user->role->name == 'admin')
                                                                <span class="badge badge-danger">ADMIN</span>
                                                            @elseif($user->role->name == 'staff')
                                                                <span class="badge badge-primary">NHÂN VIÊN</span>
                                                            @else
                                                                <span class="badge badge-secondary">KHÁCH HÀNG</span>
                                                            @endif
                                                        </td>

                                                        <td class="text-center align-middle">
                                                            @if($user->status == 'active')
                                                                <span class="text-success"><i class="fa fa-check-circle"></i> Hoạt động</span>
                                                            @elseif($user->status == 'banned')
                                                                <span class="text-warning"><i class="fa fa-ban"></i> Đã chặn</span>
                                                            @elseif($user->status == 'delete')
                                                                <span class="text-danger"><i class="fa fa-trash"></i> Đã xóa</span>
                                                            @endif
                                                        </td>

                                                        <td class="text-center align-middle">
                                                            {{-- Nút Thăng chức
                                                            @if ($user->role->name == 'customer')
                                                                <button type="button" class="btn btn-info btn-sm upgradeStaff"
                                                                    data-userid="{{ $user->id }}" title="Thăng làm nhân viên">
                                                                    <i class="fa fa-level-up"></i>
                                                                </button>
                                                            @endif --}}

                                                            {{-- Các nút xử lý (Trừ chính mình) --}}
                                                            @if (($user->role->name == 'customer' || $user->role->name == 'staff') && $user->id != Auth::id())

                                                                @if ($user->status == 'banned')
                                                                    <button type="button" class="btn btn-success btn-sm changeStatus"
                                                                        data-userid="{{ $user->id }}" data-status="active" title="Bỏ chặn">
                                                                        <i class="fa fa-unlock"></i>
                                                                    </button>
                                                                @else
                                                                    <button type="button" class="btn btn-warning btn-sm changeStatus"
                                                                        data-userid="{{ $user->id }}" data-status="banned" title="Chặn">
                                                                        <i class="fa fa-ban"></i>
                                                                    </button>
                                                                @endif

                                                                @if ($user->status == 'delete')
                                                                    <button type="button" class="btn btn-success btn-sm changeStatus"
                                                                        data-userid="{{ $user->id }}" data-status="active" title="Khôi phục">
                                                                        <i class="fa fa-recycle"></i>
                                                                    </button>
                                                                @else
                                                                    <button type="button" class="btn btn-danger btn-sm changeStatus"
                                                                        data-userid="{{ $user->id }}" data-status="delete" title="Xóa">
                                                                        <i class="fa fa-close"></i>
                                                                    </button>
                                                                @endif
                                                            @endif
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
            </div>
        </div>
    </div>
    {{-- MODAL THÊM NHÂN VIÊN --}}
    <div class="modal fade" id="addStaffModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Thêm Nhân Viên Mới</h4>
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span></button>
                </div>
                <form id="addStaffForm" action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label>Họ và tên <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" placeholder="Nhập họ tên...">
                                {{-- Chỗ này để hứng lỗi --}}
                                <span class="text-danger error-text name_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label>Số điện thoại <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="phone_number" placeholder="09...">
                                <span class="text-danger error-text phone_number_error"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" placeholder="abc@gmail.com">
                                <span class="text-danger error-text email_error"></span>
                            </div>
                            <div class="col-md-6">
                                <label>Mật khẩu <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" name="password" placeholder="******">
                                <span class="text-danger error-text password_error"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ</label>
                            <input type="text" class="form-control" name="address" placeholder="Nhập địa chỉ...">
                            <span class="text-danger error-text address_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" id="btnSaveStaff">Lưu lại</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
