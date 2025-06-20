@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="row">
        @include('layouts.admin-sidebar')
        <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Sửa khách hàng</h1>
            </div>
            <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Tên khách hàng</label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name', $customer->name) }}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" required value="{{ old('email', $customer->email) }}">
                </div>
                <div class="form-group">
                    <label for="phone">Điện thoại</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $customer->phone) }}">
                </div>
                <div class="form-group">
                    <label for="address">Địa chỉ</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $customer->address) }}">
                </div>
                <div class="form-group">
                    <label for="role">Vai trò</label>
                    <select name="role" class="form-control">
                        <option value="customer" {{ old('role', $customer->role)==='customer' ? 'selected' : '' }}>Khách hàng</option>
                        <option value="admin" {{ old('role', $customer->role)==='admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password">Mật khẩu mới (bỏ trống nếu không đổi)</label>
                    <input type="password" name="password" class="form-control" autocomplete="new-password">
                </div>
                <button type="submit" class="btn btn-success">Lưu thay đổi</button>
                <a href="{{ route('admin.customers') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection
