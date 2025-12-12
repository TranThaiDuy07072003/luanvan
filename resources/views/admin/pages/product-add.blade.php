@extends('layouts.admin')

@section('title', 'Thêm Sản Phẩm')

@section('content')

    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>THÊM SẢN PHẨM</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Thêm Sản Phẩm Mới</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            <form action="{{ route('admin.product.add') }}" id="add-product" method="POST"
                                class="form-horizontal form-label-left" enctype="multipart/form-data">
                                @csrf

                                {{-- TÊN SẢN PHẨM --}}
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="product-name">
                                        Tên Sản Phẩm <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="product-name" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name') }}"> {{-- Hiển thị lỗi --}}
                                        @error('name')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- DANH MỤC --}}
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="category_id">
                                        Chọn Danh Mục <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <select id="product-category" name="category_id"
                                            class="form-control @error('category_id') is-invalid @enderror">
                                            <option value="">-- Chọn Danh Mục --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('category_id')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- MÔ TẢ --}}
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="product-description">
                                        Mô Tả <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="product-description" name="description"
                                            class="form-control @error('description') is-invalid @enderror"
                                            value="{{ old('description') }}">

                                        @error('description')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- GIÁ TIỀN --}}
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="product-price">
                                        Giá tiền <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="number" id="product-price" name="price"
                                            class="form-control @error('price') is-invalid @enderror"
                                            value="{{ old('price') }}">

                                        @error('price')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- SỐ LƯỢNG --}}
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="product-stock">
                                        Số lượng <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="number" id="product-stock" name="stock"
                                            class="form-control @error('stock') is-invalid @enderror"
                                            value="{{ old('stock') }}">

                                        @error('stock')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- ĐƠN VỊ (Dùng Select Box cho chuẩn) --}}
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="product-unit">
                                        Đơn vị tính <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <select id="product-unit" name="unit"
                                            class="form-control @error('unit') is-invalid @enderror">
                                            <option value="">-- Chọn Đơn Vị --</option>
                                            <option value="kg" {{ old('unit') == 'kg' ? 'selected' : '' }}>Kg (Kilogram)</option>
                                            <option value="g" {{ old('unit') == 'g' ? 'selected' : '' }}>Gram (g)</option>
                                            <option value="bo" {{ old('unit') == 'bo' ? 'selected' : '' }}>Bó</option>
                                            <option value="trai" {{ old('unit') == 'trai' ? 'selected' : '' }}>Trái / Quả</option>
                                            <option value="cu" {{ old('unit') == 'cu' ? 'selected' : '' }}>Củ</option>
                                            <option value="hop" {{ old('unit') == 'hop' ? 'selected' : '' }}>Hộp</option>
                                            <option value="tui" {{ old('unit') == 'tui' ? 'selected' : '' }}>Túi</option>
                                            <option value="vi" {{ old('unit') == 'vi' ? 'selected' : '' }}>Vỉ</option>
                                            <option value="combo" {{ old('unit') == 'combo' ? 'selected' : '' }}>Combo</option>
                                        </select>

                                        @error('unit')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- HÌNH ẢNH --}}
                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="product-images">
                                        Hình ảnh <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <label class="custom-file-upload" for="product-images"> Chọn ảnh </label>
                                        <input type="file" name="images[]" id="product-images" accept="image/*" multiple>

                                        <div id="image-preview-container"></div>

                                        {{-- Lỗi ảnh --}}
                                        @if($errors->has('images'))
                                            <div class="text-danger small mt-1">{{ $errors->first('images') }}</div>
                                        @endif
                                        {{-- Lỗi từng ảnh cụ thể (nếu có) --}}
                                        @error('images.*')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="ln_solid"></div>
                                <div class="item form-group">
                                    <div class="col-md-6 col-sm-6 offset-md-3">
                                        <button class="btn btn-primary btn_reset" type="reset">Reset</button>
                                        <button type="submit" class="btn btn-success">Thêm Sản Phẩm</button>
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
