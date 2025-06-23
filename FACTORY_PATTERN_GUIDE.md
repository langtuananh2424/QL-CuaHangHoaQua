# 🌱 Factory Pattern - Hướng dẫn sử dụng

## 📋 Tổng quan

Factory Pattern đã được cập nhật để phù hợp với database schema và bài toán thực tế của cửa hàng hoa quả.

## 🔧 Các thay đổi đã thực hiện

### 1. **Cập nhật FruitInterface**
- Thay đổi từ `getColor()`, `getTaste()` thành các phương thức phù hợp với database:
  - `getPrice()`: Giá hiện tại
  - `getOldPrice()`: Giá cũ (để hiển thị giảm giá)
  - `getDescription()`: Mô tả sản phẩm
  - `getStock()`: Số lượng tồn kho
  - `isDiscount()`: Có giảm giá hay không
  - `isClean()`: Có phải sản phẩm sạch không
  - `getImage()`: Tên file ảnh
  - `toArray()`: Chuyển đổi thành array để lưu database

### 2. **Cập nhật các Concrete Classes**
Tất cả các loại trái cây đã được cập nhật với dữ liệu thực tế:

#### 🍎 **Apple (Táo)**
- Giá: 45,000 ₫ (giảm từ 55,000 ₫)
- Kho: 150 sản phẩm
- Có giảm giá và là sản phẩm sạch

#### 🍊 **Orange (Cam)**
- Giá: 35,000 ₫
- Kho: 200 sản phẩm
- Sản phẩm sạch, không giảm giá

#### 🥭 **Mango (Xoài)**
- Giá: 25,000 ₫ (giảm từ 30,000 ₫)
- Kho: 180 sản phẩm
- Có giảm giá và là sản phẩm sạch

#### 🍌 **Banana (Chuối)**
- Giá: 15,000 ₫
- Kho: 300 sản phẩm
- Sản phẩm sạch, không giảm giá

#### 🍍 **Pineapple (Dứa)**
- Giá: 20,000 ₫
- Kho: 120 sản phẩm
- Không phải sản phẩm sạch, không giảm giá

#### 🍇 **Grape (Nho)**
- Giá: 85,000 ₫ (giảm từ 100,000 ₫)
- Kho: 80 sản phẩm
- Có giảm giá và là sản phẩm sạch

#### 🍉 **Watermelon (Dưa hấu)**
- Giá: 12,000 ₫
- Kho: 250 sản phẩm
- Không phải sản phẩm sạch, không giảm giá

#### 🍓 **Strawberry (Dâu tây)**
- Giá: 95,000 ₫ (giảm từ 120,000 ₫)
- Kho: 60 sản phẩm
- Có giảm giá và là sản phẩm sạch

### 3. **Cập nhật FruitFactory**
Thêm các phương thức mới:
- `createAndSaveFruit()`: Tạo và lưu trái cây vào database
- `createAllFruits()`: Tạo tất cả các loại trái cây
- `createSampleData()`: Tạo dữ liệu mẫu với số lượng tùy chỉnh

## 🚀 Cách sử dụng

### 1. **Sử dụng Artisan Command**
```bash
# Tạo dữ liệu demo (1 bản ghi mỗi loại)
php artisan fruits:seed-factory

# Tạo nhiều bản ghi mỗi loại
php artisan fruits:seed-factory --quantity=5

# Xóa dữ liệu cũ trước khi tạo
php artisan fruits:seed-factory --clear
```

### 2. **Sử dụng Service Class**
```php
use App\Services\FruitDataService;

$service = new FruitDataService();

// Tạo dữ liệu demo
$result = $service->createDemoData();

// Tạo dữ liệu với số lượng tùy chỉnh
$result = $service->createFruitData(3, true); // 3 bản ghi mỗi loại, xóa dữ liệu cũ

// Tạo một loại trái cây cụ thể
$result = $service->createSingleFruit('apple');

// Lấy thống kê
$stats = $service->getStatistics();
```

### 3. **Sử dụng Factory trực tiếp**
```php
use App\DesignPatterns\Factory\FruitFactory;

// Tạo đối tượng trái cây
$apple = FruitFactory::createFruit('apple');
echo $apple->getName(); // "Táo"
echo $apple->getPrice(); // 45000.0

// Tạo và lưu vào database
$fruit = FruitFactory::createAndSaveFruit('apple');

// Tạo tất cả các loại
$allFruits = FruitFactory::createAllFruits();
```

### 4. **Sử dụng Web Interface**
Truy cập: `/admin/fruit-data`

Các chức năng có sẵn:
- Tạo dữ liệu với số lượng tùy chỉnh
- Tạo từng loại trái cây riêng lẻ
- Tạo dữ liệu demo
- Xóa tất cả dữ liệu
- Xem thống kê

## 📊 Thống kê dữ liệu

Sau khi tạo dữ liệu, bạn có thể xem thống kê:
- Tổng số bản ghi: 8 (mỗi loại 1 bản ghi)
- Tổng số lượng trong kho: 1,290 sản phẩm
- Tổng giá trị kho: 37,200,000 ₫
- Sản phẩm có giảm giá: 4 loại
- Sản phẩm sạch: 6 loại

## 🔗 Tích hợp với các Pattern khác

Factory Pattern này có thể tích hợp với:
- **Decorator Pattern**: Để hiển thị thông tin trái cây với các badge khác nhau
- **Singleton Pattern**: Để quản lý kho trái cây
- **Facade Pattern**: Để xử lý quy trình thanh toán

## 🎯 Lợi ích

1. **Dễ bảo trì**: Mỗi loại trái cây có class riêng, dễ thay đổi thông tin
2. **Mở rộng**: Dễ dàng thêm loại trái cây mới
3. **Nhất quán**: Tất cả trái cây tuân theo cùng một interface
4. **Thực tế**: Dữ liệu phù hợp với bài toán cửa hàng hoa quả
5. **Linh hoạt**: Có thể tạo dữ liệu với nhiều cách khác nhau

## 🛠️ Cấu trúc file

```
app/
├── DesignPatterns/
│   └── Factory/
│       ├── FruitInterface.php
│       ├── FruitFactory.php
│       ├── Apple.php
│       ├── Orange.php
│       ├── Mango.php
│       ├── Banana.php
│       ├── Pineapple.php
│       ├── Grape.php
│       ├── Watermelon.php
│       └── Strawberry.php
├── Services/
│   └── FruitDataService.php
├── Http/
│   └── Controllers/
│       └── FruitDataController.php
└── Console/
    └── Commands/
        └── SeedFruitsWithFactory.php
```

## 📝 Lưu ý

- Tất cả giá được tính bằng VND
- Sản phẩm sạch được đánh dấu `is_clean = true`
- Sản phẩm giảm giá có `old_price` và `is_discount = true`
- Factory pattern giờ đây hoàn toàn tích hợp với database 
