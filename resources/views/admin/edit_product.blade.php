@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="row">
        @include('layouts.admin-sidebar')
        <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Sửa sản phẩm</h1>
            </div>
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Tên sản phẩm</label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name', $product->name) }}">
                </div>
                <div class="form-group">
                    <label for="price">Giá</label>
                    <input type="number" name="price" class="form-control" required min="0" value="{{ old('price', $product->price) }}">
                </div>
                <div class="form-group">
                    <label for="old_price">Giá cũ</label>
                    <input type="number" name="old_price" class="form-control" min="0" value="{{ old('old_price', $product->old_price) }}">
                </div>
                <div class="form-group">
                    <label for="description">Mô tả</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="stock">Số lượng</label>
                    <input type="number" name="stock" class="form-control" required min="0" value="{{ old('stock', $product->stock) }}">
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" name="is_discount" class="form-check-input" id="is_discount" value="1" {{ old('is_discount', $product->is_discount) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_discount">Khuyến mãi</label>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" name="is_clean" class="form-check-input" id="is_clean" value="1" {{ old('is_clean', $product->is_clean) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_clean">Sạch</label>
                </div>
                <div class="form-group">
                    <label for="image">Ảnh sản phẩm</label>
                    <input type="file" name="image" class="form-control-file">
                    @if($product->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/'.$product->image) }}" alt="Ảnh sản phẩm" style="max-width:120px;max-height:120px;">
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                <a href="{{ route('admin.products') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection
