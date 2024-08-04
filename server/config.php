<?php

class Database
{
    private $host = "localhost";
    private $user = "root";
    private $password = "vA-Me.@2686019363&NW";
    private $database = "html-boostrap5-shop";
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

    public function candidate()
    {
        if ($_SESSION['Status'] == 'candidate') {
            header('Location: ./');
            exit();
        }
    }

    public function hasVoted()
    {
        $sql = "SELECT SelectCandidateAlready FROM student2 WHERE STUDENTID = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION['UserID']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['SelectCandidateAlready'];
    }

    public function voted($gender)
    {
        $stmt = $this->conn->prepare("SELECT STUDENTMALE, STUDENTFEMALE, STUDENTLGBTQ FROM student_votepopular WHERE STUDENTID = ?");
        $stmt->bind_param("s", $_SESSION['UserID']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();

        if ($gender == 'Male') {
            return isset($row['STUDENTMALE']);
        } else if ($gender == 'Female') {
            return isset($row['STUDENTFEMALE']);
        } else if ($gender == 'LGBTQ') {
            return isset($row['STUDENTLGBTQ']);
        } else {
            return false;
        }
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

class TimeVote
{
    private $startDate = "2024-08-17";
    private $endDate = "2024-08-17";
    private $startTime = "18:00:00";
    private $endTime = "19:00:00";

    public function timeOpen()
    {
        $currentDate = date("Y-m-d");
        $currentTime = date("H:i:s");

        $startDate = new DateTime($this->startDate);
        $today = new DateTime($currentDate);
        $interval = $startDate->diff($today);
        $daysDiff = $interval->days;

        if (isset($_SESSION['Status']) && $_SESSION['Status'] !== 'admin' && $_SESSION['Status'] !== 'co_admin') {
            if ($daysDiff >= 0 && $daysDiff <= 14) {
                if ($currentDate === $this->startDate || ($currentDate === $this->endDate && $currentTime <= $this->endTime)) {
                    if ($currentDate === $this->endDate && $currentTime >= $this->startTime) {
                        if ($currentTime < $this->startTime || $currentTime > $this->endTime) {
                            header("Location: ./events/Time_Out.php");
                            exit();
                        }
                    }
                } else {
                    header("Location: ./events/Not_Yet.php");
                    exit();
                }
            } else {
                header("Location: ./events/Not_Yet.php");
                exit();
            }
        }
    }
}

$db = new Database();
$conn = $db->getConnection();
$user = new User($conn);
$admin = new Admin($conn);
$time = new TimeVote();

if (isset($err)) {
    $err = true;
}

function err()
{
    header("Location: ./events/Error404.php");
    exit();
}

// if (!$condition) {
//     err();
// }
