<?php require_once '../../../server/config.php';

?>

<!DOCTYPE html>
<html lang="en"> <!--begin::Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>WU Freshy Awards</title><!--begin::Primary Meta Tags-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="title" content="WU Freshy Awards">
    <meta name="author" content="ColorlibHQ">
    <meta name="description" content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS.">
    <meta name="keywords" content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"><!--end::Primary Meta Tags--><!--begin::Fonts-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q=" crossorigin="anonymous"><!--end::Fonts--><!--begin::Third Party Plugin(OverlayScrollbars)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous"><!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Third Party Plugin(Bootstrap Icons)-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous"><!--end::Third Party Plugin(Bootstrap Icons)--><!--begin::Required Plugin(AdminLTE)-->
    <link rel="stylesheet" href="../../dist/css/adminlte.css"><!--end::Required Plugin(AdminLTE)--><!-- apexcharts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.css" integrity="sha256-4MX+61mt9NVvvuPjUWdUdyfZfxSB1/Rf9WtqRHgG5S0=" crossorigin="anonymous"><!-- jsvectormap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/css/jsvectormap.min.css" integrity="sha256-+uGLJmmTKOqBr+2E6KDYs/NRsHxSkONXFHUL0fy2O/4=" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="./components/sidebar.css"> -->
    <style>
        thead th span.icon-arrow {
            display: inline-block;
            width: 1.3rem;
            height: 1.3rem;
            border-radius: 50%;
            border: 1.4px solid transparent;

            text-align: center;
            font-size: 1rem;

            margin-left: .5rem;
            transition: .2s ease-in-out;
        }

        thead th:hover span.icon-arrow {
            border: 1.4px solid #f1f1f1;
        }

        thead th:hover {
            color: #f1f1f1;
        }

        thead th.active span.icon-arrow {
            color: #f1f1f1;
        }

        thead th.asc span.icon-arrow {
            transform: rotate(180deg);
        }

        thead th.active,
        tbody td.active {
            color: #f1f1f1;
        }
    </style>
