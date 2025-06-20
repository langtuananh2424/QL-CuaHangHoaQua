@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="row">
        @include('layouts.admin-sidebar')
        <!-- Main content -->
        <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Sửa đơn hàng #{{ $order->id }}</h1>
            </div>
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Khách hàng:</label>
                    <input type="text" class="form-control" value="{{ $order->user->name ?? 'N/A' }}" disabled>
                </div>
                <div class="form-group">
                    <label>Trạng thái:</label>
                    <select name="status" class="form-control">
                        <option value="pending" @if($order->status=='pending') selected @endif>Chờ xử lý</option>
                        <option value="completed" @if($order->status=='completed') selected @endif>Hoàn thành</option>
                        <option value="cancelled" @if($order->status=='cancelled') selected @endif>Đã hủy</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Chi tiết đơn hàng:</label>
                    <ul>
                        @foreach($order->orderItems as $item)
                            <li>{{ $item->fruit->name ?? 'N/A' }} x {{ $item->quantity }}</li>
                        @endforeach
                    </ul>
                </div>
                <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                <a href="{{ route('admin.orders') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection
