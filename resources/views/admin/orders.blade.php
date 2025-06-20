@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="row">
        @include('layouts.admin-sidebar')
        <!-- Main content -->
        <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Quản lý đơn hàng</h1>
            </div>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Khách hàng</th>
                            <th>Ngày tạo</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Chi tiết</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'N/A' }}</td>
                            <td>{{ $order->created_at }}</td>
                            <td>{{ number_format($order->final_amount, 0, ',', '.') }} ₫</td>
                            <td>
                                @if($order->status === 'pending')
                                    <span class="badge badge-warning">Chờ xử lý</span>
                                @elseif($order->status === 'completed')
                                    <span class="badge badge-success">Hoàn thành</span>
                                @else
                                    <span class="badge badge-secondary">Đã hủy</span>
                                @endif
                            </td>
                            <td>
                                <ul style="padding-left: 18px;">
                                    @foreach($order->orderItems as $item)
                                        <li>{{ $item->fruit->name ?? 'N/A' }} x {{ $item->quantity }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                                <form action="{{ route('admin.orders.delete', $order->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Bạn có chắc muốn xóa đơn hàng này?');">
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