</head> <!--end::Head--> <!--begin::Body-->

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary"> <!--begin::App Wrapper-->
    <div class="app-wrapper"> <!--begin::Header-->
        <?php require('./components/navbar.php') ?>
        <?php require('./components/sidebar.php') ?>
        <main class="app-main"> <!--begin::App Content Header-->

            <div class="container mt-4">
                <h3>Candidate Summary</h3>
                <div class="mt-4">
                    <h5>นักศึกษาทั้งหมด: <span id="total-students"></span> คน</h5>
                    <h5>นักศึกษาที่ทำการโหวตไปแล้วมีทั้งหมด: <span id="total-student-vote"></span> คน</h5>
                    <h5>นักศึกษาที่ยังไม่ได้โหวตมีทั้งหมด: <span id="total-student-notvote"></span> คน</h5>
                </div>
                <form class="form-inline mb-3" method="get" id="search-form">
                    <div class="form-group">
                        <input type="search" name="search" class="form-control mb-4" placeholder="Search..." id="search_user">
                        <!--Male Female LGBTQ btn select-->
                        <div class="btn-group ml-2" role="group" aria-label="Basic radio toggle button group">
                            <input type="radio" class="btn-check" name="gender" id="btnradio1" value="Male" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio1">Male</label>
                            <input type="radio" class="btn-check" name="gender" id="btnradio2" value="Female" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio2">Female</label>
                            <input type="radio" class="btn-check" name="gender" id="btnradio3" value="LGBTQ" autocomplete="off">
                            <label class="btn btn-outline-primary" for="btnradio3">LGBTQ</label>
                            <input type="radio" class="btn-check" name="gender" id="btnradio4" value="All" autocomplete="off" checked>
                            <label class="btn btn-outline-primary" for="btnradio4">All</label>
                        </div>
                        <button type="submit" class="btn btn-primary ml-2">Search</button>
                    </div>
                </form>

                <table class="table table-dark table-striped table-sortable" id="candidate-summary-table">
                    <thead>
                        <tr>
                            <th class="text-center" data-sort="STUDENTID">STUDENTID <span class="icon-arrow">&#9650;</span></th>
                            <th class="text-center" data-sort="STUDENTNAME">Candidate <span class="icon-arrow">&#9650;</span></th>
                            <th class="text-center" data-sort="STUDENTGENDER">Gender<span class="icon-arrow">&#9650;</span></th>
                            <th class="text-center" data-sort="Votes">Votes <span class="icon-arrow">&#9650;</span></th>
                        </tr>
                    </thead>
                    <tbody id="show-list" class="table"></tbody>
                </table>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script>
            <script>
                const populateTable = (candidates, candidateVotes) => {
                    const tbody = document.getElementById('show-list');
                    tbody.innerHTML = '';

                    candidates.forEach(candidate => {
                        const candidateID = candidate.STUDENTID;
                        const candidateName = (candidate.STUDENTNAME + " " + candidate.STUDENTSURNAME) || 'N/A';
                        const candidateGender = candidate.STUDENTGENDER || 'N/A';
                        const votes = candidateVotes[candidateID]?.Votes || 0;

                        const row = `
                            <tr>
                                <td class="text-center">${candidateID}</td>
                                <td>${candidateName}</td>
                                <td class="text-center">${candidateGender}</td>
                                <td class="text-center" id="votes-${candidateID}">${votes}</td>
                            </tr>
                        `;
                        tbody.innerHTML += row;
                    });
                };

                const fetchData = (query = '', gender = '', sortField = '', order = '') => {
                    let url = `helper/count.php?search=${query}&gender=${gender}`;
                    if (sortField && order) {
                        console.log(sortField, order);
                        url += `&sortField=${sortField}&order=${order}`;
                    }
                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            populateTable(data.candidates, data.candidateVotes);
                            document.getElementById('total-students').innerText = data.totalStudents;
                            document.getElementById('total-student-vote').innerText = data.totalVotes;
                            document.getElementById('total-student-notvote').innerText = data.totalStudents - data.totalVotes;
                        })
                        .catch(error => console.error('Error fetching data:', error));
                };

                document.addEventListener('DOMContentLoaded', () => {
                    fetchData();

                    document.querySelectorAll('.table-sortable th[data-sort]').forEach(header => {
                        header.addEventListener('click', () => {
                            const sortField = header.getAttribute('data-sort');
                            const order = header.classList.contains('asc') ? 'desc' : 'asc';
                            document.querySelectorAll('.table-sortable th').forEach(th => th.classList.remove('asc', 'desc', 'active'));
                            header.classList.add(order, 'active');

                            fetchData(
                                document.getElementById('search_user').value,
                                document.querySelector('input[name="gender"]:checked').value,
                                sortField,
                                order
                            );
                        });
                    });
                });
            </script>
        </main>
        <?php require('./components/footer.php') ?>
    </div> <!--end::App Wrapper--> <!--begin::Script--> <!--begin::Third Party Plugin(OverlayScrollbars)-->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script> <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script> <!--end::Required Plugin(popperjs for Bootstrap 5)--><!--begin::Required Plugin(Bootstrap 5)-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script> <!--end::Required Plugin(Bootstrap 5)--><!--begin::Required Plugin(AdminLTE)-->
    <script src="../../dist/js/adminlte.js"></script> <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js" integrity="sha256-ipiJrswvAR4VAx/th+6zWsdeYmVae0iJuiR+6OqHJHQ=" crossorigin="anonymous"></script> <!-- sortablejs -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.37.1/dist/apexcharts.min.js" integrity="sha256-+vh8GkaU7C9/wbSLIcwq82tQ2wTf44aOHA8HlBMwRI8=" crossorigin="anonymous"></script> <!-- ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js" integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js" integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY=" crossorigin="anonymous"></script> <!-- jsvectormap -->
</body><!--end::Body-->

</html>