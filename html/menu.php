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
    <div id="preloader"></div>
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
                            <a class="nav-link fs-4 active" href="#"><i class="bx bx-book-open"></i>เกี่ยวกับ</a>
                        </li>
                        <?php if($_SESSION['Status'] == 'GUEST'): ?>
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

        <nav class="navbar navbar-expand-lg bg-body-tertiary d-flex bg-session nav-bg-blue">
            <div class="container-fluid">
                <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item mx-4">
                            <a class="nav-link active text-white fs-4" aria-current="page" href="#"
                                onclick="showCategory('food')">อาหารหลัก</a>
                        </li>
                        <li class="nav-item mx-4">
                            <a class="nav-link active text-white fs-4 active" href="#"
                                onclick="showCategory('water')">เครื่องดื่ม</a>
                        </li>
                        <li class="nav-item mx-4">
                            <a class="nav-link active text-white fs-4 active" href="#"
                                onclick="showCategory('dessert')">ของหวาน</a>
                        </li>
                        <li class="nav-item mx-4">
                            <a class="nav-link active" href="#"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>        
    </div>

    <div class="cart-container" onclick="goToSummary()">
        <i class='bx bx-cart cart-icon'></i>
        <span id="cart-count" class="cart-count">0</span>
    </div>

    <div class="container mt-4">
        <h1 class="text-left text-section">
            <strong><a href="#" class="btn-shine">Gourmet Dining Selections</a>
            </strong>
        </h1>

        <div class="category" id="food" style="display: block;">
            <h2>อาหารหลัก</h2>
            <div class="row" style="margin-top: 45px;"></div>
        </div>
        
        <div class="category" id="water" style="display: none;">
            <h2>เครื่องดื่ม</h2>
            <div class="row" style="margin-top: 45px;"></div>
        </div>
        
        <div class="category" id="dessert" style="display: none;">
            <h2>ของหวาน</h2>
            <div class="row" style="margin-top: 45px;"></div>
        </div>
        

    </div>

    <footer class="bg-body-tertiary text-center p-3 mt-5">
        <p>©2024 ไอ้พีท</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/bootstrap.bundle.js"></script>
    <script src="../js/menu.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script>
        function showCategory(category) {
            document.querySelectorAll('.category').forEach(function (el) {
                console.log(el);
                el.style.display = 'none';
            });
            document.getElementById(category).style.display = 'block';
        }
        document.addEventListener('DOMContentLoaded', function () {
            fetchLists();
            showCategory('food');
        });

        let lists = {
            food: [],
            water: [],
            dessert: []
        };

        const populateCategory = (category) => {
            const container = document.getElementById(category);
            const categoryData = lists[category];

            console.log(categoryData);

            container.querySelector('.row').innerHTML = '';

            categoryData.forEach(item => {
                const card = `
            <div class="col-md-4 mt-4">
                <div class="card" style="width: 24rem;">
                    <img src="../img/list/${item.image}" class="card-img-top" alt="${item.name}">
                    <div class="card-body">
                        <h5 class="card-title text-center">${item.name}</h5>
                        <p class="card-text text-center">ราคา ${item.price} บาท</p>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-danger" onclick="decrementQuantity('${item.name}', ${item.price})">-</button>
                            <span id="${item.name}-quantity">0</span>
                            <button class="btn btn-success" onclick="incrementQuantity('${item.name}', ${item.price})">+</button>
                        </div>
                        <button class="btn btn-primary mt-2" id="button"
                            onclick="confirmAddToBasket('${item.name}', ${item.price})">
                            <span class="text">สั่งซื้อ</span><span>ขอบคุณ</span>
                        </button>
                    </div>
                </div>
            </div>
        `;
                container.querySelector('.row').innerHTML += card;
            });
        };

        const fetchLists = async () => {
            try {
                const response = await fetch('../server/list.php');
                console.log(response);
                lists = await response.json();
                populateCategory('food');
                populateCategory('water');
                populateCategory('dessert');
            } catch (error) {
                console.error("Error fetching data: ", error);
            }
        };

    </script>
    <script src="../js/view.js"></script>

</body>

</html>