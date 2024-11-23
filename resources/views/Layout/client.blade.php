<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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

    <!-- Search model Begin -->
    {{-- <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div> --}}
    <!-- Search model end -->

    <!-- Js Plugins -->
    <script src="/template/client/dist/js/jquery-3.3.1.min.js"></script>
    <script src="/template/client/dist/js/bootstrap.min.js"></script>
    <script src="/template/client/dist/js/jquery.magnific-popup.min.js"></script>
    <script src="/template/client/dist/js/jquery.nice-select.min.js"></script>
    <script src="/template/client/dist/js/jquery-ui.min.js"></script>
    <script src="/template/client/dist/js/jquery.slicknav.js"></script>
    <script src="/template/client/dist/js/owl.carousel.min.js"></script>
    <script src="/template/client/dist/js/main.js"></script>
</body>

</html>
