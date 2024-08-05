<?php
require_once('../server/config.php');
if ($user->isUserLogin()) {
    header('Location: menu.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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

        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 0 15px;
        }

        .register-box {
            width: 100%;
            max-width: 500px;
            padding: 40px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .form-group label {
            color: #502404;
        }

        .form-control {
            border-radius: 5px;
            border: 1px solid #ddd;
            box-shadow: none;
            height: 45px;
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
            transition: color 0.3s ease;
        }

        .btn-link:hover {
            color: #e0693b;
        }

        .form-text {
            font-size: 0.9rem;
        }

        #responseMessage .alert {
            margin-top: 20px;
            font-size: 0.95rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="register-box">
            <h3 class="mb-4 text-center text-primary">สมัคร</h3>
            <form id="registerForm">
                <div class="form-group mb-3">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" placeholder="Enter name" required>
                </div>
                <div class="form-group mb-3">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </form>
            <div class="text-center mt-3">
                <a href="login.php" class="btn btn-link">Login</a>
                <a href="menu.php" class="btn btn-link">Menu</a>
            </div>
            <div id="responseMessage"></div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.getElementById('registerForm');
            const responseMessage = document.getElementById('responseMessage');

            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Prevent the form from submitting the default way

                const formData = new FormData(form);

                fetch('../server/register.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = 'login.php';
                        responseMessage.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                        form.reset(); // Clear the form
                    } else {
                        responseMessage.innerHTML = `<div class="alert alert-danger">${data.message}</div>`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    responseMessage.innerHTML = `<div class="alert alert-danger">An error occurred. Please try again later.</div>`;
                });
            });
        });
    </script>
</body>

</html>
