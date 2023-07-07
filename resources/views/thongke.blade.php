<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Project</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
</head>
<body>
    <!--START THE NAVBAR SECTION-->
    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px; height:100%">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
          <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
          <span class="fs-4">Sidebar</span>
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
          <li class="nav-item">
            <a href="index.html" class="nav-link active" aria-current="page">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
              Trang cá nhân
            </a>
          </li>
          <li>
            <div class="dropdown">
                <a href="#" class="nav-link text-white dropdown-toggle" data-bs-toggle="dropdown"><svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
                    Bán hàng</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="khachhang.html">Khách hàng</a></li>
                  <li><a class="dropdown-item" href="sanpham.html">Sản phẩm</a></li>
                  <li><a class="dropdown-item" href="hoadon.html">Hóa đơn</a></li>
                </ul>
            </div>
          </li>
          <li>
            <div class="dropdown">
                <a href="#" class="nav-link text-white dropdown-toggle" data-bs-toggle="dropdown"><svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
                    Quản lý</a>
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="quanlynhanvien.html">Nhân viên</a></li>
                  <li><a class="dropdown-item" href="quanlykhachhang.html">Khách hàng</a></li>
                  <li><a class="dropdown-item" href="quanlysanphamquay.html">Sản phẩm quầy</a></li>
                </ul>
            </div>
          </li>
          <li>
            <a href="thongke.html" class="nav-link text-white">
              <svg class="bi pe-none me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
              Thống kê
            </a>
          </li>
        </ul>
        <hr>
        <div class="dropdown">
          <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
            <strong>Cồ Huy Khoa</strong>
          </a>
          <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
            <li><a class="dropdown-item" href="index.html">Profile</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="dangnhap.html">Sign out</a></li>
          </ul>
        </div>
      </div>
  <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
</body>
</html>