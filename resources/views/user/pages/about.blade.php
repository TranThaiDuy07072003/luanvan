@extends('layouts.client')

@section('title', 'Về chúng tôi')
@section('breadcrumb', 'Về Chúng Tôi')

@section('content')

    <!-- Về chúng tôi AREA START -->
    <div class="ltn__about-us-area pt-120--- pb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 align-self-center">
                    <div class="about-us-img-wrap about-img-left">
                        <img src="{{ asset('assets/user/img/others/9.png') }}" alt="Về chúng tôi Image">
                    </div>
                </div>
                <div class="col-lg-6 align-self-center">
                    <div class="about-us-info-wrap">
                        <div class="section-title-area ltn__section-title-2">
                            <h6 class="section-subtitle ltn__secondary-color">Tìm Hiểu Thêm Về Cửa Hàng</h6>
                            <h1 class="section-title">Thực Phẩm <br class="d-none d-md-block"> Hữu Cơ Uy Tín</h1>
                            <p>Chúng tôi cam kết mang đến những sản phẩm chất lượng, an toàn và tốt cho sức khỏe</p>
                        </div>
                        <p>Chúng tôi xây dựng một cộng đồng thân thiện, bền vững và đáng tin cậy <br> nơi mọi sản phẩm đều được chọn lựa kỹ lưỡng, tôn trọng thiên nhiên và <br>sức khỏe con người.</p>
                        <div class="about-author-info d-flex">
                            <div class="author-name-designation  align-self-center">
                                <h4 class="mb-0">VNMN</h4>
                                <small>/ Giám Đốc Cửa Hàng</small>
                            </div>
                            <div class="author-sign">
                                <img src="{{ asset('assets/user/img/icons/icon-img/author-sign1.png') }}" alt="#">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Về chúng tôi AREA END -->

    <!-- FEATURE AREA START ( Feature - 6) -->
    <div class="ltn__feature-area section-bg-1 pt-115 pb-90">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area ltn__section-title-2 text-center">
                        <h6 class="section-subtitle ltn__secondary-color">// Đặc Điểm //</h6>
                        <h1 class="section-title">Vì Sao Nên Chọn Chúng Tôi<span>.</span></h1>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="ltn__feature-item ltn__feature-item-7">
                        <div class="ltn__feature-icon-title">
                            <div class="ltn__feature-icon">
                                <span><img src="{{ asset('assets/user/img/icons/icon-img/21.png') }}" alt="#"></span>
                            </div>
                            <h3><a href="service-details.html">Đa Dạng Các Thương Hiệu</a></h3>
                        </div>
                        <div class="ltn__feature-info">
                            <p>Chúng tôi cung cấp nhiều thương hiệu uy tín, đảm bảo chất lượng và nguồn gốc rõ ràng.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="ltn__feature-item ltn__feature-item-7">
                        <div class="ltn__feature-icon-title">
                            <div class="ltn__feature-icon">
                                <span><img src="{{ asset('assets/user/img/icons/icon-img/22.png') }}" alt="#"></span>
                            </div>
                            <h3><a href="service-details.html">Sản Phẩm Được Tuyển Chọn</a></h3>
                        </div>
                        <div class="ltn__feature-info">
                            <p>Chúng tôi cung cấp các sản phẩm được chọn lọc kỹ lưỡng, đảm bảo chất lượng và an toàn cho sức khỏe.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6 col-12">
                    <div class="ltn__feature-item ltn__feature-item-7">
                        <div class="ltn__feature-icon-title">
                            <div class="ltn__feature-icon">
                                <span><img src="{{ asset('assets/user/img/icons/icon-img/23.png') }}" alt="#"></span>
                            </div>
                            <h3><a href="service-details.html">Sản Phẩm Không Chất Độc Hại</a></h3>
                        </div>
                        <div class="ltn__feature-info">
                            <p>Chúng tôi cung cấp các sản phẩm không chứa chất độc hại, đảm bảo an toàn cho sức khỏe người tiêu dùng.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FEATURE AREA END -->



@endsection
