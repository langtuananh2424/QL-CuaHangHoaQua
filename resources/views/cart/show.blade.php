@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Giỏ hàng của bạn</h2>
    @if(count($items) > 0)
        <form action="{{ route('cart.checkout') }}" method="POST" class="d-inline">
            @csrf
            <table class="table">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>Ảnh</th>
                        <th>Tên</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($items as $item)
                        @php $total += $item->fruit->price * $item->quantity; @endphp
                        <tr>
                            <td><input type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="item-checkbox"></td>
                            <td><img src="{{ asset('images/fruits/' . $item->fruit->image) }}" width="50"></td>
                            <td>{{ $item->fruit->name }}</td>
                            <td>{{ number_format($item->fruit->price, 0, ',', '.') }} ₫</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ number_format($item->fruit->price * $item->quantity, 0, ',', '.') }} ₫</td>
                            <td>
                                <form action="{{ route('cart.removeItem', $item->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?');">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" class="text-right"><strong>Tổng cộng:</strong></td>
                        <td colspan="2"><strong>{{ number_format($total, 0, ',', '.') }} ₫</strong></td>
                    </tr>
                </tbody>
            </table>
            <button type="submit" class="btn btn-success">Thanh toán</button>
        </form>
        <form action="{{ route('cart.cancel') }}" method="POST" class="d-inline" onsubmit="return confirm('Bạn có chắc muốn hủy giỏ hàng?');">
            @csrf
            <button type="submit" class="btn btn-danger ml-2">Hủy giỏ hàng</button>
        </form>
        <form action="{{ route('cart.undo') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-warning ml-2">Hoàn tác giỏ hàng</button>
        </form>
        <script>
        document.getElementById('select-all').addEventListener('change', function() {
            let checked = this.checked;
            document.querySelectorAll('.item-checkbox').forEach(cb => cb.checked = checked);
        });
        </script>
    @else
        <p>Giỏ hàng trống.</p>
    @endif
</div>
@endsection
