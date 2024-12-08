@extends('layout.admin')
@section('title', 'Thống kê cơ sở')
@section('content')

@php
    $tongPhongTrong = $phongs->where('TrangThai', 'Phòng trống')->count();
    $tongPhongDaThue = $phongs->where('TrangThai', 'Đang thuê')->count();
@endphp

<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $phongs->count() }}</h3>
                <p>Tổng số phòng</p>
            </div>
            <div class="icon">
                <i class="fas fa-home"></i>
            </div>
            <a href="{{ route('admin.rooms.index') }}" class="small-box-footer">
                Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $tongPhongTrong }} </h3>
                <p>Phòng trống</p>
            </div>
            <div class="icon">
                <i class="fas fa-door-open"></i>
            </div>
            <a href="{{ route('admin.rooms.index') }}?MaLoaiPhong=&TrangThai=Phòng+trống" class="small-box-footer">
                Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $tongPhongDaThue }}</h3>
                <p>Phòng đã thuê</p>
            </div>
            <div class="icon">
                <i class="fas fa-door-closed"></i>
            </div>
            <a href="{{ route('admin.rooms.index') }}?MaLoaiPhong=&TrangThai=Đang+thuê" class="small-box-footer">
                Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $khachThueMoi->count() }}</h3>
                <p>Tổng số khách thuê</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('admin.khachhang.index') }}" class="small-box-footer">
                Xem chi tiết <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Hoá đơn gần đây</h3>
                <a href="{{ route('admin.hoadon.index') }}" class="card-tools btn btn-primary">Xem tất cả</a>
            </div>
            <div class="card-body table-responsive p-0">
                @if(isset($hoaDons) && $hoaDons->count() > 0)
                <table class="table table-hover text-nowrap text-center">
                    <thead>
                        <tr>
                            <th>Phòng</th>
                            <th>Ngày lập</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hoaDons as $hoaDon)
                        <tr>
                            <td>{{ $hoaDon->hopdongthue->phong->TenPhong }}</td>
                            <td>{{ $hoaDon->NgayLap }}</td>
                            <td>
                                @if($hoaDon->TrangThai == 'Đã thanh toán')
                                    <span class="badge badge-success">{{ $hoaDon->TrangThai }}</span>
                                @elseif($hoaDon->TrangThai == 'Chưa thanh toán')
                                    <span class="badge badge-danger">{{ $hoaDon->TrangThai }}</span>
                                @else
                                    <span class="badge badge-secondary">{{ $hoaDon->TrangThai }}</span>
                                @endif
                            </td>
                            <td><a href="{{ route('admin.hoadon.details', $hoaDon->MaHoaDon) }}" class="btn btn-primary">Xem</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <h5 class="text-center">Không có hoá đơn nào</h5>
                @endif
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Hợp đồng thuê</h3>
                <a href="{{ route('admin.hopdongthue.index') }}" class="card-tools btn btn-primary">Xem tất cả</a>
            </div>
            <div class="card-body table-responsive p-0">
                @if(isset($hopDongs) && $hopDongs->count() > 0)
                <table class="table table-hover text-nowrap text-center">
                    <thead>
                        <tr>
                            <th>Phòng</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày hết hạn</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($hopDongs as $hopDong)
                        <tr>
                            <td>{{ $hopDong->phong->TenPhong }}</td>
                            <td>{{ $hopDong->NgayBatDau }}</td>
                            <td>{{ $hopDong->NgayKetThuc }}</td>
                            <td>
                                @if($hopDong->TrangThai == 'Còn hiệu lực')
                                    <span class="badge badge-success">{{ $hopDong->TrangThai }}</span>
                                @elseif($hopDong->TrangThai == 'Hết hiệu lực')
                                    <span class="badge badge-danger">{{ $hopDong->TrangThai }}</span>
                                @else
                                    <span class="badge badge-secondary">{{ $hopDong->TrangThai }}</span>
                                @endif
                            </td>
                            <td><a href="{{ route('admin.hopdongthue.edit', $hopDong->MaHopDong) }}" class="btn btn-primary">Xem</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <h5 class="text-center">Không có hợp đồng nào</h5>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title">Biểu đồ doanh thu</h3>
                <div class="text-center flex-grow-1">
                    <h4 class="mb-0" id="total" style="display: none;">Tổng doanh thu: <span id="totalRevenue"></span></h4>
                </div>
                <div class="card-tools">
                    <select name="year" id="year" class="form-control">
                        <option value="" hidden selected>Chọn năm</option>
                        @for($i = date('Y'); $i >= 2020; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="card-body">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('revenueChart').getContext('2d');
    var myChart = null;

    ctx.canvas.style.height = '300px';

    document.getElementById('year').addEventListener('change', function() {
        let totalRevenue = 0;
        var year = this.value;
        fetch(`/admin/api/hoadon/get-hoadon-by-year?year=${year}`)
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    if(data.data.length === 0) {
                        if(myChart) {
                            myChart.destroy();
                        }
                        ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
                        ctx.font = '20px Arial';
                        ctx.fillStyle = '#666';
                        ctx.textAlign = 'center';
                        ctx.fillText('Chưa có hoá đơn của năm ' + year, ctx.canvas.width/2, ctx.canvas.height/2);
                        document.getElementById('total').style.display = 'none';
                        return;
                    }

                    let monthlyData = Array(12).fill(0);
                    data.data.forEach(item => {
                        let month = new Date(item.NgayLap).getMonth();
                        monthlyData[month] += parseFloat(item.TongTien);
                        totalRevenue += parseFloat(item.TongTien);
                    });

                    document.getElementById('totalRevenue').textContent = new Intl.NumberFormat('vi-VN', {
                        style: 'currency',
                        currency: 'VND'
                    }).format(totalRevenue);
                    document.getElementById('total').style.display = 'block';

                    if(myChart) {
                        myChart.destroy();
                    }

                    myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
                            datasets: [{
                                label: 'Doanh thu theo tháng (VNĐ)',
                                data: monthlyData,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        callback: function(value) {
                                            return new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(value);
                                        }
                                    }
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return new Intl.NumberFormat('vi-VN', {
                                                style: 'currency',
                                                currency: 'VND'
                                            }).format(context.raw);
                                        }
                                    }
                                }
                            }
                        }
                    });
                }
            });
    });
});
</script>
@endpush

@endsection
