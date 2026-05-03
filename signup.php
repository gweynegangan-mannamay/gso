<?php
session_start();
include("db_connection.php");
include("function.php");

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $user_name = $_POST['user_name'];
    $password = $_POST['password']; 

    if(!empty($user_name) && !empty($password) && !is_numeric($user_name))
    {
        $user_id = random_num(11); 

        $query = "insert into users (user_id,user_name,password) values ('$user_id','$user_name','$password')"; 
        mysqli_query($con, $query); 

        header("Location: login.php");
        die;
    } else {
        echo "Please enter some valid information!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup</title>
    <style>
        body { 
            margin: 0; 
            height: 100vh; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            background: url('pictures/BG-ISU.C.jpg') no-repeat center center/cover; 
            font-family: Arial, sans-serif; 
        }
        .box { 
            background: #05680a; 
            padding: 30px; 
            width: 300px; 
            border-radius: 10px; 
            text-align: center; 
            color: white; 
        }
        .input { 
            width: 100%; 
            padding: 10px; 
            margin-top: 10px; 
            border: none; 
            border-radius: 5px; 
            box-sizing: border-box; 
        }
        .btn { 
            width: 100%; 
            padding: 10px; 
            margin-top: 15px; 
            background: #3b82f6; 
            color: white; 
            border: none; 
            border-radius: 5px; 
            cursor: pointer; 
        }
        .btn:hover { 
            background: #2563eb; 
        }
        .logo {
            width: 100px;    
            height: 100px;   
            object-fit: contain;    
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="box">
    <form method="post">
        <img src="pictures/isu-logo.png" alt="Logo" class="logo">
        <h2>Signup</h2>
        
        <input class="input" type="text" name="user_name" placeholder="Username" required>
        <input class="input" type="password" name="password" placeholder="Password" required>
        
        <input class="btn" type="submit" value="Save">
        
        
    </form>
</div>

</body>
</html>