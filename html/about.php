<?php
require_once('../server/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kanit:wght@200;400;700&display=swap">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="../img/Logo-Shop-removebg-preview.png" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body,
        html {
            font-family: 'Kanit', sans-serif !important;
            background-color: #F5DEB3 !important;
        }

        .card-title {
            font-size: 30px;
            font-weight: bold;
            text-align: center;
        }

        li{
            font-size: 24px;
        }

        .bg-session {
            background-color: #3c77b2 !important;
        }

        .bg-body-tertiary {
            background-color: #f8f9fa !important;
        }

        .navbar {
            background-color: #ffffff !important;
        }

        .navbar-brand {
            font-size: 1.5rem;
        }

        .nav-bg,
        .nav-bg-blue {
            background-color: #70350b !important;
        }

        .nav-item {
            margin: 0 1px;
        }

        .nav-item:hover {
            border-bottom: 2px solid #ffffff;
        }

        .text-section {
            border-left: 10px solid #c4842f;
            border-radius: 12PX;
            padding-left: 10px;
            font-size: 60px;
        }

        .cart-container {
            position: absolute;
            top: 20px;
            right: 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .cart-icon {
            font-size: 2rem;
            color: #ffffff;
        }

        .cart-count {
            background-color: red;
            color: #ffffff;
            border-radius: 50%;
            padding: 0 10px;
            margin-left: 5px;
            font-size: 1rem;
        }

        .card img {
            height: 200px;
            object-fit: cover;
        }

        .category {
            margin-top: 3rem;
        }

        .category h2 {
            font-size: 2rem;
            font-weight: bold;
            color: #c4842f;
        }

        #button {
            position: relative;
            overflow: hidden;
            border: 1px solid #18181a;
            color: #18181a;
            display: inline-block;
            width: 100%;
            font-size: 15px;
            line-height: px;
            padding: 18px 18px 17px;
            text-decoration: none;
            cursor: pointer;
            background: #ffffff;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
        }

        #button span:first-child {
            position: relative;
            transition: color 600ms cubic-bezier(0.48, 0, 0.12, 1);
            z-index: 10;
        }

        #button span:last-child {
            color: white;
            display: block;
            position: absolute;
            bottom: 0;
            transition: all 500ms cubic-bezier(0.48, 0, 0.12, 1);
            z-index: 100;
            opacity: 0;
            top: 50%;
            left: 50%;
            transform: translateY(225%) translateX(-50%);
            height: 14px;
            line-height: 13px;
        }

        #button:after {
            content: "";
            position: absolute;
            bottom: -50%;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: black;
            transform-origin: bottom center;
            transition: transform 600ms cubic-bezier(0.48, 0, 0.12, 1);
            transform: skewY(9.3deg) scaleY(0);
            z-index: 50;
        }

        #button:hover:after {
            transform-origin: bottom center;
            transform: skewY(9.3deg) scaleY(2);
        }

        #button:hover span:last-child {
            transform: translateX(-50%) translateY(-50%);
            opacity: 1;
            transition: all 900ms cubic-bezier(0.48, 0, 0.12, 1);
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

        /* From Uiverse.io by neerajbaniwal */
        .btn-shine {
            transform: translate(-50%, -50%);
            padding: 12px 48px;
            color: #6c016c;
            background: linear-gradient(to right, #875e00 0, #d37800 10%, #723400 20%);
            background-size: 200%;
            background-position: -100%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: shine 4s infinite linear;
            animation-fill-mode: forwards;
            -webkit-text-size-adjust: none;

            text-decoration: none;
            white-space: nowrap;
            font-family: "Poppins", sans-serif;
        }

        @-moz-keyframes shine {
            0% {
                background-position: 100%;
            }

            100% {
                background-position: -100%;
            }
        }

        @-webkit-keyframes shine {
            0% {
                background-position: 100%;
            }


            100% {
                background-position: -100%;
            }
        }

        @-o-keyframes shine {
            0% {
                background-position: 100%;
            }

            100% {
                background-position: -100%;
            }
        }

        @keyframes shine {
            0% {
                background-position: 100%;
            }

            100% {
                background-position: -100%;
            }
        }
    </style>
</head>

<body>
    <div class="nav-bg">
        <nav class="navbar navbar-expand-lg bg-body-tertiary d-flex border-bottom"
            style="margin: 0 260px; border-radius: 0 0 10px 10px;">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <h1>หกสหายสายโบราณ</h1>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link fs-4 active" aria-current="page" href="../index.html"><i
                                    class="bi bi-house-door"></i>หน้าหลัก</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-4 active" href="./about.php"><i class='bx bx-phone'></i>ติดต่อ</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-4 active" href="#"><i class="bx bx-book-open"></i>ติดต่อเรา</a>
                        </li>
                        <?php if ($_SESSION['Status'] == 'GUEST'): ?>
                            <li class="nav-item">
                                <a class="nav-link fs-4 active" href="../html/login.php"><i class="bi bi-box-arrow-in-right"></i>เข้าสู่ระบบ</a>
                            </li>
                        <?php else: ?>
                            <li class="nav-item">
                                <a class="nav-link fs-4 active" href="./logout.php"><i class="bi bi-box-arrow-right"></i>ออกจากระบบ</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="text-section">
                    ติดต่อ
                </div>
            </div>
            <div>
                <div class="col-12">
                    <div class="card mt-5">
                        <div class="card-body">
                            <h5 class="card-title"> จัดทำโดย</h5>
                                <ol>
                                    <li>นายธนพัทธ์  เขตรัตนา   66127234</li>
                                    <li>นายจิรัฏฐ์    มุณีกาญจน์ 66130444</li>
                                    <li>นายทชานน   ศรีสุข    66131103</li>
                                    <li>นายธีรภัทร์   จงจิตร    66131319</li>
                                    <li>นายอัษฎาวุฒิ นาคทุ่งเตา 66133505</li>
                                    <li>นายชนสรณ์   หนูแก้ว   66134172</li>
                                </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</body>

</html>