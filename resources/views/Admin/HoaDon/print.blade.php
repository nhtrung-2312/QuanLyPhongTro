<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Hóa đơn - {{ $hoadon->MaHoaDon }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
        }
        h2 {
            text-align: center;
        }
        .header .date {
            color:red;
            text-align: center;
        }
        .inline {
            display: inline-block;
            width: 50%;
        }
        .inline.left {
            text-align: left;
        }
        .inline.right {
            text-align: right;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #000;
            padding: 5px;
        }
        .note {
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h3>{{ $coso->TenCoSo }}</h3>
        <p>Địa chỉ: {{ $coso->DiaChi }}</p>
        <p>Điện thoại: {{ $coso->DienThoai }}</p>
        <h2>THÔNG BÁO TIỀN PHÒNG TRỌ</h2>
        <p class="date">Ngày {{ date('d/m/Y', strtotime($hoadon->NgayLap)) }}</p>
    </div>
    <div class="content">
        <p>Kính gửi Ông/Bà: <strong>{{ $khachthue->HoTen }}</strong></p>
        <p>Phòng số: <strong>{{ $hoadon->hopdongthue->phong->TenPhong }}</strong></p>
        <p>Ngày in: {{ date('d/m/Y') }}</p>
    </div>
    <table class="table">
        <thead>
            <tr style="width: 100%">
                <th style="width: 10%; text-align: center">STT</th>
                <th style="width: 20%">Nội dung</th>
                <th style="width: 50%">Chi tiết</th>
                <th style="width: 20%; text-align: right">Thành Tiền</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center">1</td>
                <td>Tiền thuê phòng</td>
                <td></td>
                <td style="text-align: right">{{ number_format($hoadon->hopdongthue->phong->GiaThue, 0, ',', '.') }} đ</td>
            </tr>
            @foreach($hoadon->chitiethoadon as $key => $chitiethoadon)
            <tr>
                <td style="text-align: center">{{ $loop->iteration + 1 }}</td>
                <td>{{ $chitiethoadon->LoaiPhi->TenLoaiPhi }}</td>
                <td>
                    @if($chitiethoadon->SoLuong != 1)
                        @if(strtolower($chitiethoadon->LoaiPhi->TenLoaiPhi) == 'tiền điện')
                            CSM: {{ $chitiethoadon->hoadon->chisodiennuoc->DienCu }}, CSC: {{ $chitiethoadon->hoadon->chisodiennuoc->DienMoi }}
                        @elseif(strtolower($chitiethoadon->LoaiPhi->TenLoaiPhi) == 'tiền nước')
                            CSM: {{ $chitiethoadon->hoadon->chisodiennuoc->NuocCu }}, CSC: {{ $chitiethoadon->hoadon->chisodiennuoc->NuocMoi }}
                        @endif
                    @else
                        @if(str_contains(strtolower($chitiethoadon->LoaiPhi->TenLoaiPhi), 'tiền giữ xe'))
                            {{ $chitiethoadon->SoLuong }} xe x {{ number_format($chitiethoadon->LoaiPhi->DonGia, 0, ',', '.') }} VND
                        @else

                        @endif
                    @endif
                </td>
                <td style="text-align: right">{{ number_format($chitiethoadon->ThanhTien, 0, ',', '.') }} đ</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align: right">Tổng cộng</td>
                <td style="text-align: right">{{ number_format($hoadon->TongTien, 0, ',', '.') }} đ</td>
            </tr>
        </tbody>
    </table>

    <div class="note">
        <p>Xin vui lòng thanh toán tiền từ ngày 25-30 hàng tháng.</p>
        <p>Hình thức thanh toán: Tiền mặt hoặc chuyển khoản qua ngân hàng.</p>
        <p>Ngân hàng: TPBank</p>
        <p>Số tài khoản: trunnbakaaa</p>
        <p>Chủ tài khoản: Nguyễn Hoàng Trung</p>
        <p>Nội dung chuyển khoản: [PHONG...NHA 451. THANG...]</p>
        <p>Quý khách vui lòng giữ hóa đơn để đối chiếu chỉ số điện - nước tháng tiếp theo và liên hệ với các vấn đề liên hệ với chị Yến hoặc anh Trung.</p>
    </div>
</body>
</html>
