# Hệ thống Quản lý Phòng trọ

Hệ thống quản lý phòng trọ được xây dựng bằng Laravel Framework, giúp chủ trọ quản lý hiệu quả các phòng cho thuê và khách thuê.

## Tính năng chính

### Dành cho Khách thuê
- Xem danh sách phòng trống
- Đặt phòng trực tuyến
- Thanh toán tiền phòng
- Xem thông tin hợp đồng
- Xem hóa đơn hàng tháng

### Dành cho Admin
- Quản lý phòng trọ
- Quản lý khách thuê
- Quản lý hợp đồng thuê
- Quản lý hóa đơn
- Thống kê doanh thu

## Yêu cầu hệ thống

- PHP >= 8.1
- MySQL/MariaDB
- Composer
- Node.js & NPM

## Hướng dẫn cài đặt

1. Clone repository
```
bash
git clone https://github.com/nhtrung-2312/QuanLyPhongTro.git
cd QuanLyPhongTro
```
2. Cài đặt dependencies
```
bash
composer install
npm install
```
3. Tạo file .env
```
bash
cp .env.example .env
```
4. Cấu hình database trong file .env
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=quanlyphongtro
DB_USERNAME=root
DB_PASSWORD=
```
5. Tạo key cho ứng dụng
```
bash
php artisan key:generate
```
6. Chạy migration và seeder
```
bash
php artisan migrate --seed
```
7. Build assets
```
bash
npm run dev
```
8. Khởi chạy ứng dụng
```
bash
php artisan serve
```

Truy cập: http://localhost:8000

## Tài khoản demo

### Admin
- Username: nguyenminhkhanh
- Password: 123123123

### Khách thuê
- Username: 0926850074
- Password: 0926850074

## Công nghệ sử dụng

- Laravel 10
- MySQL
- Bootstrap 5
- jQuery
- AJAX
