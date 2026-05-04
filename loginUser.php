<?php
session_start();
include("db_connection.php");
include("function.php");

$error = "";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $username = isset($_POST['username']) ? mysqli_real_escape_string($con, $_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

    if(!empty($username) && !empty($password)){
        $query = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
        $result = mysqli_query($con, $query);

        if($result && mysqli_num_rows($result) > 0){
            $user_data = mysqli_fetch_assoc($result);

            if($user_data['password'] === $password){
                $_SESSION['user_id'] = $user_data['id']; // ✅ fixed column
                header("Location: UserIndex.php");
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
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="m-0 h-screen flex justify-center items-center bg-[url('pictures/BG-ISU.C.jpg')] bg-cover bg-center font-sans">

<div class="bg-[#05680a]/95 backdrop-blur-sm p-8 w-[320px] rounded-xl text-center text-white shadow-2xl">

    <form method="post">
        <img src="pictures/isu-logo.png" alt="Logo" class="w-20 h-20 object-contain mb-3 mx-auto">
        
        <h2 class="text-xl font-semibold tracking-wide">Login as User</h2>

        <?php if($error != ""): ?>
            <div class="text-red-300 text-sm mt-3"><?php echo $error; ?></div>
        <?php endif; ?>

        <input 
            class="w-full p-2 mt-3 rounded bg-white/90 text-black focus:outline-none focus:ring-2 focus:ring-blue-400"
            type="text" 
            name="username" 
            placeholder="Username" 
            required
        >

        <input 
            class="w-full p-2 mt-3 rounded bg-white/90 text-black focus:outline-none focus:ring-2 focus:ring-blue-400"
            type="password" 
            name="password" 
            placeholder="Password" 
            required
        >

        <input 
            class="w-full p-2 mt-5 bg-blue-500 text-white rounded cursor-pointer hover:bg-blue-600 transition"
            type="submit" 
            value="Login"
        >

    </form>
</div>

</body>
</html>