@include('components.alert')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="/template/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/template/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/template/admin/dist/css/adminlte.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="/template/admin/dist/img/AdminLTELogo.png" alt="Admin" height="60" width="60">
  </div>

  <!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark">
<!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            @php
                $permissions = \App\Models\PhanQuyen::where('MaTaiKhoan', session('admin_id'))->pluck('MaCoSo')->toArray();
                $coSo = \App\Models\CoSo::whereIn('MaCoSo', $permissions)->get();
                $selectedCoSo = session('selected_facility', $coSo->first()->MaCoSo ?? null);
            @endphp

            <select class="form-control bg-light border-0 text-white" style="margin-top: 3px" id="coSoSelect">
            @foreach($coSo as $item)
                <option value="{{ $item->MaCoSo }}" {{ $selectedCoSo == $item->MaCoSo ? 'selected' : '' }}>
                    Cơ sở {{ $loop->index + 1 }}
                </option>
            @endforeach
            </select>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user"></i> {{ session('admin_name') }}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('admin.thongtin.index') }}">
                    <i class="fas fa-user-circle mr-2"></i>Thông tin tài khoản
                </a>

                <a class="dropdown-item" href="#">
                    <i class="fas fa-cog mr-2"></i>Cài đặt
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item" href="{{ route('auth.logout') }}">
                    <i class="fas fa-sign-out-alt mr-2"></i>Đăng xuất
                </a>
            </div>
        </li>
    </ul>
</nav>
  <!-- /.navbar -->
  <!-- Main Sidebar Container -->
  @php
    $permissions = \App\Models\PhanQuyen::where('MaTaiKhoan', session('admin_id'))
        ->where('MaCoSo', $selectedCoSo)
        ->pluck('MaQuyen')
        ->toArray();
  @endphp
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin" class="brand-link">
      <img src="/template/admin/dist/img/AdminLTELogo.png" alt="Admin" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            @if(in_array('Q009', $permissions))
            <li class="nav-item" data-permission="Q009">
                <a href="{{ route('admin.home.index') }}" class="nav-link active">
                  <i class="nav-icon fas fa-chart-line"></i>
                  <p>
                    Thống kê
                  </p>
                </a>
              </li>
            @endif
              @if(in_array('Q001', $permissions))
              <li class="nav-item" data-permission="Q001">
                <a href="#" class="nav-link active">
                  <i class="nav-icon fas fa-building"></i>
                  <p>
                    Cơ sở
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="/admin/coso" class="nav-link">
                      <p>Danh sách cơ sở</p>
                    </a>
                  </li>
                </ul>
              </li>
            @endif
            @if(in_array('Q004', $permissions))
            <li class="nav-item" data-permission="Q004">
                <a href="#" class="nav-link active">
                  <i class="nav-icon fas fa-door-open"></i>
                  <p>
                    Phòng trọ
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="/admin/loaiphong" class="nav-link">
                      <p>Quản lý loại phòng</p>
                    </a>
                  </li>
                </ul>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="/admin/rooms" class="nav-link">
                      <p>Quản lý phòng</p>
                    </a>
                  </li>
                </ul>
              </li>
            @endif
            @if(in_array('Q002', $permissions))
            <li class="nav-item" data-permission="Q002">
                <a href="#" class="nav-link active">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    Khách hàng
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ route('admin.khachhang.index') }}" class="nav-link">
                      <p>Danh sách khách hàng</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ route('admin.khachhang.create') }}" class="nav-link">
                      <p>Thêm khách hàng mới</p>
                    </a>
                  </li>
                </ul>
              </li>
            @endif

            @if(in_array('Q005', $permissions))
            <li class="nav-item" data-permission="Q005">
                <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-money-bill"></i>
              <p>
                Loại phí
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.loaiphi.index') }}" class="nav-link">
                  <p>Danh sách loại phí</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.loaiphi.create') }}" class="nav-link">
                  <p>Thêm loại phí mới</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          @if(in_array('Q008', $permissions))
          <li class="nav-item" data-permission="Q008">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-file-contract"></i>
              <p>
                Hợp đồng thuê
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.hopdongthue.index') }}" class="nav-link">
                  <p>Danh sách hợp đồng thuê</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.hopdongthue.create') }}" class="nav-link">
                  <p>Thêm hợp đồng thuê mới</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          @if(in_array('Q007', $permissions))
          <li class="nav-item" data-permission="Q007">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>
                Hóa Đơn
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.hoadon.index') }}" class="nav-link">
                  <p> Danh sách hóa đơn</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.hoadon.create') }}" class="nav-link">
                  <p> Thêm hóa đơn mới</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
          @if(in_array('Q003', $permissions))
          <li class="nav-item" data-permission="Q003">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-user-tie"></i>
              <p>
                Nhân viên
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.nhanvien.index') }} " class="nav-link">
                  <p> Danh sách nhân viên</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.nhanvien.create') }} " class="nav-link">
                  <p> Thêm nhân viên mới</p>
                </a>
              </li>
            </ul>
          </li>
          @endif

          @if(in_array('Q001', $permissions))
          <li class="nav-item" data-permission="Q010">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-user-shield"></i>
              <p>
                Phân quyền
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.phanquyen.index') }}" class="nav-link">
                  <p>Danh sách quyền</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.phanquyen.capquyen') }}" class="nav-link">
                  <p>Phân quyền tài khoản</p>
                </a>
              </li>
            </ul>
          </li>
          @endif
        </ul>

        </ul>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">@yield('title')</h1>
          </div>
        </div>
      </div>
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @yield('content')
      </div>
    </section>
    <!-- /.content -->
  </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="/template/admin/plugins/jquery/jquery.min.js"></script>
<script src="/template/admin/plugins/toastr/toastr.min.js"></script>

<!-- Bootstrap -->
<script src="/template/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="/template/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="/template/admin/dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="/template/admin/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="/template/admin/plugins/raphael/raphael.min.js"></script>
<script src="/template/admin/plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="/template/admin/plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="/template/admin/plugins/chart.js/Chart.min.js"></script>
<!-- jQuery UI CSS -->

<!-- jQuery UI JS (sau jQuery core) -->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="/template/admin/dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/template/admin/dist/js/pages/dashboard2.js"></script>
<script>
    // Tự động ẩn alert sau 3 giây
    $(document).ready(function() {
        // Auto hide alerts after 3 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        }, 3000);

        // Vẫn cho phép đóng thủ công
        $('.alert .close').on('click', function() {
            $(this).closest('.alert').fadeOut('slow', function() {
                $(this).remove();
            });
        });

        $('#coSoSelect').change(function() {
            var maCoSo = $(this).val();
            $.ajax({
                url: '/admin/check-permissions',
                method: 'POST',
                data: {
                    maCoSo: maCoSo,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    window.location.reload();
                },
                error: function(xhr) {
                    console.log('Lỗi khi kiểm tra quyền');
                }
            });
        });
    });
</script>
<script>
  // Setup CSRF token for Ajax requests
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
</script>
@stack('scripts')
</body>
</html>
