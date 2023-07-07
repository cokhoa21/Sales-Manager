<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
    <section class="text-center text-lg-start">
        <style>
            /* CSS styles here */
        </style>
        <div class="card mb-3">
            <div class="row g-0 d-flex align-items-center">
                <div class="col-lg-4 d-none d-lg-flex">
                    <img src="https://mdbootstrap.com/img/new/ecommerce/vertical/004.jpg" alt="Trendy Pants and Shoes"
                        class="w-100 rounded-t-5 rounded-tr-lg-0 rounded-bl-lg-5" />
                </div>
                <div class="col-lg-8">
                    <div class="card-body py-5 px-md-5">
                        @if (session('errors'))
                            <div class="alert alert-danger">
                                Tài khoản hoặc mật khẩu không chính xác
                            </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            <!-- Email input -->
                            @csrf
                            <div class="form-outline mb-4">
                                <input type="email" name="email" id="form2Example1" class="form-control" required />
                                <label class="form-label" for="form2Example1">Địa chỉ email</label>
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-4">
                                <input type="password" name="password" id="form2Example2" class="form-control"
                                    required />
                                <label class="form-label" for="form2Example2">Mật khẩu</label>
                            </div>

                            <!-- 2 column grid layout for inline styling -->
                            <div class="row mb-4">
                                <div class="col d-flex justify-content-center">
                                    <!-- Checkbox -->
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="form2Example31" checked />
                                        <label class="form-check-label" for="form2Example31"> Nhớ mật khẩu </label>
                                    </div>
                                </div>

                                <div class="col">
                                    <!-- Simple link -->
                                    <a href="#!">Quên mật khẩu?</a>
                                </div>
                            </div>

                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block mb-4" id="login">Đăng
                                nhập</button>
                            <a href="dangky.html"><button type="button" class="btn btn-primary btn-block mb-4">Đăng
                                    ký</button></a>
                        </form>

                        <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
</body>

</html>
