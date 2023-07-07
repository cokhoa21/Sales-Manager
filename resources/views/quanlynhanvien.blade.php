<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Final Project</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .actions {
            display: flex;
            justify-content: space-around;
        }

        /* CSS cho modal */
        .modal {
            display: none;
            /* Ẩn modal mặc định */
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!--START THE NAVBAR SECTION-->
    <div class="row">
        <div class="col-md-2">
            <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark dashboard" style="width: 280px">
                <a href="/"
                    class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <svg class="bi pe-none me-2" width="40" height="32">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                    <span class="fs-4">Sidebar</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="{{ route('index') }}" class="nav-link active" aria-current="page">
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#home"></use>
                            </svg>
                            Trang cá nhân
                        </a>
                    </li>
                    <li>
                        <div class="dropdown">
                            <a href="#" class="nav-link text-white dropdown-toggle" data-bs-toggle="dropdown"><svg
                                    class="bi pe-none me-2" width="16" height="16">
                                    <use xlink:href="#speedometer2"></use>
                                </svg>
                                Bán hàng</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="">Khách hàng</a></li>
                                <li><a class="dropdown-item" href="{{ route('sanpham') }}">Sản phẩm</a></li>
                                <li><a class="dropdown-item" href="hoadon.html">Hóa đơn</a></li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown">
                            <a href="#" class="nav-link text-white dropdown-toggle" data-bs-toggle="dropdown"><svg
                                    class="bi pe-none me-2" width="16" height="16">
                                    <use xlink:href="#speedometer2"></use>
                                </svg>
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
                            <svg class="bi pe-none me-2" width="16" height="16">
                                <use xlink:href="#table"></use>
                            </svg>
                            Thống kê
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="" width="32" height="32"
                            class="rounded-circle me-2">
                        <h5>{{ Session::get('user')->email }}</h5>

                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="index.html">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="container-fluid">
                <h1 class="display-4 my-4 text-info">List of employee</h1>

                <button onclick="openModal()">Thêm</button>

                <input type="text" id="search" placeholder="Tìm kiếm">

                <table id="mytable" style="width: 100%;text-align: center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>chức vụ</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>


        <!--START INFO SECTION-->

    </div>
    <div id="myModal" class="modal">
        <div class="modal-content" style="text-align: center">
            <span class="close" onclick="closeModal()">&times;</span>
            <form id="form" action="{{ route('add_employee') }}" method="post">
                @csrf
                <input type="email" id="email" name="email" placeholder="Email" required><br><br>
                <button>Thêm</button>
            </form>
        </div>
    </div>
    <script src="./node_modules/bootstrap/dist/js/bootstrap.bundle.js"></script>
    <script>
        $(document).ready(function() {

            $('#search').on('keyup', function() {
                var value = $(this).val();
                var route = `${window.location.origin}/api/nhanvien`;

                $.ajax({
                    url: route,
                    type: 'get',
                    data: {
                        id: value,
                    }
                }).done(function(ketqua) {
                    $("#mytable tbody").empty();

                    // Lặp qua dữ liệu từ API và tạo hàng mới cho mỗi mục
                    for (var i = 0; i < ketqua.products.length; i++) {
                        var product = ketqua.products[i];

                        var row = $("<tr></tr>");


                        $("<td></td>").text(product.id).appendTo(row);
                        $("<td></td>").text(product.email).appendTo(row);
                        $("<td></td>").text('Nhân viên').appendTo(row);
                        var actionsColumn = $("<td class='actions'></td>");

                        var route_delete = `${window.location.origin}/delete_users/` +  product.id;
                        var route_update = `${window.location.origin}/update_products` + product
                            .id;

                        var deleteLink = $("<a></a>").attr("href", route_delete)
                            .addClass("btn btn-danger")
                            .text("Xóa");

                        actionsColumn.append(deleteLink);

                        var editButton = $("<button></button>").addClass("btn btn-dark edit")
                            .val(product.id)
                            .text("Sửa")
                            .click(function() {
                                var value = $(this).val();
                                var route = `${window.location.origin}/update_users/` + value;

                                $.ajax({
                                    url: route,
                                    type: 'get',
                                    data: {
                                        id: value,
                                    }
                                }).done(function(ketqua) {
                                    $('#form').attr('method', 'get');
                                    $('#form').attr('action', '/edit_users/' + ketqua
                                        .products[0].id);
                                        $("#email").val(ketqua.products[0].email);
                                });
                                openModal();
                            });
                        actionsColumn.append(editButton);
                        row.append(actionsColumn);
                        $("#mytable tbody").append(row);
                    }
                });
                // console.log(value);

            });
            var route = `${window.location.origin}/api/nhanvien`;

            $.ajax({
                url: route,

            }).done(function(ketqua) {
                $("#mytable tbody").empty();

                // Lặp qua dữ liệu từ API và tạo hàng mới cho mỗi mục
                for (var i = 0; i < ketqua.products.length; i++) {
                    var product = ketqua.products[i];

                    var row = $("<tr></tr>");

                    $("<td></td>").text(product.id).appendTo(row);
                    $("<td></td>").text(product.email).appendTo(row);
                    $("<td></td>").text('Nhân viên').appendTo(row);

                    var actionsColumn = $("<td class='actions'></td>");

                    var route_delete = `${window.location.origin}/delete_users/` + product.id;
                    var route_update = `${window.location.origin}/update_products` + product.id;

                    var deleteLink = $("<a></a>").attr("href", route_delete)
                        .addClass("btn btn-danger")
                        .text("Xóa");

                    actionsColumn.append(deleteLink);

                    var editButton = $("<button></button>").addClass("btn btn-dark edit")
                        .val(product.id)
                        .text("Sửa")
                        .click(function() {
                            var value = $(this).val();
                            var route = `${window.location.origin}/update_users/` + value;

                            $.ajax({
                                url: route,
                                type: 'get',
                                data: {
                                    id: value,
                                }
                            }).done(function(ketqua) {
                                $('#form').attr('method', 'get');
                                $('#form').attr('action', '/edit_users/' + ketqua
                                    .products[0].id);
                                $("#email").val(ketqua.products[0].email);
                            });
                            openModal();
                        });

                    actionsColumn.append(editButton);

                    row.append(actionsColumn);

                    // Thêm hàng mới vào tbody
                    $("#mytable tbody").append(row);
                }
            });

        });

        var modal = document.getElementById("myModal");
        var btn = document.getElementsByTagName("button")[0];
        var span = document.getElementsByClassName("close")[0];

        function openModal() {
            modal.style.display = "block";
        }

        function closeModal() {
            $('#form').attr('method', 'post');
            $('#form').attr('action', 'add_employee');
            $("#name").val('');
            $("#quantity").val('');
            $("#price").val('');
            modal.style.display = "none";
        }
        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>

</html>
