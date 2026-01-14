@extends('layouts.client')

@section('title', 'Công thức món canh')
@section('breadcrumb', 'Công thức món canh')

@section('content')

    <div class="ltn__product-area ltn__product-gutter mb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area ltn__section-title-2 text-center">
                        <h1 class="section-title">Hôm Nay Ăn Gì?</h1>
                    </div>

                    <div class="row">
                        @foreach ($recipes as $recipe)
                            <div class="col-xl-3 col-lg-4 col-sm-6 col-6">
                                <div class="ltn__product-item ltn__product-item-3 text-center">
                                    <div class="product-img">
                                        <a href="javascript:void(0)">
                                            <img src="{{ asset('storage/' . $recipe->image) }}" alt="{{ $recipe->name }}"
                                                style="height: 250px; object-fit: cover;">
                                        </a>
                                        <div class="product-hover-action">
                                            <ul>
                                                <li>
                                                    <a href="#" title="Xem nguyên liệu" class="btn-show-recipe"
                                                        data-id="{{ $recipe->id }}">
                                                        <i class="far fa-eye"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h3 class="product-title"><a href="javascript:void(0)">{{ $recipe->name }}</a></h3>
                                        <div class="product-price">
                                            {{-- <span>Gợi ý món ngon</span> --}}
                                        </div>

                                        <div class="mt-3">
                                            <button class="theme-btn-1 btn btn-show-recipe" style="padding: 10px 20px;"
                                                data-id="{{ $recipe->id }}">
                                                MUA NGUYÊN LIỆU
                                            </button>
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

    {{-- MODAL POPUP (Chuẩn Bootstrap 5 giống Quick View) --}}
    {{-- MODAL RECIPE --}}
    <div class="modal fade" id="modalRecipe" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title font-weight-bold" id="recipe-title">Nguyên liệu</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"
                        style="font-size: 25px;">&times;</button>
                </div>
                <div class="modal-body pt-2">
                    <p class="text-muted mb-3">Lựa chọn các nguyên liệu chính:</p>
                    <div id="ingredient-list">
                        {{-- AJAX sẽ đổ HTML vào đây --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
