@extends('layouts.admin')

@section('title', 'Quản lý người dùng')


@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Quản lý người dùng</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="x_panel">
                <div class="x_content">

                    <div class="row">
                        @foreach ($users as $user)
                            <div class="col-md-4 col-sm-4  profile_details">
                                <div class="well profile_view">
                                    <div class="col-sm-12">
                                        <h4 class="brief text-uppercase"><i>{{ $user->role->name }}</i></h4>
                                        <div class="left col-md-7 col-sm-7">
                                            <h2>{{ $user->name }}</h2>
                                            <p><strong>Email: </strong> {{ $user->email }}
                                            </p>
                                            <ul class="list-unstyled">
                                                <li><i class="fa fa-building"></i> Địa chỉ: {{ $user->address }}</li>
                                                <li><i class="fa fa-phone"></i> Số điện thoại: {{ $user->phone_number }}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="right col-md-5 col-sm-5 text-center">
                                            <img src="{{ asset('storage/' . ($user->avatar ?? 'uploads/users/default-avatar.png')) }}"
                                                alt="" class="img-circle img-fluid">
                                        </div>
                                    </div>
                                    <div class=" profile-bottom text-center">

                                        <div class="col-sm-12 emphasis">

                                            {{-- 1. Nút Phong làm nhân viên (Chỉ hiện khi là Customer) --}}
                                            @if ($user->role->name == 'customer')
                                                <button type="button" class="btn btn-primary btn-sm upgradeStaff"
                                                    data-userid="{{ $user->id }}">
                                                    <i class="fa fa-user"> </i> Nhân Viên
                                                </button>
                                            @endif

                                            {{-- 2. Nút Chặn & Xóa (Hiện cho cả Customer và Staff, TRỪ chính mình ra) --}}
                                            @if (($user->role->name == 'customer' || $user->role->name == 'staff') && $user->id != Auth::id())
                                                {{-- Nút Chặn / Bỏ chặn --}}
                                                @if ($user->status == 'banned')
                                                    <button type="button" class="btn btn-success btn-sm changeStatus"
                                                        data-userid="{{ $user->id }}" data-status="active">
                                                        <i class="fa fa-unlock"> </i> Bỏ chặn
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-warning btn-sm changeStatus"
                                                        data-userid="{{ $user->id }}" data-status="banned">
                                                        <i class="fa fa-ban"> </i> Chặn
                                                    </button>
                                                @endif

                                                {{-- Nút Xóa / Khôi phục --}}
                                                @if ($user->status == 'delete')
                                                    <button type="button" class="btn btn-success btn-sm changeStatus"
                                                        data-userid="{{ $user->id }}" data-status="active">
                                                        <i class="fa fa-recycle"> </i> Khôi phục
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-danger btn-sm changeStatus"
                                                        data-userid="{{ $user->id }}" data-status="delete">
                                                        <i class="fa fa-trash"> </i> Xóa
                                                    </button>
                                                @endif
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

        </div>
    </div>
    <!-- /page content -->


@endsection
