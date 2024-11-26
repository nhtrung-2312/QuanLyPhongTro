@extends('layout.client')
@section('title', 'Xem phòng')
@section('content')
<div class="breadcrumb-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb-text">
                    <h2>Loại phòng</h2>
                    <div class="bt-option">
                        <a href="{{ route('home.index') }}">Home</a>
                        <span>Rooms</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="rooms-section spad">
    <div class="container">
        <div class="row">
            @foreach ($loaiphong as $item)
            <div class="col-lg-4 col-md-6">
                <div class="room-item">
                    <img src="/template/client/dist/img/phong/{{ $item->MaLoaiPhong }}.png" alt="" width="600" height="500">
                    <div class="ri-text">
                        <h4>{{ $item->LoaiPhong }}</h4>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="r-o">Diện tích:</td>
                                    <td>{{ $item->DienTich }} m<sup>2</sup></td>
                                </tr>
                                <tr>
                                    <td class="r-o">Phù hợp cho:</td>
                                    <td>{{ $item->SoNguoi }} người</td>
                                </tr>
                            </tbody>
                        </table>
                        <a href="{{ url('phong/' . $item->MaLoaiPhong) }}" class="primary-btn">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
