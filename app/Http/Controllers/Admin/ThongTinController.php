<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NhanVien;
use App\Models\TaiKhoan;
use Illuminate\Support\Facades\Log;
use Spatie\Backup\Backup;
use Spatie\Backup\BackupDestination\BackupDestination;
use Illuminate\Support\Facades\Artisan;
use Spatie\Backup\Tasks\Backup\BackupJob;
use Symfony\Component\Process\Process;
use App\Models\PhanQuyen;
class ThongTinController extends Controller
{
    public function index()
    {
        $nhanvien = NhanVien::where('MaTaiKhoan', session('admin_id'))->first();
        return view('admin.thongtin.index', compact('nhanvien'));
    }
    public function account()
    {
        $taikhoan = TaiKhoan::where('MaTaiKhoan', session('admin_id'))->first();
        return view('admin.thongtin.account', compact('taikhoan'));
    }
    public function backup()
    {
        $permissions = PhanQuyen::where('MaTaiKhoan', session('admin_id'))
            ->where('MaCoSo', session('selected_facility'))
            ->pluck('MaQuyen')
            ->toArray();
        if(in_array("Q010", $permissions)){
            return view('admin.thongtin.backup');
        }
        return redirect()->route('admin.thongtin.index')->with('error', 'Bạn không có quyền truy cập trang này');
    }
    public function update(Request $request)
    {
        $credentials = $request->validate([
            'hoten' => 'required|string|max:255',
            'diachi' => 'required|string|max:255',
            'sdt' => 'required|string|max:10|regex:/^[0-9]+$/',
            'cccd' => 'required|string|max:12|regex:/^[0-9]+$/',
            'gioitinh' => 'required|in:Nam,Nữ',
            'ngaysinh' => 'required|date|before:today',
        ], [
            'hoten.required' => 'Họ tên không được để trống',
            'hoten.max' => 'Họ tên không được vượt quá 255 ký tự',
            'diachi.required' => 'Địa chỉ không được để trống',
            'diachi.max' => 'Địa chỉ không được vượt quá 255 ký tự',
            'sdt.required' => 'Số điện thoại không được để trống',
            'sdt.max' => 'Số điện thoại không được vượt quá 10 số',
            'sdt.regex' => 'Số điện thoại chỉ được chứa số',
            'cccd.required' => 'CCCD không được để trống',
            'cccd.max' => 'CCCD không được vượt quá 12 số',
            'cccd.regex' => 'CCCD chỉ được chứa số',
            'gioitinh.required' => 'Giới tính không được để trống',
            'gioitinh.in' => 'Giới tính không hợp lệ',
            'ngaysinh.required' => 'Ngày sinh không được để trống',
            'ngaysinh.date' => 'Ngày sinh không hợp lệ',
            'ngaysinh.before' => 'Ngày sinh phải nhỏ hơn ngày hiện tại'
        ]);
        $nhanvien = NhanVien::where('MaTaiKhoan', session('admin_id'))->first();
        if($nhanvien){
            $nhanvien->HoTen = $credentials['hoten'];
            $nhanvien->DiaChi = $credentials['diachi'];
            $nhanvien->SDT = $credentials['sdt'];
            $nhanvien->CCCD = $credentials['cccd'];
            $nhanvien->GioiTinh = $credentials['gioitinh'];
            $nhanvien->NgaySinh = $credentials['ngaysinh'];
            $nhanvien->save();
        } else {
            do {
                $maNhanVien = 'NV' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
            } while (NhanVien::where('MaNhanVien', $maNhanVien)->exists());

            $nhanvien = NhanVien::create([
                'MaNhanVien' => $maNhanVien,
                'MaTaiKhoan' => session('admin_id'),
                'MaCoSo' => session('selected_facility'),
                'HoTen' => $credentials['hoten'],
                'DiaChi' => $credentials['diachi'],
                'SDT' => $credentials['sdt'],
            ]);
        }
        return response()->json(['success' => true, 'message' => 'Cập nhật thông tin thành công']);
    }
    public function updateaccount(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string|max:255',
            'old_password' => 'required|string',
            'new_password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8|same:new_password',
        ], [
            'username.required' => 'Tên đăng nhập không được bỏ trống*',
            'username.max' => 'Tên đăng nhập không được vượt quá 255 ký tự*',
            'old_password.required' => 'Mật khẩu cũ không được bỏ trống*',
            'new_password.required' => 'Mật khẩu mới không được bỏ trống*',
            'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự*',
            'confirm_password.required' => 'Xác nhận mật khẩu không được để trống*',
            'confirm_password.min' => 'Xác nhận mật khẩu phải có ít nhất 8 ký tự*',
            'confirm_password.same' => 'Xác nhận mật khẩu không khớp*',
        ]);
        $taikhoan = TaiKhoan::where('MaTaiKhoan', session('admin_id'))->first();
        if($taikhoan->MatKhau != $credentials['old_password']){
            return response()->json(['success' => false, 'message' => 'Mật khẩu cũ không đúng*']);
        }
        $taikhoan->TenDangNhap = $credentials['username'];
        $taikhoan->MatKhau = $credentials['new_password'];
        $taikhoan->save();
        return response()->json(['success' => true, 'message' => 'Cập nhật mật khẩu thành công']);
    }
    public function createBackup()
    {
        try {
            $process = new Process(['php', 'artisan', 'backup:run', '--only-db', '--disable-notifications']);
            $process->run();

            return response()->json([
                'success' => true,
                'message' => 'Tạo bản sao lưu thành công',
            ]);
        } catch (\Exception $e) {
            Log::error('Backup failed: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Tạo bản sao lưu thất bại: ' . $e->getMessage(),
            ]);
        }
    }

    public function download($filename)
    {
        try {
            $path = storage_path("app/Laravel/{$filename}");
            if (file_exists($path)) {
                return response()->download($path);
            }
            return response()->json([
                'success' => false,
                'message' => 'File không tồn tại'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải file'
            ]);
        }
    }
    public function restoreDatabase(Request $request)
    {
        try {
            if (!$request->hasFile('backup_file')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng chọn file backup'
                ]);
            }

        $file = $request->file('backup_file');

        // Kiểm tra file có phải là file sql không
        if ($file->getClientOriginalExtension() !== 'sql') {
            return response()->json([
                'success' => false,
                'message' => 'File không hợp lệ. Vui lòng chọn file .sql'
            ]);
        }

        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');

        // Lưu file tạm
        $path = $file->getRealPath();

        // Thực hiện lệnh restore
        $command = sprintf(
            'D:\xampp\mysql\bin\mysql -u%s -p%s %s < %s',
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($database),
            escapeshellarg($path)
        );

        exec($command, $output, $returnVar);

        if ($returnVar === 0) {
            return response()->json([
                'success' => true,
                'message' => 'Phục hồi dữ liệu thành công'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Không thể phục hồi dữ liệu'
        ]);

        } catch (\Exception $e) {
            return response()->json([
            'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
            ]);
        }
    }
}
