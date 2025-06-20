@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="row">
        @include('layouts.admin-sidebar')
        <!-- Main content -->
        <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Quản lý sản phẩm</h1>
                <a href="{{ route('admin.products.create') }}" class="btn btn-success">+ Thêm sản phẩm</a>
            </div>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Tên sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Khuyến mãi</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $fruit)
                        <tr>
                            <td>{{ $fruit->id }}</td>
                            <td>{{ $fruit->name }}</td>
                            <td>{{ number_format($fruit->price, 0, ',', '.') }} ₫</td>
                            <td>{{ $fruit->stock }}</td>
                            <td>
                                @if($fruit->is_discount)
                                    <span class="badge badge-success">Có</span>
                                @else
                                    <span class="badge badge-secondary">Không</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $fruit->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                <form action="{{ route('admin.products.delete', $fruit->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
