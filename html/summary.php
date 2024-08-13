<?php
    require_once('../server/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/summaryshop.css">
    <link rel="shortcut icon" href="../img/Logo-Shop-removebg-preview.png" type="image/x-icon">
    <title>Summary</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" />
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kanit:wght@200;400;700&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Kanit:wght@200;400;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kanit', sans-serif;
        }

        body {
            background-color: #fcf2d1;
            /* สีพื้นหลังอ่อน */
        }

        #preloader {
            background: #ffffff url(../img/Preload2.gif) no-repeat center center;
            height: 100vh;
            width: 100%;
            position: fixed;
            z-index: 100;
            opacity: 1;
            transition: opacity 1s ease-out;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #502404;
            /* สีน้ำตาล */
        }

        .table thead th {
            background-color: #92572d;
            /* สีน้ำตาล */
            color: white;
        }

        .table tbody tr:nth-child(even) {
            background-color: #dea58f;
        }

        .total-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #502404;
            /* สีน้ำตาล */
        }

        .btn {
            font-size: 1.2rem;
            margin: 5px;
            padding: 10px 20px;
            border: none;
            color: white;
        }

        .btn-order {
            background-color: #009216;
            /* สีเขียว */
        }

        .btn-clear,
        .btn-remove {
            background-color: #dd1203;
            /* สีแดง */
        }

        .btn-back {
            background-color: #787878;
            /* สีน้ำตาล */
        }

        footer {
            margin-top: 50px;
            padding: 10px 0;
            background-color: #502404;
            /* สีน้ำตาล */
            color: white;
            text-align: center;
        }

    </style>
</head>

<body class="bg-light">
    <div id="preloader"></div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">
                <img src="../img/Logo-Shop-removebg-preview.png" alt="" width="30" height="24" class="d-inline-block align-text-top">
                สี่สหายโบราณคลาสสิค
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">หน้าหลัก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../html/menu.php">เมนู</a>
                    </li>

                    <li class="nav-item">
                    <a class="nav-link fs-4 active" href="./about.php"><i class='bx bx-phone'></i>ติดต่อ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">เกี่ยวกับเรา</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../html/summary.php">สรุปการสั่งซื้อ</a>
                    </li>
                    <?php if($_SESSION['UserID'] == '123456'): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../html/login.php">เข้าสู่ระบบ</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="./logout.php">ออกจากระบบ</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#">สวัสดี, <?php echo $_SESSION['UserID']; ?></a>
                    </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h2>สรุปการสั่งซื้อ</h2>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">รหัสสินค้า</th>
                        <th scope="col">ชื่อสินค้า</th>
                        <th scope="col">ราคา</th>
                        <th scope="col">จำนวน</th>
                        <th scope="col">ราคารวม</th>
                        <th scope="col">ลบ</th>
                    </tr>
                </thead>
                <tbody id="basket-list">
                    <!-- รายการอาหารในตะกร้าจะถูกเพิ่มที่นี่ -->
                </tbody>
            </table>
        </div>
        <div class="text-end">
            <h4 class="total-price">รวมทั้งหมด: <span id="total-price">0</span> บาท</h4>
        </div>
        <?php if(!($_SESSION['UserID'] == '123456')): ?>
        <div class="text-center mt-4">
            <button class="btn btn-order" onclick="confirmOrder()">สั่งอาหาร</button>
            <button class="btn btn-clear" onclick="clearBasket()">ล้างรายการอาหาร</button>
            <button class="btn btn-back" onclick="goBack()">ย้อนกลับ</button>
        </div>
        <?php else: ?>
        <div class="text-center mt-4">
            <button class="btn btn-order" onclick="confirmOrder()" disabled>กรุณาล็อกอิน</button>
            <button class="btn btn-clear" onclick="clearBasket()">ล้างรายการอาหาร</button>
            <button class="btn btn-back" onclick="goBack()">ย้อนกลับ</button>
        </div>
        <?php endif; ?>
    </div>

    <footer style="background-color: #acacac; padding: 20px; text-align: center; border-top: 1px solid #e7e7e7; position: fixed; bottom: 0; width: 100%;">
        <p style="margin: 0; font-family: 'Arial', sans-serif; color: #333;">© 2024 สี่สหายโบราณคลาสสิค, Inc</p>
    </footer>
    

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/summaryshop.js"></script>
    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>

</html>
