@extends('layouts.admin')

@section('title', 'Quản lý danh mục')


@section('content')

    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>TẠO DANH MỤC</h3>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 ">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Thêm Danh Mục Mới</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>

                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />
                            <form action="{{ route("admin.categories.add") }}" id="add-category" method="POST" class="form-horizontal form-label-left"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="category-name">Tên Danh
                                        Mục
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        {{-- Thêm value="{{ old('name') }}" để giữ lại nội dung đã nhập khi bị lỗi --}}
                                        <input type="text" id="category-name" name="name"
                                            value="{{ old('name') }}"
                                            class="form-control @error('name') is-invalid @enderror">

                                        {{-- Thêm đoạn này để hiện lỗi --}}
                                        @error('name')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align"
                                        for="category-description">Mô Tả
                                        <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <input type="text" id="category-description" name="description"
                                             class="form-control">
                                    </div>
                                </div>

                                <div class="item form-group">

                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="category-image">Hình
                                        ảnh</label>
                                    <div class="col-md-6 col-sm-6 ">
                                        <label class="custom-file-upload" for="category-image"> Chọn ảnh </label>
                                        <input type="file" name="image" id="category-image" accept="image/*">

                                        {{-- Thêm đoạn này để hiện lỗi ảnh --}}
                                        @error('image')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror

                                        <img src="" alt="Ảnh xem trước" id="image-preview" class="image-preview">
                                    </div>
                                </div>


                                <div class="ln_solid"></div>
                                <div class="item form-group">
                                    <div class="col-md-6 col-sm-6 offset-md-3">

                                        <button class="btn btn-primary btn_reset" type="reset">Reset</button>
                                        <button type="submit" class="btn btn-success">Thêm Danh Mục</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /page content -->


@endsection
