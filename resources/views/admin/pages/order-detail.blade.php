@extends('layouts.admin')

@section('title', 'Chi tiết Đơn hàng')


@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Hóa đơn</small></h3>
                </div>


            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Hóa đơn</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>

                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <section class="content invoice">
                                <!-- title row -->
                                <div class="row">
                                    <div class="  invoice-header">
                                        <h1>
                                            <i class="fa fa-globe"></i> Hóa đơn.
                                            <small class="pull-right">Ngày tạo: {{ $order->created_at }}</small>
                                        </h1>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- info row -->
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                        Từ
                                        <address>
                                            <strong>* {{ $order->shippingAddress->full_name }}</strong>
                                            <br>- {{ $order->shippingAddress->address }}
                                            <br>- {{ $order->shippingAddress->city }}
                                            <br>- Số điện thoại: {{ $order->shippingAddress->phone }}
                                            <br>
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        Đến
                                        <address>
                                            <strong>* NongSanSach.vn</strong>
                                            <br>- 180 Cao Lỗ, phường 4 quận 8
                                            <br>- Thành phố: Hồ Chí Minh
                                            <br>- Số điện thoại: 0999-868-686
                                            <br>- Email: dh52113526@student.stu.edu.vn
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                        <b>Mã hóa đơn: #{{ $order->id }}</b>
                                        <br>

                                        <b>Email: {{ $order->user->email }}
                                            <br>

                                            <b>Tên tài khoản:</b> {{ $order->user->name }}
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- Table row -->
                                <div class="row">
                                    <div class="  table">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Ảnh</th>
                                                    <th>Sản phẩm</th>
                                                    <th>Giá</th>
                                                    <th>Số lượng</th>
                                                    <th>Thành tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($order->orderItems as $item)
                                                    <tr>
                                                        <td>
                                                            <img src="{{ $item->product->image_url }}" width="50px"
                                                                alt="{{ $item->product->name }}">
                                                        </td>

                                                        <td>{{ $item->product->name }}</td>

                                                        <td>{{ number_format($item->price, 0, ',', '.') }}VND</td>

                                                        <td> {{ $item->quantity }}</td>

                                                        <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}VND
                                                        </td>

                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                    <!-- accepted payments column -->
                                    <div class="col-md-6">
                                        <p class="lead">Phương thức thanh toán:</p>


                                        @if ($order->payment->payment_method == 'VNPay')
                                            <img src="{{ asset('assets/admin/images/paypal.png') }}" alt="Paypal">
                                        @else
                                            <img src="{{ asset('assets/admin/images/cash1.png') }}" width="80px"
                                                height="50px" alt="Thanh toán khi nhận hàng">
                                        @endif


                                        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                            Đây là phương thức thanh toán mà khách hàng đã chọn cho đơn hàng này. Nếu là
                                            VNPay, thanh toán đã được xử lý trực tuyến. Nếu là thanh toán khi nhận hàng,
                                            khách hàng sẽ thanh toán trực tiếp khi nhận sản phẩm.
                                        </p>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-md-6">

                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th style="width:50%">Tiền hàng:</th>
                                                        <td>{{ number_format($order->total_price - 15000, 0, ',', '.') }}VND</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Tiền vận chuyển</th>
                                                        <td>{{ number_format(15000, 0, ',', '.') }}VND</td>
                                                    </tr>

                                                    <tr>
                                                        <th>Tổng cộng: </th>
                                                        <td>{{ number_format($order->total_price, 0, ',', '.') }}VND</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- this row will not appear when printing -->
                                <div class="row no-print">
                                    <div>
                                        @if ($order->status != 'canceled')
                                            <button class="btn btn-default" onclick="window.print();"><i
                                                    class="fa fa-print"></i> In hóa đơn</button>

                                            <button class="btn btn-success pull-right send-invoice-mail" data-id="{{ $order->id }}"><i class="fa fa-send"></i> Gửi
                                                hóa đơn</button>


                                            @if ($order->status == 'pending')
                                                <button class="btn btn-danger pull-right cancel-order" style="margin-right: 5px;"
                                                    data-id="{{ $order->id }}">
                                                    <i class="fa fa-remove"></i> Hủy đơn hàng
                                                </button>
                                            @endif


                                        @else
                                            <button class="btn btn-danger" style="cursor: not-allowed"><i
                                                    class="fa fa-info"></i> Đơn hàng đã hủy</button>

                                        @endif




                                    </div>
                                </div>

                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection
