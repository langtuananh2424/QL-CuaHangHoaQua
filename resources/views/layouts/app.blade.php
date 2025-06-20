<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quản lí hoa quả sạch</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/header.css') }}">
        @stack('styles')
        <style>
            body { background: #f8f9fa; }
            .footer { background: #388e3c; color: #fff; padding: 20px 0; margin-top: 40px; }
        </style>
    </head>
    <body>

        <header class="main-header" style="position: fixed; top: 0; left: 0; width: 100%; z-index: 2000;">
            <div class="header-container d-flex align-items-center">
                <a class="header-logo" href="/">Quản lý hoa quả</a>
                <nav class="header-nav">
                    <ul class="header-nav-list">
                        <li><a class="active" href="/">Trang chủ</a></li>
                        <li><a href="#">Sản phẩm</a></li>
                    </ul>
                </nav>
                <form class="header-search" action="{{ route('home') }}" method="get">
                    <input type="search" name="q" placeholder="Tìm kiếm..." value="{{ request('q') }}">
                    <button type="submit">Tìm</button>
                </form>
                <div class="header-user">
                    @auth
                        @if(Auth::user()->role === 'admin')
                            <a href="{{ route('admin.products') }}" style="color: white; margin-right: 15px; text-decoration: none;">
                                <i class="fa fa-cogs"></i> Quản lý
                            </a>
                        @endif
                        <span><i class="fa fa-user"></i> {{ Auth::user()->name }}</span>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out-alt"></i> Đăng xuất</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    @else
                        <a href="{{ route('login') }}"><i class="fa fa-user"></i> Đăng nhập</a>
                        <a href="{{ route('register') }}"><i class="fa fa-user-plus"></i> Đăng ký</a>
                    @endauth
                    <a href="{{ route('cart.show') }}"><i class="fa fa-shopping-cart"></i> Giỏ hàng
                        <span class="badge">
                            @auth
                                <?php
                                $cartCount = 0;
                                $order = \App\Models\Order::where('user_id', Auth::id())
                                    ->where('status', 'pending')->first();
                                if ($order) {
                                    $cartCount = $order->orderItems()->sum('quantity');
                                }
                                ?>
                                {{ $cartCount }}
                            @else
                                0
                            @endauth
                        </span>
                    </a>
                </div>
            </div>
        </header>
        <!-- Main Content -->
        <main style="margin-top: 70px;">
            @yield('content')
        </main>
        <!-- Footer -->
        <footer class="footer text-center">
            <div class="container">
                <p>&copy; {{ date('Y') }} Hoa quả sạch, hạt giống, cây giống chất lượng.</p>
            </div>
        </footer>
        @stack('scripts')
        @auth
            <script>window.isLoggedIn = true;</script>
        @else
            <script>window.isLoggedIn = false;</script>
        @endauth
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.add-to-cart-btn').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    if (!window.isLoggedIn) {
                        e.preventDefault();
                        showLoginPopup();
                    }
                });
            });

            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');

            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('d-none');
                });
            }
        });

        function showLoginPopup() {
            if (document.getElementById('login-popup')) return;
            let popup = document.createElement('div');
            popup.id = 'login-popup';
            popup.style.position = 'fixed';
            popup.style.top = '0'; popup.style.left = '0';
            popup.style.width = '100vw'; popup.style.height = '100vh';
            popup.style.background = 'rgba(0,0,0,0.5)';
            popup.style.display = 'flex'; popup.style.alignItems = 'center'; popup.style.justifyContent = 'center';
            popup.innerHTML = `
                <div style="background:#fff;padding:30px 40px;border-radius:8px;max-width:90vw;text-align:center;">
                    <h4>Bạn cần đăng nhập để sử dụng chức năng này!</h4>
                    <a href='{{ route('login') }}' class='btn btn-success mt-3'>Đăng nhập</a>
                    <button onclick="document.getElementById('login-popup').remove()" class='btn btn-secondary mt-3 ml-2'>Đóng</button>
                </div>
            `;
            document.body.appendChild(popup);
        }
        </script>
    </body>
</html>
