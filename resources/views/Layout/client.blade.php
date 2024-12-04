<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Lora:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600,700&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="/template/client/dist/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="/template/client/dist/css/font-awesome.min.css" type="text/css">
    <link rel="stylesheet" href="/template/client/dist/css/elegant-icons.css" type="text/css">
    <link rel="stylesheet" href="/template/client/dist/css/flaticon.css" type="text/css">
    <link rel="stylesheet" href="/template/client/dist/css/owl.carousel.min.css" type="text/css">
    <link rel="stylesheet" href="/template/client/dist/css/nice-select.css" type="text/css">
    <link rel="stylesheet" href="/template/client/dist/css/jquery-ui.min.css" type="text/css">
    <link rel="stylesheet" href="/template/client/dist/css/magnific-popup.css" type="text/css">
    <link rel="stylesheet" href="/template/client/dist/css/slicknav.min.css" type="text/css">
    <link rel="stylesheet" href="/template/client/dist/css/style.css" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
</head>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Section Begin -->
    <div class="offcanvas-menu-overlay"></div>
    <div class="canvas-open">
        <i class="icon_menu"></i>
    </div>
    <div class="offcanvas-menu-wrapper">
        <div class="canvas-close">
            <i class="icon_close"></i>
        </div>
        {{-- <div class="search-icon  search-switch">
            <i class="icon_search"></i>
        </div> --}}
        <div class="header-configure-area">
            @if(session()->has('logged_in'))
                <div class="language-option">
                    <span onclick="logout()">Đăng xuất</span>
                </div>
            @else
                <div class="language-option">
                    <span onclick="showLogin()">Đăng nhập/Đăng ký</span>
                </div>
            @endif
        </div>
        <div class="header-configure-area">
            <a href="#" class="bk-btn">Thuê phòng ngay</a>
        </div>
        <nav class="mainmenu mobile-menu">
            <ul>
                <li><a href="{{ route('home.index') }}">Trang chủ</a></li>
                <li><a href="{{ route('phong.index') }}">Xem phòng</a></li>
                <li><a href="{{ route('home.about') }}">Về chúng tôi</a></li>
                <li><a href="{{ route('home.contact') }}">Liên hệ</a></li>
            </ul>
        </nav>
        <div id="mobile-menu-wrap"></div>
        <div class="top-social">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
        </div>
        <ul class="top-widget">
            <li><i class="fa fa-phone"></i> (+84) 926850074</li>
            <li><i class="fa fa-envelope"></i> nhtrung2312@gmail.com</li>
        </ul>
    </div>
    <!-- Offcanvas Menu Section End -->

    <!-- Header Section Begin -->
    <header class="header-section">
        <div class="top-nav">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="tn-left">
                            <li><i class="fa fa-phone"></i> (+84) 926850074</li>
                            <li><i class="fa fa-envelope"></i> nhtrung2312@gmail.com</li>
                        </ul>
                    </div>
                    <div class="col-lg-6">
                        <div class="tn-right">
                            <div class="top-social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                            <a href="{{ route('phong.index') }}" class="bk-btn">Đặt phòng ngay</a>
                            @if(session()->has('logged_in'))
                                <div class="language-option">
                                    <i class="fa fa-user"></i>
                                    <span>Thông tin <i class="fa fa-angle-down"></i></span>
                                    <div class="flag-dropdown">
                                        <ul>
                                            <li><span>Xin chào, {{ Str::of(session('username'))->explode(' ')->last() }}</span></li>
                                            <li><hr style="margin: 5px 0"></li>
                                            <li><a href="{{ url('/thong-tin/thong-tin-ca-nhan') }}">Thông tin cá nhân</a></li>
                                            <li><a href="{{ route('auth.logout') }}">Đăng xuất</a></li>
                                        </ul>
                                    </div>
                                </div>
                            @else
                                <div class="language-option">
                                    <span onclick="showLogin()">Đăng nhập/Đăng ký</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="menu-item" style="box-shadow:0px 12px 15px rgba(36, 11, 12, 0.05)">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2">
                        <div class="logo">
                            <a href="./index.html">
                                <img src="/template/client/dist/img/logo.png" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        <div class="nav-menu">
                            <nav class="mainmenu">
                                <ul>
                                    <li><a href="{{ route('home.index') }}">Trang chủ</a></li>
                                    <li><a href="{{ route('phong.index') }}">Xem phòng</a></li>
                                    <li><a href="{{ route('home.about') }}">Về chúng tôi</a></li>
                                    <li><a href="{{ route('home.contact') }}">Liên hệ</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header End -->

    <!-- Hero Section Begin -->
    @yield('content')
    <!-- Hero Section End -->

    <!-- Footer Section Begin -->
    <footer class="footer-section">
        <div class="container">
            <div class="footer-text">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="ft-about">
                            <div class="logo">
                                <a href="#">
                                    <img src="/template/client/dist/img/footer-logo.png" alt="">
                                </a>
                            </div>
                            <p>Chúng tôi mang lại sử thoải mái<br >đến toàn bộ khách hàng</p>
                            <div class="fa-social">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="ft-contact">
                            <h6>Liên hệ</h6>
                            <ul>
                                <li>(+84) 926850074</li>
                                <li>nhtrung2312@gmail.com</li>
                                <li>140 Lê Trọng Tấn, Q.Tân Phú, TP. Hồ Chí Minh</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 offset-lg-1">
                        <div class="ft-newslatter">
                            <h6>Thông báo mới nhất</h6>
                            <p>Nhận thông báo mới và cập nhật mới nhất</p>
                            <form action="" class="fn-form">
                                <input type="text" placeholder="Email">
                                <button type="submit"><i class="fa fa-send"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-option">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <div class=""><p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved</p></div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Show Login Modal Start -->
    <div class="modal fade" id="showLoginModal" tabindex="-1" aria-labelledby="showLoginModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content">
                <div class="modal-header border-0 flex-column">
                    <h3 class="modal-title w-100 font-weight-bold" id="showLoginModal">Xin chào</h3>
                    <p class="mb-0 mt-2">Vui lòng đăng nhập để tiếp tục</p>
                    <button type="button" class="close position-absolute" style="right: 1rem; top: 1rem;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-4">
                    <form id="loginForm" method="POST" action="{{ route('auth.login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" class="form-control" name="phone" placeholder="Số điện thoại">
                            <small class="text-danger" id="phoneError"></small>
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            <input type="password" class="form-control" name="password" placeholder="Mật khẩu">
                            <small class="text-danger" id="passwordError"></small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block py-2 mb-3">Đăng nhập</button>
                        <button class="btn btn-primary btn-block py-2 mb-3">Đăng nhập với SMS</button>
                    </form>

                    <div class="text-center mb-3">
                        <span class="text-muted">Hoặc</span>
                    </div>

                    <button onclick="showRegister()" id="regModal" class="btn btn-light btn-block border py-2 mb-3">Đăng ký</button>
                </div>
            </div>
        </div>
    </div>
    <!--- Show Login Modal End -->

    <!-- Register Modal Start -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content">
                <div class="modal-header border-0 flex-column">
                    <h3 class="modal-title w-100 font-weight-bold" id="showLoginModal">Xin chào</h3>
                    <p class="mb-0 mt-2">Vui lòng đăng nhập để tiếp tục</p>
                    <button type="button" class="close position-absolute" style="right: 1rem; top: 1rem;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-4">
                    <form id="registerForm" method="POST" action="{{ route('auth.register') }}">
                        @csrf
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" class="form-control" name="phone" placeholder="Số điện thoại">
                            <small class="text-danger" id="phoneError"></small>
                        </div>
                        <div class="form-group">
                            <label for="password">Mật khẩu</label>
                            <input type="password" class="form-control" name="password" placeholder="Mật khẩu">
                            <small class="text-danger" id="passwordError"></small>
                        </div>
                        <div class="form-group">
                            <label for="repassword">Nhập lại mật khẩu</label>
                            <input type="password" class="form-control" name="repassword" placeholder="Nhập lại mật khẩu">
                            <small class="text-danger" id="repasswordError"></small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block py-2 mb-3">Đăng ký</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Register Modal End -->

    <!-- Js Plugins -->
    <script src="/template/client/dist/js/jquery-3.3.1.min.js"></script>
    <script src="/template/client/dist/js/bootstrap.min.js"></script>
    <script src="/template/client/dist/js/jquery.magnific-popup.min.js"></script>
    <script src="/template/client/dist/js/jquery.nice-select.min.js"></script>
    <script src="/template/client/dist/js/jquery-ui.min.js"></script>
    <script src="/template/client/dist/js/jquery.slicknav.js"></script>
    <script src="/template/client/dist/js/owl.carousel.min.js"></script>
    <script src="/template/client/dist/js/main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>


    <script>
        $(document).ready(function() {
            $('#registerForm').on('submit', function(e) {
                e.preventDefault();
                $('.text-danger').text('');

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message);
                            setTimeout(function() {
                                window.location.href = response.redirect;
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.phone) {
                                $('#registerForm #phoneError').text(errors.phone[0]);
                            }
                            if (errors.password) {
                                $('#registerForm #passwordError').text(errors.password[0]);
                            }
                            if (errors.repassword) {
                                $('#registerForm #repasswordError').text(errors.repassword[0]);
                            }
                            if (errors.system) {
                                toastr.error(errors.system[0]);
                            }
                        }
                    }
                });
            });
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                $('.text-danger').text('');

                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.status) {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            console.log(errors);
                            if (errors.phone) {
                                $('#phoneError').text(errors.phone);
                            }
                            if (errors.password) {
                                $('#passwordError').text(errors.password);
                            }
                        } else if (xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;
                            console.log(errors);
                            if (errors.phone) {
                                $('#phoneError').text(errors.phone);
                            }
                            if (errors.password) {
                                $('#passwordError').text(errors.password);
                            }
                        }
                    }
                });
            });
        });
        function showLogin() {
            $('#showLoginModal').modal('show');
        }

        function showRegister() {
            $('#showLoginModal').modal('hide');
            $('#registerModal').modal('show');
        }
    </script>

    @stack('scripts')
</body>
</html>
