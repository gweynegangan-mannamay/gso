<?php  
session_start(); 
include("db_connection.php");
include("function.php"); 

$user_data = check_Adminlogin($con); 
$page = $_GET['page'] ?? 'dashboard';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Vehicle Request Dashboard</title>

  <!-- FIXED favicon path -->
  <link rel="icon" href="pictures/isu-logo.png">

  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

  <!-- SIDEBAR -->
  <div class="w-64 bg-gradient-to-b from-green-700 to-green-900 text-white p-5 shadow-lg">

    <div class="flex items-center gap-2 mb-8">
      <img src="pictures/isu-logo.png" class="w-14 h-14 rounded-full bg-white">
      <h1 class="text-lg font-bold">GSO-Transportation Service</h1>
    </div>

    <nav class="space-y-3">
      <a href="Adminindex.php?page=dasboard"
         class="block px-4 py-2 rounded transition <?= $page=='dashboard' ? 'bg-green-600' : 'hover:bg-green-500' ?>">
         Dashboard
      </a>

      <a href="Adminindex.php?page=request"
         class="block px-4 py-2 rounded transition <?= $page=='request' ? 'bg-green-600' : 'hover:bg-green-500' ?>">
         Ticket
      </a>

      <a href="Adminindex.php?page=records"
         class="block px-4 py-2 rounded transition <?= $page=='records' ? 'bg-green-600' : 'hover:bg-green-500' ?>">
         Records
      </a>
    </nav>

  </div>

  <!-- MAIN CONTENT -->
  <div class="flex-1 p-6">

    <!-- TOP BAR -->
    <div class="flex justify-end items-center gap-4 mb-8">

      <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-lg shadow-sm border">
        <span class="text-gray-600 text-sm font-semibold">👤</span>
        <span class="text-blue-700 font-bold">
          <?php echo htmlspecialchars($user_data['Adminname'] ?? 'Admin'); ?>
        </span>
      </div>

      <a href="log-out.php"
         class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg shadow transition">
        Logout
      </a>

    </div>

    <!-- PAGE CONTENT -->
    <div class="bg-white p-6 rounded-xl shadow-sm min-h-[500px]">

        <?php
        switch($page) {
            case 'request':
                include 'request.php';
                break;

            case 'records':
                include 'records.php';
                break;

            case 'dasboard':
            default:
                include 'dasboard.php'; // FIXED TYPO (was dasboard.php)
                break;
        }
        ?>

    </div>

  </div>
</div>

</body>
</html>