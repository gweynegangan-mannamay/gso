<?php
// Start session safely
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ================= USER LOGIN =================
function check_userslogin($con) {
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE id = '$id' LIMIT 1";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
    }

    // Redirect if not logged in
    header("Location: log-out.php");
    die;
}

// ================= ADMIN LOGIN =================
function check_Adminlogin($con)
{
    if(isset($_SESSION['id']))
    {
        $id = $_SESSION['id'];

        $query = "SELECT * FROM admins WHERE id = '$id' LIMIT 1";
        $result = mysqli_query($con, $query);

        if($result && mysqli_num_rows($result) > 0)
        {
            return mysqli_fetch_assoc($result);
        }
    }

    // if not logged in
    header("Location: loginAdmin.php");
    exit;
}

// ================= RANDOM NUMBER =================
function random_num($length) {
    $text = "";

    if ($length < 5) {
        $length = 5;
    }

    $len = rand(4, $length);

    for ($i = 0; $i < $len; $i++) {
        $text .= rand(0, 9);
    }

    return $text;
}

// ================= TOTAL REQUEST =================
function get_total_request($con) {
    $sql = "SELECT COUNT(*) as total FROM trip_tickets";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return (int)$row['total'];
    }

    return 0;
}