@extends('layouts.admin')

@section('title', 'Quản lý Sản Phẩm')


@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>DANH SÁCH SẢN PHẨM</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Tất Cả SẢN PHẨM</h2>
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
                                <form action="{{ route('admin.products.index') }}" method="GET">
                                    <div class="row align-items-end">
                                        <div class="col-md-4">
                                            <label><strong>Lọc theo Danh mục:</strong></label>
                                            <select name="category_id" class="form-control">
                                                <option value="">-- Tất cả danh mục --</option>
                                                @foreach ($categories as $cate)
                                                    <option value="{{ $cate->id }}"
                                                        {{ request('category_id') == $cate->id ? 'selected' : '' }}>
                                                        {{ $cate->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        {{-- Bạn có thể thêm lọc theo Trạng thái ở đây nếu muốn --}}
                                        <div class="col-md-4">
                                            <label><strong>Lọc theo Trạng thái:</strong></label>
                                            <select name="status" class="form-control">
                                                <option value="">-- Tất cả --</option>
                                                <option value="in_stock"
                                                    {{ request('status') == 'in_stock' ? 'selected' : '' }}>Còn hàng
                                                </option>
                                                <option value="out_of_stock"
                                                    {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>Hết hàng
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-primary" style="margin-top: 5px;">
                                                <i class="fa fa-filter"></i> Lọc dữ liệu
                                            </button>
                                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary"
                                                style="margin-top: 5px;">
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
                                            style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Hình Ảnh</th>
                                                    <th>Tên Sản Phẩm</th>
                                                    <th>Danh Mục</th>
                                                    <th>Slug</th>
                                                    <th>Mô tả</th>
                                                    <th>Số lượng</th>
                                                    <th>Giá</th>
                                                    <th>Đơn vị</th>
                                                    <th>Trạng thái</th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>


                                            <tbody>

                                                @foreach ($products as $product)
                                                    <tr id="product-row-{{ $product->id }}">
                                                        <td>
                                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
                                                                class="image-product">
                                                        </td>

                                                        <td>{{ $product->name }}</td>
                                                        <td>{{ $product->category->name ?? 'Danh mục đã bị xóa' }}</td>
                                                        <td>{{ $product->slug }}</td>
                                                        <td>{{ $product->description }}</td>
                                                        <td>{{ $product->stock }}</td>
                                                        <td>{{ number_format($product->price, 0, ',', '.') }}VND</td>
                                                        <td>{{ $product->unit }}</td>
                                                        <td>{{ $product->status == 'in_stock' ? 'Còn hàng' : 'Hết hàng' }}
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-app btn-update-product" data-toggle="modal"
                                                                data-target="#modalUpdate-{{ $product->id }}">
                                                                <i class="fa fa-edit"></i>Chỉnh sửa
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-app btn-delete-product"
                                                                data-id="{{ $product->id }}"
                                                                data-status="{{ $product->status }}">

                                                                <i class="fa fa-close"></i>Xóa
                                                            </a>
                                                        </td>
                                                    </tr>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="modalUpdate-{{ $product->id }}"
                                                        tabindex="-1" aria-labelledby="productModalLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="productModalLabel">Chỉnh
                                                                        sửa</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true"> &times; </span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <form id="update-product" method="POST"
                                                                        class="form-horizontal form-label-left"
                                                                        enctype="multipart/form-data">
                                                                        @csrf

                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="product-name">Tên Sản Phẩm
                                                                                <span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="text" id="product-name"
                                                                                    name="name" required
                                                                                    class="form-control"
                                                                                    value="{{ $product->name }}">
                                                                            </div>
                                                                        </div>



                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="product-name">Danh Mục
                                                                                <span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">

                                                                                <select name="category_id" id="category_id"
                                                                                    class="form-control">
                                                                                    <option value="">Chọn Danh Mục
                                                                                    </option>

                                                                                    @foreach ($categories as $category)
                                                                                        <option
                                                                                            value="{{ $category->id }}"
                                                                                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                                                            {{ $category->name }}
                                                                                        </option>
                                                                                    @endforeach

                                                                                </select>



                                                                            </div>
                                                                        </div>



                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="product-description">Mô Tả
                                                                                <span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="text"
                                                                                    id="product-description"
                                                                                    name="description" required="required"
                                                                                    class="form-control"
                                                                                    value="{{ $product->description }}">
                                                                            </div>
                                                                        </div>


                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="product-description">Giá
                                                                                <span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="number" id="product-price"
                                                                                    name="price" required="required"
                                                                                    class="form-control"
                                                                                    value="{{ $product->price }}">
                                                                            </div>
                                                                        </div>



                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="product-description">Số Lượng
                                                                                <span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="number" id="product-stock"
                                                                                    name="stock" required="required"
                                                                                    class="form-control"
                                                                                    value="{{ $product->stock }}">
                                                                            </div>
                                                                        </div>



                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="product-description">Đơn Vị
                                                                                <span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6 ">
                                                                                <input type="text" id="product-unit"
                                                                                    name="unit" required="required"
                                                                                    class="form-control"
                                                                                    value="{{ $product->unit }}">
                                                                            </div>
                                                                        </div>


                                                                        {{-- THÊM Ô NÀY ĐỂ ADMIN CHỦ ĐỘNG CHỌN --}}
                                                                        <div class="item form-group">
                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="product-status">
                                                                                Trạng thái <span class="required">*</span>
                                                                            </label>
                                                                            <div class="col-md-6 col-sm-6">
                                                                                <select name="status"
                                                                                    class="form-control">
                                                                                    <option value="in_stock"
                                                                                        {{ $product->status == 'in_stock' ? 'selected' : '' }}>
                                                                                        Còn hàng (Đang bán)
                                                                                    </option>
                                                                                    <option value="out_of_stock"
                                                                                        {{ $product->status == 'out_of_stock' ? 'selected' : '' }}>
                                                                                        Hết hàng (Tạm ngưng)
                                                                                    </option>
                                                                                </select>
                                                                            </div>
                                                                        </div>



                                                                        <div class="item form-group">

                                                                            <label
                                                                                class="col-form-label col-md-3 col-sm-3 label-align"
                                                                                for="product-images">Hình
                                                                                ảnh</label>
                                                                            <div class="col-md-6 col-sm-6 ">

                                                                                <label class="custom-file-upload"
                                                                                    for="product-images-{{ $product->id }}">
                                                                                    Chọn ảnh </label>
                                                                                <input type="file" name="images[]"
                                                                                    class="product-images"
                                                                                    id="product-images-{{ $product->id }}"
                                                                                    data-id="{{ $product->id }}"
                                                                                    accept="image/*" multiple required>
                                                                                <div id="image-preview-container-{{ $product->id }}"
                                                                                    class="image-preview-container image-preview-listproduct"
                                                                                    data-id="{{ $product->id }}">
                                                                                    @foreach ($product->images as $image)
                                                                                        <img src="{{ asset('storage/' . $image->image) }}"
                                                                                            alt="Ảnh sản phẩm"
                                                                                            style="width: 100px; height: 100px; object-fit: cover; margin: 5px;">
                                                                                    @endforeach

                                                                                </div>

                                                                            </div>
                                                                        </div>



                                                                    </form>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary"
                                                                        data-dismiss="modal">Quay lại</button>
                                                                    <button type="button"
                                                                        class="btn btn-primary btn-update-submit-product"
                                                                        data-id="{{ $product->id }}">Chỉnh sửa</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
            <!-- /page content -->


        @endsection
