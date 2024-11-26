@extends('Layout.client')
@section('title', 'Chi tiết phòng')
@section('content')
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h2>Thông tin phòng</h2>
                    <div class="bt-option">
                        <a href="{{ route('home.index') }}">Home</a>
                        <span>Rooms</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section End -->

<!-- Room Details Section Begin -->
<section class="room-details-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-1"></div>
            <div class="col-lg-10">
                <div class="room-details-item">
                    <img src="/template/client/dist/img/phong/{{ $phong->MaPhong }}.png" width="100%" height="440" alt="">
                    <div class="rd-text">
                        <div class="rd-title">
                            <h3>{{ $phong->TenPhong }}</h3>
                            <div class="rdt-right">
                                <a href="#">Đặt phòng ngay</a>
                            </div>
                        </div>
                        <h2>{{ number_format($phong->GiaThue, 0, ',', '.') }} đ<span>/Tháng</span></h2>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="r-o">Địa chỉ:</td>
                                    <td>{{ $phong->coSo->DiaChi }}</td>
                                </tr>
                                <tr>
                                    <td class="r-o">Diện tích:</td>
                                    <td>{{ $phong->LoaiPhong->DienTich }} m<sup>2</sup></td>
                                </tr>
                                <tr>
                                    <td class="r-o">Vật dụng đi kèm:</td>
                                    <td>
                                        @foreach ($phong->chiTietPhong as $item)
                                        {{ $item->tienNghi->TenTienNghi }}{{ $loop->last ? '.' : ',' }}
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td class="r-o">Mô tả:</td>
                                    <td>{{ $phong->MoTa }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="map">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.0625274760087!2d106.6289499!3d10.8065231!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752be2853ce7cd%3A0x4111b3b3c2aca14a!2zMTQwIMSQLiBMw6ogVHLhu41uZyBU4bqlbiwgVMOieSBUaOG6oW5oLCBUw6JuIFBow7osIEjhu5MgQ2jDrSBNaW5o!5e0!3m2!1svi!2s!4v1732306227084!5m2!1svi!2s" height="470" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
                {{-- <div class="rd-reviews">
                    <h4>Reviews</h4>
                    <div class="review-item">
                        <div class="ri-pic">
                            <img src="img/room/avatar/avatar-1.jpg" alt="">
                        </div>
                        <div class="ri-text">
                            <span>27 Aug 2019</span>
                            <div class="rating">
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star-half_alt"></i>
                            </div>
                            <h5>Brandon Kelley</h5>
                            <p>Neque porro qui squam est, qui dolorem ipsum quia dolor sit amet, consectetur,
                                adipisci velit, sed quia non numquam eius modi tempora. incidunt ut labore et dolore
                                magnam.</p>
                        </div>
                    </div>
                    <div class="review-item">
                        <div class="ri-pic">
                            <img src="img/room/avatar/avatar-2.jpg" alt="">
                        </div>
                        <div class="ri-text">
                            <span>27 Aug 2019</span>
                            <div class="rating">
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star"></i>
                                <i class="icon_star-half_alt"></i>
                            </div>
                            <h5>Brandon Kelley</h5>
                            <p>Neque porro qui squam est, qui dolorem ipsum quia dolor sit amet, consectetur,
                                adipisci velit, sed quia non numquam eius modi tempora. incidunt ut labore et dolore
                                magnam.</p>
                        </div>
                    </div>
                </div>
                <div class="review-add">
                    <h4>Add Review</h4>
                    <form action="#" class="ra-form">
                        <div class="row">
                            <div class="col-lg-6">
                                <input type="text" placeholder="Name*">
                            </div>
                            <div class="col-lg-6">
                                <input type="text" placeholder="Email*">
                            </div>
                            <div class="col-lg-12">
                                <div>
                                    <h5>You Rating:</h5>
                                    <div class="rating">
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star"></i>
                                        <i class="icon_star-half_alt"></i>
                                    </div>
                                </div>
                                <textarea placeholder="Your Review"></textarea>
                                <button type="submit">Submit Now</button>
                            </div>
                        </div>
                    </form>
                </div> --}}
            </div>
            <div class="col-lg-1"></div>
            {{-- <div class="col-lg-4">
                <div class="room-booking">
                    <h3>Your Reservation</h3>
                    <form action="#">
                        <div class="check-date">
                            <label for="date-in">Check In:</label>
                            <input type="text" class="date-input" id="date-in">
                            <i class="icon_calendar"></i>
                        </div>
                        <div class="check-date">
                            <label for="date-out">Check Out:</label>
                            <input type="text" class="date-input" id="date-out">
                            <i class="icon_calendar"></i>
                        </div>
                        <div class="select-option">
                            <label for="guest">Guests:</label>
                            <select id="guest">
                                <option value="">3 Adults</option>
                            </select>
                        </div>
                        <div class="select-option">
                            <label for="room">Room:</label>
                            <select id="room">
                                <option value="">1 Room</option>
                            </select>
                        </div>
                        <button type="submit">Check Availability</button>
                    </form>
                </div>
            </div> --}}
        </div>
    </div>
</section>
<!-- Room Details Section End -->
@endsection
