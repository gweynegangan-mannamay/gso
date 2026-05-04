<?php
session_start();
include("db_connection.php");
include("function.php");

$error = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){

    // FIX: correct input + trim
    $Adminname = trim(mysqli_real_escape_string($con, $_POST['Adminname'] ?? ''));
    $password = $_POST['password'] ?? '';

    if(!empty($Adminname) && !empty($password)){

        $query = "SELECT * FROM admins WHERE Adminname = '$Adminname' LIMIT 1";
        $result = mysqli_query($con, $query);

        if($result && mysqli_num_rows($result) > 0){
            $user_data = mysqli_fetch_assoc($result);

            if($user_data['password'] === $password){
                $_SESSION['id'] = $user_data['id'];
                header("Location: AdminIndex.php");
                exit();
            } else {
                $error = "Wrong password!";
            }
        } else {
            $error = "Admin not found!";
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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="m-0 h-screen flex justify-center items-center bg-[url('pictures/BG-ISU.C.jpg')] bg-cover bg-center font-sans">

<div class="bg-[#05680a] p-8 w-[300px] rounded-lg text-center text-white">
    <form method="post">        
        <img src="pictures/isu-logo.png" alt="Logo" class="w-20 h-20 object-contain mb-2 mx-auto">
        <h2 class="text-xl font-semibold">Login as Admin</h2>

        
        <?php if($error != ""): ?>
            <div class="text-red-400 text-sm mt-2"><?php echo $error; ?></div>
        <?php endif; ?>

        <input class="w-full p-2 mt-2 border-none rounded box-border text-black" type="text" name="Adminname" placeholder="Adminname" required>  
        <input class="w-full p-2 mt-2 border-none rounded box-border text-black" type="password" name="password" placeholder="Password" required>

        <input class="w-full p-2 mt-4 bg-blue-500 text-white border-none rounded cursor-pointer hover:bg-blue-600" type="submit" value="Login">

        
    </form>
</div>

</body>
</html>