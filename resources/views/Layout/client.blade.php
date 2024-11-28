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
            <div class="language-option">
                <img src="img/flag.jpg" alt="">
                <span>EN <i class="fa fa-angle-down"></i></span>
                <div class="flag-dropdown">
                    <ul>
                        <li><a href="#">Zi</a></li>
                        <li><a href="#">Fr</a></li>
                    </ul>
                </div>
            </div>
            <a href="#" class="bk-btn">Booking Now</a>
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
                            <div class="language-option">
                                <img src="img/flag.jpg" alt="">
                                <span onclick="login()">Đăng nhập/Đăng ký</span>
                            </div>
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

    <!-- Login Modal Start -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
            <div class="modal-content">
                <div class="modal-header border-0 flex-column">
                    <h3 class="modal-title w-100 font-weight-bold" id="loginModal">Xin chào</h3>
                    <p class="mb-0 mt-2">Vui lòng đăng nhập để tiếp tục</p>
                    <button type="button" class="close position-absolute" style="right: 1rem; top: 1rem;" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-4">
                    <form id="loginForm">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control" name="phone"
                                   placeholder="Số điện thoại" pattern="[0-9]{10}">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password"
                                   placeholder="Mật khẩu">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block py-2 mb-3">Đăng nhập</button>
                    </form>

                    <div class="text-center mb-3">
                        <span class="text-muted">Hoặc</span>
                    </div>

                    <button id="regModal" class="btn btn-light btn-block border py-2 mb-3">Đăng ký</button>
                </div>
            </div>
        </div>
    </div>
    <!--- Login Modal End -->

    <!-- Js Plugins -->
    <script src="/template/client/dist/js/jquery-3.3.1.min.js"></script>
    <script src="/template/client/dist/js/bootstrap.min.js"></script>
    <script src="/template/client/dist/js/jquery.magnific-popup.min.js"></script>
    <script src="/template/client/dist/js/jquery.nice-select.min.js"></script>
    <script src="/template/client/dist/js/jquery-ui.min.js"></script>
    <script src="/template/client/dist/js/jquery.slicknav.js"></script>
    <script src="/template/client/dist/js/owl.carousel.min.js"></script>
    <script src="/template/client/dist/js/main.js"></script>


    <script>
        function login() {
            $('#loginModal').modal('show');
        }
    </script>
</body>
</html>
