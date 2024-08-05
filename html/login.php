<?php
    require_once '../server/config.php';
    if($user->isUserLogin()){
        header('Location: menu.php');
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant | Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kanit:wght@200;400;700&display=swap">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="shortcut icon" href="../img/Logo-Shop-removebg-preview.png" type="image/x-icon">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Kanit', sans-serif;
            background: linear-gradient(to right, #ffecd2, #fcb69f);
        }

        .login-page {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        .login-box {
            width: 360px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .login-logo a {
            color: #502404;
            font-size: 2.5rem;
            text-decoration: none;
            font-weight: bold;
            margin-bottom: 20px;
            display: inline-block;
        }

        .card {
            border: none;
            box-shadow: none;
        }

        .btn-primary {
            background-color: #ff7f50;
            border-color: #ff7f50;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #e0693b;
            border-color: #e0693b;
        }

        .btn-link {
            color: #502404;
            text-decoration: underline;
        }

        .btn-link:hover {
            color: #e0693b;
        }

        .input-group-text {
            background-color: transparent;
            border: none;
        }

        .form-control {
            height: 45px;
            border-radius: 5px;
            border: 1px solid #ddd;
            box-shadow: none;
        }

        .input-group-text span {
            font-size: 1.5rem;
            color: #502404;
        }

        .login-card-body {
            padding: 20px;
        }

        .login-box-msg {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #502404;
        }

        .register-link {
            color: #ff7f50;
            font-weight: bold;
            transition: color 0.3s ease;
            text-decoration: none;
        }

        .register-link:hover {
            color: #e0693b;
            text-decoration: underline;
        }

    </style>
</head>

<body class="login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Sign in </b>Restaurant</a>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Please sign in สหาย</p>
                <form id="loginForm">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="id" placeholder="Name" required>
                        <div class="input-group-text"> <span class="bi bi-people"></span> </div>

                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                        <div class="input-group-text"> <span class="bi bi-lock-fill"></span> </div>
                    </div>
                    <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
                </form>
                <div class="mt-3">
                    <a href="register.php" class="register-link">Register</a>
                    <a href="menu.php" class="btn btn-link">Menu</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('loginForm');

            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the form from submitting the default way

                const formData = new FormData(form);

                fetch('../server/fetch_login.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = 'menu.php'; // Redirect on success
                        } else {
                            alert(data.message); // Show error message
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>
</body>

</html>
