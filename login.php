<?php
session_start();
include("db_connection.php");
include("function.php");

$error = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
    $password = $_POST['password'];

    if(!empty($user_name) && !empty($password)){
        $query = "SELECT * FROM users WHERE user_name = '$user_name' LIMIT 1";
        $result = mysqli_query($con, $query);

        if($result && mysqli_num_rows($result) > 0){
            $user_data = mysqli_fetch_assoc($result);

            // Note: In production, use password_verify() with hashed passwords
            if($user_data['password'] === $password){
                $_SESSION['user_id'] = $user_data['user_id'];
                header("Location: index.php"); // Redirect to your dashboard
                exit();
            } else {
                $error = "Wrong password!";
            }
        } else {
            $error = "User not found!";
        }
    } else {
        $error = "Please fill all fields!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>  
    <title>Login</title>
    <style>
        body { margin: 0; height: 100vh; display: flex; justify-content: center; align-items: center; background: url('pictures/BG-ISU.C.jpg') no-repeat center center/cover; font-family: Arial, sans-serif; }
        .box { background: #05680a; padding: 30px; width: 300px; border-radius: 10px; text-align: center; color: white; }
        .input { width: 100%; padding: 10px; margin-top: 10px; border: none; border-radius: 5px; box-sizing: border-box; }
        .btn { width: 100%; padding: 10px; margin-top: 15px; background: #3b82f6; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .btn:hover { background: #2563eb; }
        .error-msg { color: #f87171; font-size: 14px; margin-top: 10px; }
        .logo {width: 80px;    height: 80px;   object-fit: contain;    margin-bottom: 10px;}
    </style>
</head>
<body>
<div class="box">
    <form method="post">
        <img src="pictures/isu-logo.png" alt="Logo" class="logo">
        <h2>Login</h2>
        <?php if($error != ""): ?>
            <div class="error-msg"><?php echo $error; ?></div>
        <?php endif; ?>
        <input class="input" type="text" name="user_name" placeholder="Username" required>
        <input class="input" type="password" name="password" placeholder="Password" required>
        <input class="btn" type="submit" value="Login">
        <p style="margin-top:15px; font-size:14px;">
            Don't have an account? <a href="signup.php" style="color:#3b82f6;">Signup</a>
        </p>
    </form>
</div>
</body>
</html>