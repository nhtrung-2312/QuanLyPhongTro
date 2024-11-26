@extends('layout.client')
@section('title', 'Về chúng tôi')
@section('content')
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h2>Về chúng tôi</h2>
                    <div class="bt-option">
                        <a href="{{ route('home.index') }}">Home</a>
                        <span>About Us</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section End -->

<!-- About Us Page Section Begin -->
<section class="aboutus-page-section spad">
    <div class="container">
        <div class="about-page-text">
            <div class="row">
                <div class="col-lg-6">
                    <div class="ap-title">
                        <h2>Chào mừng đến với Sona.</h2>
                        <p>Các phòng trọ được xây dựng vào trung tâm thành phố Hồ Chí Minh,
                            với vị trí thuận tiện để đến các điểm tham quan nổi tiếng.
                            Nơi đây cung cấp các phòng được trang trí tinh tế</p>
                    </div>
                </div>
                <div class="col-lg-5 offset-lg-1">
                    <ul class="ap-services">
                        <li><i class="icon_check"></i> Quản lý bảo vệ xe tốt</li>
                        <li><i class="icon_check"></i> Wifi chất lượng cao</li>
                        <li><i class="icon_check"></i> Có thể giảm giá cho sinh viên</li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="about-page-services">
            <div class="row">
                <div class="col-md-4">
                    <div class="ap-service-item set-bg" data-setbg="/template/client/dist/img/about/about1.png">
                        <div class="api-text">
                            <h3></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ap-service-item set-bg" data-setbg="/template/client/dist/img/about/about2.png">
                        <div class="api-text">
                            <h3></h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="ap-service-item set-bg" data-setbg="/template/client/dist/img/about/about3.png">
                        <div class="api-text">
                            <h3></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Us Page Section End -->

<!-- Video Section Begin -->
<section class="video-section set-bg" data-setbg="/template/client/dist/img/video-bg.jpg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="video-text">
                    <h2>Khám phá về khách sạn và dịch vụ.</h2>
                    <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" class="play-btn video-popup"><img
                            src="/template/client/dist/img/play.png" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Video Section End -->

<!-- Gallery Section Begin -->
<section class="gallery-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Our Gallery</span>
                    <h2>Khám phá công việc</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="gallery-item set-bg" data-setbg="/template/client/dist/img/gallery/gallery-1.jpg">
                    <div class="gi-text">
                        <h3>Phòng đơn</h3>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="gallery-item set-bg" data-setbg="/template/client/dist/img/gallery/gallery-3.jpg">
                            <div class="gi-text">
                                <h3>Phòng đôi</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="gallery-item set-bg" data-setbg="/template/client/dist/img/gallery/gallery-4.jpg">
                            <div class="gi-text">
                                <h3>Phòng nhiều người</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="gallery-item large-item set-bg" data-setbg="/template/client/dist/img/gallery/gallery-2.jpg">
                    <div class="gi-text">
                        <h3>Căn hộ mini</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Gallery Section End -->
@endsection
