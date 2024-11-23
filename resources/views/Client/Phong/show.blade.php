@extends('Layout.client')
@section('title', $loaiphong->LoaiPhong)
@section('content')
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h2>Phòng đơn</h2>
                    <div class="bt-option">
                        <a href="{{ route('home.index') }}">Home</a>
                        <a href="{{ route('phong.index') }}">Rooms</a>
                        <span>Phòng đơn</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="rooms-section spad">
    <div class="container">
        <div class="row">
            @foreach ($phong as $item)
            <div class="col-lg-4 col-md-6">
                <div class="room-item">
                    <img src="{{ file_exists(public_path('template/client/dist/img/phong/' . $item->MaPhong . '.png'))
                            ? '/template/client/dist/img/phong/' . $item->MaPhong . '.png'
                            : '/template/client/dist/img/phong/noimage.png' }}"
                    alt="Hình ảnh"
                    width="600"
                    height="300">
                    <div class="ri-text">
                        <h4>{{ $item->TenPhong }}</h4>
                        <h3>{{ number_format($item->GiaThue, 0, ',', '.') }}<span>/Tháng</span></h3>
                        <table>
                            <tbody>
                                <tr>
                                    @php
                                    if (preg_match('/Quận [^,]+/', $item->coSo->DiaChi, $matches)) {
                                        $quan = $matches[0];
                                    }
                                    @endphp
                                    <td class="r-o">Khu vực:</td>
                                    <td> {{ $quan }} </td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="{{ route('phong.show', $item->MaLoaiPhong) }}" class="primary-btn">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            @endforeach
            <div class="col-lg-12">
                {{ $phong->links() }}
            </div>
        </div>
    </div>
</section>
@endsection
