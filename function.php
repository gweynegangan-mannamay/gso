<?php
// Start session here so it's available everywhere functions are used
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function check_login($con) {
    if (isset($_SESSION['user_id'])) {
        $id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE user_id = '$id' LIMIT 1";
        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        }
    }
    // Redirect if not logged in
    header("Location: login.php");
    die;
}

function random_num($length) {
    $text = "";
    if ($length < 5) { $length = 5; }
    $len = rand(4, $length);
    for ($i = 0; $i < $len; $i++) {
        $text .= rand(0, 9);
    }
    return $text;
}

function get_total_request($con) {
    $sql = "SELECT COUNT(*) as total FROM trip_tickets";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return (int)$row['total'];
    }
    return 0;
}

