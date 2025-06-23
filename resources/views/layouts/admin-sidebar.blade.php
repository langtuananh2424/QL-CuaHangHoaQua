<style>
.sidebar {
    background-color: #f8f9fa;
    border-right: 1px solid #dee2e6;
}
.sidebar .nav-link { color: #495057; padding: 0.75rem 1rem; border-radius: 0.25rem; margin: 0.125rem 0; }
.sidebar .nav-link:hover { background-color: #e9ecef; color: #212529; }
.sidebar .nav-link.active { background-color: #007bff; color: white; }
.sidebar .nav-link i { margin-right: 0.5rem; width: 16px; }
@media (max-width: 767.98px) { .sidebar { position: fixed; top: 0; left: 0; z-index: 100; padding: 48px 0 0; box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1); } }
</style>
<div class="col-md-3 col-lg-2 d-md-block bg-light sidebar" id="sidebar" style="min-height: 100vh;">
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link{{ request()->routeIs('admin.products') ? ' active' : '' }}" href="{{ route('admin.products') }}">
                    <i class="fa fa-box"></i> Quản lý sản phẩm
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ request()->routeIs('admin.customers') ? ' active' : '' }}" href="{{ route('admin.customers') }}">
                    <i class="fa fa-users"></i> Quản lý khách hàng
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ request()->routeIs('admin.orders') ? ' active' : '' }}" href="{{ route('admin.orders') }}">
                    <i class="fa fa-file-invoice"></i> Quản lý đơn hàng
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link{{ request()->routeIs('admin.fruit-data') ? ' active' : '' }}" href="{{ route('admin.fruit-data') }}">
                    <i class="fa fa-seedling"></i> Factory Pattern - Fruit Data
                </a>
            </li>
        </ul>
    </div>
</div>
