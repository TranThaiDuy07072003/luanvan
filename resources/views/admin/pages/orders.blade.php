@extends('layouts.admin')

@section('title', 'Quản lý Đơn hàng')


@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>DANH SÁCH ĐƠN HÀNG</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Tất Cả Đơn Hàng</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>

                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <div class="filter-box mb-4"
                                style="margin-bottom: 20px; padding: 15px; background: #f7f7f7; border: 1px solid #e6e9ed;">
                                <form action="{{ route('admin.orders.index') }}" method="GET">
                                    <div class="row align-items-end">

                                        {{-- Lọc theo trạng thái đơn hàng --}}
                                        <div class="col-md-4">
                                            <label><strong>Trạng thái đơn hàng:</strong></label>
                                            <select name="status" class="form-control">
                                                <option value="">-- Tất cả --</option>
                                                <option value="pending"
                                                    {{ request('status') == 'pending' ? 'selected' : '' }}>Đang đóng gói
                                                </option>
                                                <option value="processing"
                                                    {{ request('status') == 'processing' ? 'selected' : '' }}>Đang giao hàng
                                                </option>
                                                <option value="completed"
                                                    {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành
                                                </option>
                                                <option value="canceled"
                                                    {{ request('status') == 'canceled' ? 'selected' : '' }}>Đã hủy</option>
                                            </select>
                                        </div>

                                        {{-- Lọc theo trạng thái thanh toán --}}
                                        <div class="col-md-4">
                                            <label><strong>Trạng thái thanh toán:</strong></label>
                                            <select name="payment_status" class="form-control">
                                                <option value="">-- Tất cả --</option>
                                                <option value="paid"
                                                    {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Đã thanh
                                                    toán</option>
                                                <option value="unpaid"
                                                    {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Chưa thanh
                                                    toán</option>
                                            </select>
                                        </div>

                                        {{-- Nút lọc --}}
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary mt-2">
                                                <i class="fa fa-filter"></i> Lọc dữ liệu
                                            </button>
                                            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary mt-2">
                                                <i class="fa fa-refresh"></i> Reset
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>



                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="card-box table-responsive">
                                        <p class="text-muted font-13 m-b-30">
                                            Trang Quản Lý Sản Phẩm Cho Phép Admin tạo, chỉnh sửa hoặc xóa các sản
                                            phẩm theo quy định hoặc yêu cầu từ cty.
                                        </p>
                                        <table id="datatable-buttons" class="table table-striped table-bordered"
                                            style="width:100%; text-align: center;">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Tài khoản</th>
                                                    <th>Thông tin người đặt</th>
                                                    <th>Tổng tiền</th>
                                                    <th>Ngày đặt hàng</th>
                                                    <th>Trạng thái đơn hàng</th>
                                                    <th>Trạng thái thanh toán</th>
                                                    <th>Chi tiết đơn hàng</th>
                                                    <th>Hành động</th>


                                                </tr>
                                            </thead>


                                            <tbody>

                                                @foreach ($orders as $order)
                                                    <tr>

                                                        <td>{{ $order->id }}</td>

                                                        <td>{{ $order->user->name ?? 'Người dùng đã xóa' }}</td>

                                                        <th>
                                                            <a href="javascript:void(0)" data-toggle="modal"
                                                                data-target="#addressShippingModal-{{ $order->id }}">{{ $order->shippingAddress->address }}</a>
                                                        </th>


                                                        <td>{{ number_format($order->total_price, 0, ',', '.') }}VND</td>



                                                        <td>{{ $order->created_at->format('d/m/Y') }}</td>



                                                        <td class="order-status">
                                                            @if ($order->status == 'pending')
                                                                <span class="custom-badge badge badge-warning">Đang đóng
                                                                    gói</span>
                                                            @elseif ($order->status == 'processing')
                                                                <span class="custom-badge badge badge-info">Đang giao
                                                                    hàng</span>
                                                            @elseif ($order->status == 'completed')
                                                                <span class="custom-badge badge badge-success">Hoàn
                                                                    thành</span>
                                                            @elseif ($order->status == 'canceled')
                                                                <span class="custom-badge badge badge-danger">Đã hủy</span>
                                                            @endif
                                                        </td>


                                                        <td>
                                                            {{-- Kiểm tra bảng Payment: Nếu tồn tại và trạng thái khác với pending (tức là paid/completed) --}}
                                                            @if ($order->payment && $order->payment->status != 'pending')
                                                                <span class="custom-badge badge badge-success">Đã thanh
                                                                    toán</span>
                                                            @else
                                                                <span class="custom-badge badge badge-danger">Chưa thanh
                                                                    toán</span>
                                                            @endif
                                                        </td>


                                                        <td>
                                                            <button type="button" class="btn btn-info" data-toggle="modal"
                                                                data-target="#orderItemsModal-{{ $order->id }}">Xem</button>
                                                        </td>


                                                        <td>
                                                            <!-- Hành động -->
                                                            <div class="btn-group">

                                                                <button type="button"
                                                                    class="btn btn-danger dropdown-toggle dropdown-toggle-split"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">

                                                                </button>
                                                                <div class="dropdown-menu">
                                                                    @if ($order->status == 'pending')
                                                                        <a class="dropdown-item confirm-order"
                                                                            href="javascript:void(0)"
                                                                            data-id="{{ $order->id }}">Giao hàng</a>
                                                                    @endif

                                                                    <a class="dropdown-item" target="_blank"
                                                                        href="{{ route('admin.order-detail', ['id' => $order->id]) }}">Xem
                                                                        chi tiết</a>

                                                                </div>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>

                                        @foreach ($orders as $order)
                                            {{-- Modal địa chỉ --}}
                                            <div class="modal fade" id="addressShippingModal-{{ $order->id }}"
                                                tabindex="-1" role="dialog" aria-labelledby="addressShippingModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="addressShippingModalLabel">Thông tin
                                                                giao hàng</h5>
                                                            <button type="button" class="btn-close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true"> &times; </span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <p>Người nhận: {{ $order->shippingAddress->full_name }}</p>
                                                            <p>Địa chỉ: {{ $order->shippingAddress->address }}</p>
                                                            <p>Thành phố: {{ $order->shippingAddress->city }}</p>
                                                            <p>Điện thoại: {{ $order->shippingAddress->phone }}</p>

                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Modal chi tiết cái đơn hàng --}}
                                            <div class="modal fade" id="orderItemsModal-{{ $order->id }}" tabindex="-1"
                                                role="dialog" aria-labelledby="orderItemsModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="orderItemsModalLabel">Chi tiết
                                                                đơn mua</h5>
                                                            <button type="button" class="btn-close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true"> &times; </span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Tên sản phẩm</th>
                                                                        <th>Số lượng</th>
                                                                        <th>Đơn giá</th>
                                                                        <th>Thành tiền</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $index = 1;
                                                                    @endphp

                                                                    @foreach ($order->orderItems as $item)
                                                                        <tr>
                                                                            <td>{{ $index++ }}</td>
                                                                            <td>{{ $item->product->name }}</td>
                                                                            <td>{{ $item->quantity }}</td>
                                                                            <td>{{ number_format($item->price, 0, ',', '.') }}
                                                                                VND</td>
                                                                            <td>{{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                                                                VND</td>
                                                                        </tr>
                                                                    @endforeach

                                                                </tbody>
                                                            </table>

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

                </div>
            </div>
            <!-- /page content -->


        @endsection
