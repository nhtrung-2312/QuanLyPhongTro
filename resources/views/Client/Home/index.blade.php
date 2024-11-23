@extends('layout.client')
@section('title', 'Trang chủ')
@section('content')
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="hero-text">
                    <h1>Sona</h1>
                    <p>Sona sẽ là nơi lý tưởng cho bạn, với giá thành hợp lí và không gian thoải mái</p>
                    <a href="#" class="primary-btn">Khám phá ngay</a>
                </div>
            </div>
        </div>
    </div>
    <div class="hero-slider owl-carousel">
        <div class="hs-item set-bg" data-setbg="/template/client/dist/img/hero/hero-1.jpg"></div>
        <div class="hs-item set-bg" data-setbg="/template/client/dist/img/hero/hero-2.jpg"></div>
        <div class="hs-item set-bg" data-setbg="/template/client/dist/img/hero/hero-3.jpg"></div>
    </div>
</section>
<!-- Hero Section End -->

<!-- About Us Section Begin -->
<section class="aboutus-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="about-text">
                    <div class="section-title">
                        <span>Về chúng tôi</span>
                        <h2>Phòng trọ <br />TP.Hồ Chí Minh</h2>
                    </div>
                    <p class="f-para">
                        Với không gian sống thoải mái, tiện nghi đầy đủ và giá cả hợp lý,
                        chúng tôi cam kết mang đến cho bạn trải nghiệm tuyệt vời và môi trường sống an toàn, tiện lợi.</p>
                    <p class="s-para">Khi nói đến việc đặt phòng chất lượng cao, giá thành hợp lý,
                        chúng tôi luôn sẵn sàng đáp ứng nhu cầu của bạn.</p>
                    <a href="#" class="primary-btn about-btn">Đọc thêm</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="about-pic">
                    <div class="row">
                        <div class="col-sm-6">
                            <img src="/template/client/dist/img/phong/phong_1.png" alt="" width="370" height="420">
                        </div>
                        <div class="col-sm-6">
                            <img src="/template/client/dist/img/phong/phong_2.png" alt="" width="370" height="420">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- About Us Section End -->

<!-- Services Section End -->
<section class="services-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Về chúng tôi</span>
                    <h2>Hãy khám giá các dịch vụ</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-sm-6">
                <div class="service-item">
                    <i class="flaticon-029-wifi"></i>
                    <h4>Dịch vụ mạng</h4>
                    <p>Bạn sẽ có được dịch vụ mạng internet ổn định và nhanh chóng.</p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="service-item">
                    <i class="flaticon-026-bed "></i>
                    <h4>Tiện nghi</h4>
                    <p>Bạn sẽ có được tiện nghi đầy đủ như nhà ở.</p>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="service-item">
                    <i class="flaticon-036-parking"></i>
                    <h4>Địa điểm</h4>
                    <p>Bạn sẽ có được địa điểm thuận tiện, gần các trung tâm thành phố.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Services Section End -->

<!-- Home Room Section Begin -->
<section class="hp-room-section spad">
    <div class="container">
        <div class="hp-room-items">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="hp-room-item set-bg" data-setbg="/template/client/dist/img/room/room-b1.jpg">
                        <div class="hr-text">
                            <h3>Phòng đơn</h3>
                            <h2>199$<span>/Pernight</span></h2>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="r-o">Size:</td>
                                        <td>30 ft</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Capacity:</td>
                                        <td>Max persion 5</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Bed:</td>
                                        <td>King Beds</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Services:</td>
                                        <td>Wifi, Television, Bathroom,...</td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="#" class="primary-btn">More Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="hp-room-item set-bg" data-setbg="/template/client/dist/img/room/room-b2.jpg">
                        <div class="hr-text">
                            <h3>Phòng đôi</h3>
                            <h2>159$<span>/Pernight</span></h2>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="r-o">Size:</td>
                                        <td>30 ft</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Capacity:</td>
                                        <td>Max persion 5</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Bed:</td>
                                        <td>King Beds</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Services:</td>
                                        <td>Wifi, Television, Bathroom,...</td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="#" class="primary-btn">More Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="hp-room-item set-bg" data-setbg="/template/client/dist/img/room/room-b3.jpg">
                        <div class="hr-text">
                            <h3>Phòng 4 người</h3>
                            <h2>198$<span>/Pernight</span></h2>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="r-o">Size:</td>
                                        <td>30 ft</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Capacity:</td>
                                        <td>Max persion 5</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Bed:</td>
                                        <td>King Beds</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Services:</td>
                                        <td>Wifi, Television, Bathroom,...</td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="#" class="primary-btn">More Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="hp-room-item set-bg" data-setbg="/template/client/dist/img/room/room-b4.jpg">
                        <div class="hr-text">
                            <h3>Căn hộ mini</h3>
                            <h2>299$<span>/Pernight</span></h2>
                            <table>
                                <tbody>
                                    <tr>
                                        <td class="r-o">Size:</td>
                                        <td>30 ft</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Capacity:</td>
                                        <td>Max persion 5</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Bed:</td>
                                        <td>King Beds</td>
                                    </tr>
                                    <tr>
                                        <td class="r-o">Services:</td>
                                        <td>Wifi, Television, Bathroom,...</td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="#" class="primary-btn">More Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Home Room Section End -->

<!-- Blog Section End -->
@endsection

