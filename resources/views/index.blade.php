<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Project</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
    <!--START THE NAVBAR SECTION-->
    <div class="row">
        @include('includes.drop_quanly')

        <!--START INFO SECTION-->
        <div class="col-md-9">
            <section class="vh-100" style="background-color: #f4f5f7;">
                <div class="container py-5 h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col col-lg-6 mb-4 mb-lg-0">
                            <div class="card mb-3" style="border-radius: .5rem;">
                                <div class="row g-0">
                                    <div class="col-md-4 gradient-custom text-center text-white"
                                        style="border-top-left-radius: .5rem; border-bottom-left-radius: .5rem;">
                                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                            alt="Avatar" class="img-fluid my-5" style="width: 80px;" />
                                        <h5>Marie Horwitz</h5>
                                        <p>Web Designer</p>
                                        <i class="far fa-edit mb-5"></i>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body p-4">
                                            <h6>Thông tin</h6>
                                            <hr class="mt-0 mb-4">
                                            <div class="row pt-1">
                                                <div class="col-6 mb-3">
                                                    <h6 class="text-muted">{{ Session::get('user')->id }}</h6>

                                                    <p class="text-muted">25</p>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <h6>Email</h6>
                                                    <p class="text-muted">{{ Session::get('user')->email }}</p>
                                                </div>
                                            </div>
                                            <div class="row pt-1">
                                                <div class="col-6 mb-3">
                                                    <h6>Giới tính</h6>
                                                    <p class="text-muted">Nam</p>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <h6>Số điện thoại</h6>
                                                    <p class="text-muted">0987654321</p>
                                                </div>
                                            </div>
                                            <h6>Chức vụ</h6>
                                            <p>Nhân viên</p>
                                            <h6>Đổi mật khẩu</h6>
                                            <hr class="mt-0 mb-4">
                                            <!-- Email input -->
                                            <div class="form-outline mb-4">
                                                <input type="password" id="form2Example2" class="form-control" />
                                                <label class="form-label" for="form2Example2">Mật khẩu cũ</label>
                                            </div>

                                            <!-- Password input -->
                                            <div class="form-outline mb-4">
                                                <input type="password" id="form2Example2" class="form-control" />
                                                <label class="form-label" for="form2Example2">Mật khẩu mới</label>
                                            </div>
                                            <button type="button" class="btn btn-primary btn-block mb-4">Xác
                                                nhận</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
</body>

</html>
