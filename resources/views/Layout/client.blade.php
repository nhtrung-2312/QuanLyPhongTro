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
            @guest
                <div class="language-option">
                    <img src="img/flag.jpg" alt="">
                    <span onclick="showLogin()">Đăng nhập/Đăng ký</span>
                </div>
            @endguest
            @auth
                <div class="language-option">
                    <img src="img/flag.jpg" alt="">
                    <span onclick="logout()">Đăng xuất</span>
                </div>
            @endauth
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
                                <span onclick="showLogin()">Đăng nhập/Đăng ký</span>
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
                    <form id="showLoginForm" onsubmit="return validateLogin(event)">
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
                        <button onclick="loginSMS(event)" class="btn btn-primary btn-block py-2 mb-3">Đăng nhập với SMS</button>
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
                    <form id="registerForm">
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
                            <input type="repassword" class="form-control" name="repassword" placeholder="Nhập lại mật khẩu">
                            <small class="text-danger" id="repasswordError"></small>
                        </div>
                        <button onclick="register()" class="btn btn-primary btn-block py-2 mb-3">Đăng ký</button>
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


    <script>
        function showLogin() {
            $('#showLoginModal').modal('show');
        }

        function showRegister() {
            $('#showLoginModal').modal('hide');
            $('#registerModal').modal('show');
        }
        function login(e) {
            e.preventDefault();
            $('#phoneError').text('');
            $('#passwordError').text('');
            $('#loginBtn').prop('disabled', true);

            let phone = $('#phone').val().trim();
            let password = $('#password').val().trim();
            let isValid = true;

            if (!phone) {
                $('#phoneError').text('Vui lòng nhập số điện thoại');
                isValid = false;
            } else if (!/^[0-9]{10}$/.test(phone)) {
                $('#phoneError').text('Số điện thoại không hợp lệ');
                isValid = false;
            }
            if (!password) {
                $('#passwordError').text('Vui lòng nhập mật khẩu');
                isValid = false;
            } else if (password.length < 6) {
                $('#passwordError').text('Mật khẩu phải có ít nhất 6 ký tự');
                isValid = false;
            }
            if (isValid) {
                login();
            } else {
                $('#loginBtn').prop('disabled', false);
            }

            return false;
        }
        function login() {
            let phone = $('#phone').val().trim();
            let password = $('#password').val().trim();
            $.ajax({
                url: '/login',
                type: 'POST',
                data: {
                    phone: phone,
                    password: password,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $('#showLoginModal').modal('hide');
                        toastr.success('Đăng nhập thành công!');
                        window.location.href = '/';
                    }
                },
                error: function(xhr) {
                    if(xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if(errors.phone) {
                            $('#phoneError').text(errors.phone[0]);
                        }
                        if(errors.password) {
                            $('#passwordError').text(errors.password[0]);
                        }
                    } else if(xhr.status === 401) {
                        toastr.error('Số điện thoại hoặc mật khẩu không chính xác');
                    } else {
                        toastr.error('Có lỗi xảy ra, vui lòng thử lại sau');
                    }
                },
                complete: function() {
                    $('#loginBtn').prop('disabled', false);
                }
            });
        }
    </script>
</body>
</html>
