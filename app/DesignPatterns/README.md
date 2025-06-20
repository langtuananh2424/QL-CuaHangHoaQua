# Design Patterns Structure

Cấu trúc thư mục được tổ chức theo từng Design Pattern để dễ quản lý và hiểu rõ hơn.

## 📁 Cấu trúc thư mục

```
app/
├── DesignPatterns/
│   ├── Factory/           # Factory Pattern
│   │   ├── FruitFactory.php
│   │   ├── FruitFactory2.php
│   │   ├── FactoryExample.php
│   │   └── Types/         # Các loại trái cây cụ thể
│   │       ├── Apple.php
│   │       ├── Mango.php
│   │       ├── Orange.php
│   │       ├── GenericFruit.php
│   │       └── FruitTypes.php
│   │
│   ├── Decorator/         # Decorator Pattern
│   │   ├── BaseFruitDecorator.php
│   │   ├── DiscountedFruit.php
│   │   ├── OrganicFruit.php
│   │   ├── OrganicFruitDecorator.php
│   │   ├── PremiumPackagingDecorator.php
│   │   ├── PremiumPackagingFruit.php
│   │   └── SaleBadgeDecorator.php
│   │
│   ├── Facade/            # Facade Pattern
│   │   ├── CheckoutFacade.php
│   │   ├── InventoryChecker.php
│   │   ├── InventoryUpdater.php
│   │   ├── InvoiceGenerator.php
│   │   └── PriceCalculator.php
│   │
│   ├── Singleton/         # Singleton Pattern
│   │   ├── DatabaseConnection.php
│   │   ├── DatabaseInventoryManager.php
│   │   └── InventoryManager.php
│   │
│   ├── Memento/           # Memento Pattern
│   │   └── CartMemento.php
│   │
│   └── Observer/          # Observer Pattern (Events & Listeners)
│       ├── OrderPlaced.php
│       └── UpdateStockAfterOrder.php
│
├── Contracts/             # Interfaces & Contracts
│   ├── FruitDisplayInterface.php
│   ├── InventoryManagerInterface.php
│   └── FruitInterface.php
│
├── Models/                # Eloquent Models
├── Http/Controllers/      # Controllers
├── Providers/             # Service Providers
└── Managers/              # Manager Classes
```

## 🎯 Design Patterns được sử dụng

### 1. **Factory Pattern** (`/Factory/`)
- **Mục đích**: Tạo các đối tượng trái cây mà không cần chỉ định class cụ thể
- **File**: 
  - `FruitFactory.php` - Factory class chính với nhiều phương thức tạo
  - `FruitFactory2.php` - Factory class phụ
  - `FactoryExample.php` - Demo cách sử dụng Factory pattern
  - `Types/` - Chứa các loại trái cây cụ thể
    - `Apple.php`, `Mango.php`, `Orange.php` - Các loại trái cây
    - `GenericFruit.php` - Trái cây generic
    - `FruitTypes.php` - Enum định nghĩa tất cả loại trái cây
- **Tính năng**:
  - Tạo trái cây bằng string hoặc enum
  - Hỗ trợ tạo nhiều trái cây cùng lúc
  - Tích hợp với FruitTypes enum
  - Có thể truyền Fruit model hoặc tạo mới
- **Lợi ích**: Dễ dàng thêm loại trái cây mới, tách biệt logic tạo đối tượng

### 2. **Decorator Pattern** (`/Decorator/`)
- **Mục đích**: Mở rộng chức năng của trái cây (giảm giá, hữu cơ, bao bì cao cấp)
- **File**: Các decorator classes
- **Lợi ích**: Linh hoạt trong việc thêm tính năng, tuân thủ Open/Closed Principle

### 3. **Facade Pattern** (`/Facade/`)
- **Mục đích**: Đơn giản hóa quá trình checkout phức tạp
- **File**: `CheckoutFacade.php` và các service liên quan
- **Lợi ích**: Ẩn độ phức tạp, cung cấp interface đơn giản

### 4. **Singleton Pattern** (`/Singleton/`)
- **Mục đích**: Đảm bảo chỉ có một instance của database connection
- **File**: `DatabaseConnection.php`, `InventoryManager.php`
- **Lợi ích**: Tiết kiệm tài nguyên, đảm bảo tính nhất quán

### 5. **Memento Pattern** (`/Memento/`)
- **Mục đích**: Lưu và khôi phục trạng thái giỏ hàng
- **File**: `CartMemento.php`
- **Lợi ích**: Hỗ trợ undo/redo, lưu trạng thái

### 6. **Observer Pattern** (`/Observer/`)
- **Mục đích**: Xử lý events khi có thay đổi (đặt hàng, cập nhật kho)
- **File**: `OrderPlaced.php`, `UpdateStockAfterOrder.php`
- **Lợi ích**: Loose coupling, dễ mở rộng

## 🔧 Cách sử dụng

### Factory Pattern Usage:
```php
// Tạo trái cây bằng string
$apple = FruitFactory::create('apple');

// Tạo trái cây bằng enum
$orange = FruitFactory::createFromType(FruitTypes::ORANGE);

// Tạo trái cây với thông tin từ enum
$mango = FruitFactory::createWithEnumInfo(FruitTypes::MANGO);

// Tạo nhiều trái cây cùng lúc
$fruits = FruitFactory::createMultiple([
    FruitTypes::APPLE,
    'orange',
    FruitTypes::MANGO
]);

// Chạy demo
FactoryExample::demonstrate();
```

1. **Import classes**: Sử dụng namespace tương ứng với thư mục
2. **Dependency Injection**: Đăng ký trong `AppServiceProvider`
3. **Testing**: Mỗi pattern có thể test độc lập

## 📝 Lưu ý

- Tất cả interfaces được đặt trong thư mục `Contracts/`
- Models và Controllers giữ nguyên vị trí Laravel standard
- Factory pattern bao gồm cả Types để tổ chức các loại trái cây cụ thể
- FruitTypes enum cung cấp thông tin chi tiết về từng loại trái cây
- Mỗi pattern có thể có sub-patterns hoặc kết hợp với nhau
