<?php
require_once '../../../server/config.php';

if (!$admin->isAdmin()) {
    header('location: ./login.php');
    exit();
}

// Fetch the count of new orders (status = 'รอยืนยัน')
$newOrdersStmt = $conn->prepare("SELECT COUNT(*) FROM summary WHERE status = 'รอยืนยัน'");
$newOrdersStmt->execute();
$newOrdersStmt->bind_result($newOrdersCount);
$newOrdersStmt->fetch();
$newOrdersStmt->close();

// Fetch Online Store Visitors
$visitorStmt = $conn->prepare("SELECT data FROM about_us WHERE id = 100");
$visitorStmt->execute();
$visitorStmt->bind_result($visitorData);
$visitorStmt->fetch();
$visitorStmt->close();

// Fetch Sales Data
$salesStmt = $conn->prepare("
    SELECT DATE_FORMAT(date, '%Y-%m') AS month, SUM(price * amount) AS revenue
    FROM summary
    GROUP BY month
");
$salesStmt->execute();
$salesStmt->store_result();
$salesStmt->bind_result($month, $revenue);

$salesData = [];
while ($salesStmt->fetch()) {
    $salesData[] = [
        'month' => htmlspecialchars($month),
        'revenue' => htmlspecialchars($revenue)
    ];
}
$salesStmt->close();

// Fetch Products
$productStmt = $conn->prepare("
    SELECT `name`, price, SUM(amount) AS total_amount
    FROM summary
    GROUP BY `name`, price
    ORDER BY total_amount DESC
");
$productStmt->execute();
$productStmt->store_result();
$productStmt->bind_result($productName, $productPrice, $productTotalAmount);

$products = [];
while ($productStmt->fetch()) {
    $products[] = [
        'name' => htmlspecialchars($productName),
        'price' => htmlspecialchars($productPrice),
        'total_amount' => htmlspecialchars($productTotalAmount),
        'total_sales' => htmlspecialchars($productPrice * $productTotalAmount)
    ];
}
$productStmt->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <?php require('./components/head.php') ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css">

</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <div class="app-wrapper">
        <?php require('./components/navbar.php') ?>
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark"> <!--begin::Sidebar Brand-->
            <div class="sidebar-brand"> <!--begin::Brand Link--> <a href="./index.php" class="brand-link"> <!--begin::Brand Image-->
                    <!-- <img src="#" alt="#" class="brand-image opacity-75 shadow">  -->
                    <!--end::Brand Image--> <!--begin::Brand Text-->
                    <span class="brand-text fw-light">Restaurant</span> <!--end::Brand Text--> </a> <!--end::Brand Link--> </div> <!--end::Sidebar Brand--> <!--begin::Sidebar Wrapper-->
            <div class="sidebar-wrapper">
                <nav class="mt-2"> <!--begin::Sidebar Menu-->
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                        <li class="nav-item menu-open"> <a href="#" class="nav-link active"> <i class="nav-icon bi bi-clipboard-fill"></i>
                                <p class="text-gold">
                                    List
                                    <span class="nav-badge badge text-bg-secondary me-3">2</span>
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="./index.php" class="nav-link active"> <i class="nav-icon bi bi-circle"></i>
                                        <p class="text-gold">Dashboard</p>
                                    </a>
                                </li>
                                <li class="nav-item"> <a href="./index2.php" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p class="text-gold">Status</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item"> <a href="#" class="nav-link"> <i class="nav-icon bi bi-pencil-square"></i>
                                <p class="text-gold">
                                    Editors
                                    <i class="nav-arrow bi bi-chevron-right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item"> <a href="./edit_menu.php" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                        <p class="text-gold">Menu</p>
                                    </a> </li>
                            </ul>
                        </li>
                        <!-- member register-->
                        <li class="nav-item"> <a href="./register.php" class="nav-link"> <i class="nav-icon bi bi-person-plus"></i>
                                <p class="text-gold">
                                    Register
                                </p>
                            </a>
                        </li>
                        <li class="nav-item"> <a href="./Logout.php" class="nav-link"> <i class="nav-icon bi bi-box-arrow-in-right"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    </ul> <!--end::Sidebar Menu-->
                </nav>
            </div> <!--end::Sidebar Wrapper-->
        </aside> <!--end::Sidebar--> <!--begin::App Main-->
        <main class="app-main">
            <!-- Existing content -->
            <div class="app-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- New Orders -->
                            <div class="small-box text-bg-primary">
                                <div class="inner">
                                    <h3><?php echo htmlspecialchars($newOrdersCount); ?></h3>
                                    <p>New Orders</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"></path>
                                </svg>
                                <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                    More info <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                            <!-- Online Store Visitors -->
                            <div class="small-box text-bg-danger">
                                <div class="inner">
                                    <h3><?php echo htmlspecialchars($visitorData); ?></h3>
                                    <p>Unique Visitors</p>
                                </div>
                                <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"></path>
                                    <path clip-rule="evenodd" fill-rule="evenodd" d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"></path>
                                </svg>
                                <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                                    More info <i class="bi bi-link-45deg"></i>
                                </a>
                            </div>
                        </div>
                        <!-- Products -->
                        <div class="col-lg-12">
                            <div class="card mb-4">
                                <div class="card-header border-0">
                                    <h3 class="card-title">Products</h3>
                                </div>
                                <div class="card-body table-responsive p-0">
                                    <table class="table table-striped align-middle">
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th>Total Sales</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($products as $product) : ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                                    <td><?php echo htmlspecialchars($product['price']); ?></td>
                                                    <td><?php echo htmlspecialchars($product['total_sales']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <?php require('./components/footer.php') ?>
    </div>

    <?php require('./components/scripts.php') ?>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        const salesData = <?php echo json_encode($salesData); ?>;
        const sales_chart_options = {
            series: [{
                name: "Revenue",
                data: salesData.map(item => item.revenue),
            }],
            chart: {
                type: "bar",
                height: 200,
            },
            xaxis: {
                categories: salesData.map(item => item.month),
            },
        };

        const sales_chart = new ApexCharts(
            document.querySelector("#sales-chart"),
            sales_chart_options
        );
        sales_chart.render();
    </script>
</body>

</html>