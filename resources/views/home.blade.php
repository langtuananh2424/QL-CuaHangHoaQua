@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<div class="container-fluid">
    <!-- Banner/Slider -->
    <div class="row">
        <div class="col-12 p-0">
            <div class="banner">
                <img src="{{ asset('images/Banner/Banner.png') }}" class="banner" alt="Banner hoa quả">
            </div>
        </div>
    </div>
    <!-- Main content -->
    <div class="row mt-3">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="sidebar">
                <h5>SẢN PHẨM NỔI BẬT</h5>
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Cà chua</span>
                        <span class="badge badge-success">150.000 ₫</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Đu đủ</span>
                        <span class="badge badge-success">100.000 ₫</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Kiwi</span>
                        <span class="badge badge-danger"><del>130.000 ₫</del> 100.000 ₫</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Khoai tây</span>
                        <span class="badge badge-danger"><del>50.000 ₫</del> 43.000 ₫</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Cam</span>
                        <span class="badge badge-danger"><del>96.000 ₫</del> 85.000 ₫</span>
                    </li>
                </ul>
                <h5>KHUYẾN MÃI</h5>
                <ul class="list-group">
                    <li class="list-group-item">Kiwi <span class="badge badge-danger float-right"><del>130.000 ₫</del> 100.000 ₫</span></li>
                    <li class="list-group-item">Khoai tây <span class="badge badge-danger float-right"><del>50.000 ₫</del> 43.000 ₫</span></li>
                    <li class="list-group-item">Cam <span class="badge badge-danger float-right"><del>96.000 ₫</del> 85.000 ₫</span></li>
                    <li class="list-group-item">Ớt ngọt <span class="badge badge-danger float-right"><del>30.000 ₫</del> 26.000 ₫</span></li>
                </ul>
            </div>
        </div>
        <!-- Main product area -->
        <div class="col-md-9">
            <div class="mb-3">
                <h4>RAU SẠCH – HẠT GIỐNG HOA – CÂY ĂN QUẢ</h4>
                <p>
                    <strong>Công ty TNHH ...</strong> cung cấp các loại <span class="text-success">Rau sạch, hạt giống hoa, cây ăn quả</span> đảm bảo nguồn gốc xuất xứ, uy tín, chất lượng, an toàn vệ sinh thực phẩm.
                    <br>
                    <span class="text-danger">Hotline: 0909090900</span>
                </p>
            </div>
            @if(!empty($searchQuery))
                <div class="alert alert-info">Kết quả tìm kiếm cho: <strong>{{ $searchQuery }}</strong></div>
            @endif
            <h5>SẢN PHẨM MỚI</h5>
            <div class="row">
                @if($newProducts->isEmpty())
                    <div class="col-12"><p>Không tìm thấy sản phẩm phù hợp.</p></div>
                @endif
                @foreach($newProducts as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('images/fruits/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h6 class="card-title">{{ $product->name }}</h6>
                            <p class="card-text">{{ number_format($product->price, 0, ',', '.') }} ₫</p>
                            @if($product->is_discount)
                                <span class="badge badge-success">Giảm giá</span>
                            @endif
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm mt-2 add-to-cart-btn">Thêm vào giỏ</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <h5>ĐANG KHUYẾN MÃI</h5>
            <div class="row">
                @if($discountProducts->isEmpty())
                    <div class="col-12"><p>Không tìm thấy sản phẩm phù hợp.</p></div>
                @endif
                @foreach($discountProducts as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('images/fruits/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h6 class="card-title">{{ $product->name }}</h6>
                            <p class="card-text">
                                <del>{{ number_format($product->old_price, 0, ',', '.') }} ₫</del>
                                <span class="text-danger">{{ number_format($product->price, 0, ',', '.') }} ₫</span>
                            </p>
                            <span class="badge badge-success">Giảm giá</span>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm mt-2 add-to-cart-btn">Thêm vào giỏ</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <h5>HOA QUẢ SẠCH</h5>
            <div class="row">
                @if($cleanFruits->isEmpty())
                    <div class="col-12"><p>Không tìm thấy sản phẩm phù hợp.</p></div>
                @endif
                @foreach($cleanFruits as $product)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('images/fruits/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        <div class="card-body">
                            <h6 class="card-title">{{ $product->name }}</h6>
                            <p class="card-text">{{ number_format($product->price, 0, ',', '.') }} ₫</p>
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm mt-2 add-to-cart-btn">Thêm vào giỏ</button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
