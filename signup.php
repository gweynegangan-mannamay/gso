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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="m-0 h-screen flex justify-center items-center bg-[url('pictures/BG-ISU.C.jpg')] bg-cover bg-center font-sans">

<div class="bg-[#05680a] p-8 w-[290px] rounded-lg text-center text-white">
    <form method="post">
        <img src="pictures/isu-logo.png" alt="Logo" class="w-[100px] h-[100px] object-contain mb-2 mx-auto">
        <h2 class="text-2xl font-semibold">Sign-up</h2>
        
        <input class="w-100 p-1 mt-1 border-none rounded box-border text-black" type="text" name="user_name" placeholder="Username" required>
        <input class="w-100 p-1 mt-2 border-none rounded box-border text-black" type="password" name="password" placeholder="Password" required>
        
        <input class="w-30 p-2 mt-3  text-white  rounded cursor-pointer hover:bg-blue-600" type="submit" value="Sign-up">
        
    </form>
</div>

</body>
</html>