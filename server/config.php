<?php

class Database
{
    private $host = "localhost";
    private $user = "sabwunet_html5";
    private $password = "vA-Me.@2686019363";
    private $database = "sabwunet_html5";
    private $conn;

    public function __construct()
    {
        $this->connect();
        $this->setCharset("utf8");
        $this->setTimezone("Asia/Bangkok");
        $this->startSession();
    }

    private function connect()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    private function setCharset($charset)
    {
        $this->conn->set_charset($charset);
    }

    private function setTimezone($timezone)
    {
        date_default_timezone_set($timezone);
    }

    private function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $this->setCookie();
        $this->checkTimeout();

        if (!(isset($_SESSION['UserID']) && isset($_SESSION['Status']))) {
            $_SESSION['UserID'] = 123456;
            $_SESSION['Status'] = 'GUEST';
            session_write_close();
        }
    }

    private function setCookie()
    {
        if (!isset($_COOKIE['UserID']) || !isset($_COOKIE['Status'])) {
            setcookie("UserID", $_SESSION['UserID'], time() + (86400 * 30), "/");
            setcookie("Status", $_SESSION['Status'], time() + (86400 * 30), "/");
        }
    }

    private function checkTimeout()
    {
        $timeout_duration = 600;
        if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
            session_unset();
            session_destroy();
            session_start();
            $_SESSION['UserID'] = 123456;
            $_SESSION['Status'] = 'GUEST';
        }
        $_SESSION['LAST_ACTIVITY'] = time();
    }

    public function getConnection()
    {
        return $this->conn;
    }
}

class User
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function isLogin()
    {
        if (!($_SESSION['Status'] == 'admin' || $_SESSION['Status'] == 'user' || $_SESSION['Status'] == 'co-admin')) {
            header('Location: ./login.php');
            exit();
        }
    }

    public function isUserLogin()
    {
        return $_SESSION['Status'] == 'user' || $_SESSION['Status'] == 'co-admin' || $_SESSION['Status'] == 'admin';
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        setcookie("UserID", "", time() - 3600, "/");
        setcookie("Status", "", time() - 3600, "/");

        session_start();
        $_SESSION['UserID'] = 123456;
        $_SESSION['Status'] = 'GUEST';
        session_write_close();

        header('Location: ./login.php');
        exit();
    }

    public function view() {
        $stmt = $this->conn->prepare("UPDATE about_us SET `data` = `data` + 1 WHERE `id` = ?");
        $id = 100;
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->close();
    }
    
}

class Admin
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function adminLogin()
    {
        if (!($_SESSION['Status'] == 'admin' || $_SESSION['Status'] == 'co-admin')) {
            header('Location: ../../../login.php');
            exit();
        }
    }

    public function isAdminLogin()
    {
        return $_SESSION['Status'] == 'admin' || $_SESSION['Status'] == 'co-admin';
    }

    public function adminLogout()
    {
        session_unset();
        session_destroy();

        setcookie("UserID", "", time() - 3600, "/");
        setcookie("Status", "", time() - 3600, "/");

        session_start();
        $_SESSION['UserID'] = 123456;
        $_SESSION['Status'] = 'GUEST';
        session_write_close();

        header('Location: ../../../login.php');
        exit();
    }

    public function isAdmin()
    {
        return $_SESSION['Status'] == 'admin';
    }

    public function isCoAdmin()
    {
        return $_SESSION['Status'] == 'co-admin';
    }

    public function isCoAdminOrAdmin()
    {
        return $_SESSION['Status'] == 'co-admin' || $_SESSION['Status'] == 'admin';
    }
}



$db = new Database();
$conn = $db->getConnection();
$user = new User($conn);
$admin = new Admin($conn);

// if (!$condition) {
//     err();
// }
