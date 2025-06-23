@extends('layouts.app')

@section('content')
<div class="container-fluid mt-5">
    <div class="row">
        @include('layouts.admin-sidebar')
        <!-- Main content -->
        <div class="col-md-9 col-lg-10 ms-sm-auto px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">🌱 Quản lý dữ liệu trái cây - Factory Pattern</h1>
            </div>

            <!-- Thống kê hiện tại -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">📊 Thống kê hiện tại</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 class="text-primary">{{ $statistics['total_fruits'] }}</h4>
                                <p class="text-muted">Tổng số bản ghi</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 class="text-success">{{ number_format($statistics['total_stock']) }}</h4>
                                <p class="text-muted">Tổng số lượng kho</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 class="text-info">{{ number_format($statistics['total_value'], 0, ',', '.') }} ₫</h4>
                                <p class="text-muted">Tổng giá trị kho</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="text-center">
                                <h4 class="text-warning">{{ $statistics['discount_count'] }}</h4>
                                <p class="text-muted">Sản phẩm giảm giá</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tạo dữ liệu -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">🚀 Tạo dữ liệu sử dụng Factory Pattern</h5>
                </div>
                <div class="card-body">
                    <form id="createDataForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="quantity">Số lượng mỗi loại:</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="10">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="clearExisting" name="clear_existing">
                                        <label class="form-check-label" for="clearExisting">
                                            Xóa dữ liệu cũ trước khi tạo
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>&nbsp;</label>
                                    <div>
                                        <button type="submit" class="btn btn-primary">Tạo dữ liệu</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tạo từng loại trái cây -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">🍎 Tạo từng loại trái cây</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <button class="btn btn-outline-primary w-100" onclick="createSingleFruit('apple')">🍎 Táo</button>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button class="btn btn-outline-warning w-100" onclick="createSingleFruit('orange')">🍊 Cam</button>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button class="btn btn-outline-warning w-100" onclick="createSingleFruit('mango')">🥭 Xoài</button>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button class="btn btn-outline-warning w-100" onclick="createSingleFruit('banana')">🍌 Chuối</button>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button class="btn btn-outline-warning w-100" onclick="createSingleFruit('pineapple')">🍍 Dứa</button>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button class="btn btn-outline-purple w-100" onclick="createSingleFruit('grape')">🍇 Nho</button>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button class="btn btn-outline-success w-100" onclick="createSingleFruit('watermelon')">🍉 Dưa hấu</button>
                        </div>
                        <div class="col-md-3 mb-2">
                            <button class="btn btn-outline-danger w-100" onclick="createSingleFruit('strawberry')">🍓 Dâu tây</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quản lý dữ liệu -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">🗑️ Quản lý dữ liệu</h5>
                </div>
                <div class="card-body">
                    <button class="btn btn-danger" onclick="clearData()">Xóa tất cả dữ liệu</button>
                    <button class="btn btn-info" onclick="refreshStatistics()">Làm mới thống kê</button>
                </div>
            </div>

            <!-- Kết quả -->
            <div id="result" class="alert" style="display: none;"></div>
        </div>
    </div>
</div>

<script>
// Tạo dữ liệu
document.getElementById('createDataForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);
    const data = {
        quantity: formData.get('quantity'),
        clear_existing: formData.get('clear_existing') === 'on'
    };

    fetch('{{ route("admin.fruit-data.create") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        showResult(data.success ? 'success' : 'danger', data.message);
        if (data.success) {
            setTimeout(() => location.reload(), 2000);
        }
    })
    .catch(error => {
        showResult('danger', 'Lỗi: ' + error.message);
    });
});


// Tạo một loại trái cây
function createSingleFruit(type) {
    fetch('{{ route("admin.fruit-data.single") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ type: type })
    })
    .then(response => response.json())
    .then(data => {
        showResult(data.success ? 'success' : 'danger', data.message);
        if (data.success) {
            setTimeout(() => location.reload(), 2000);
        }
    })
    .catch(error => {
        showResult('danger', 'Lỗi: ' + error.message);
    });
}

// Xóa dữ liệu
function clearData() {
    if (!confirm('Bạn có chắc muốn xóa tất cả dữ liệu trái cây?')) {
        return;
    }

    fetch('{{ route("admin.fruit-data.clear") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        showResult(data.success ? 'success' : 'danger', data.message);
        if (data.success) {
            setTimeout(() => location.reload(), 2000);
        }
    })
    .catch(error => {
        showResult('danger', 'Lỗi: ' + error.message);
    });
}

// Làm mới thống kê
function refreshStatistics() {
    location.reload();
}

// Hiển thị kết quả
function showResult(type, message) {
    const resultDiv = document.getElementById('result');
    resultDiv.className = `alert alert-${type}`;
    resultDiv.textContent = message;
    resultDiv.style.display = 'block';

    setTimeout(() => {
        resultDiv.style.display = 'none';
    }, 5000);
}
</script>

<style>
.btn-outline-purple {
    color: #6f42c1;
    border-color: #6f42c1;
}

.btn-outline-purple:hover {
    color: #fff;
    background-color: #6f42c1;
    border-color: #6f42c1;
}
</style>
@endsection
