<?php  
session_start(); 
include("db_connection.php");
include("function.php"); 

$user_data = check_userslogin($con); 
$page = $_GET['page'] ?? 'dashboard';

$dept_query = "SELECT * FROM user_info ORDER BY department ASC"; $dept_result = mysqli_query($con, $dept_query);

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $name = mysqli_real_escape_string($con, $_POST['passenger_name']);
    $department = mysqli_real_escape_string($con, $_POST['department']);
    $contact = mysqli_real_escape_string($con, $_POST['contact_number']);
    $purpose = mysqli_real_escape_string($con, $_POST['purpose']);

    $query = "INSERT INTO user_info (passenger_name, department, contact_number, purpose) 
              VALUES ('$name', '$department', '$contact', '$purpose')";

    if(mysqli_query($con, $query)){
        header("Location: index.php?success=1");
        exit;
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Vehicle Request Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex min-h-screen">

  <!-- Sidebar -->
  <div class="w-64 bg-gradient-to-b from-green-700 to-green-900 text-white p-5 shadow-lg">
    <div class="flex items-center gap-2 mb-8">
      <img src="pictures/isu-logo.png" class="w-14 h-14 rounded-full bg-white">
      <h1 class="text-lg font-bold">GSO-Transportation Service</h1>
    </div>

    <nav class="space-y-3">
      <a href="#" class="block px-4 py-2 rounded bg-green-600">Request</a>
    </nav>
  </div>

  <!-- Main -->
  <div class="flex-1 p-6">

    <!-- Top bar -->
    <div class="flex justify-end items-center gap-4 mb-8">
      <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-lg shadow-sm border">
        <span>👤</span>
        <span class="text-blue-700 font-bold">
          <?php echo htmlspecialchars($user_data['username']); ?>
        </span>
      </div>

      <a href="log-out.php" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
        Logout
      </a>
    </div>

    <!-- Form -->
    <div class="bg-white p-6 rounded-xl shadow-sm">

      <h2 class="text-xl font-bold mb-6 text-gray-700">Passenger Information</h2>

      <?php if(isset($_GET['success'])): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
          ✅ Data saved successfully!
        </div>
      <?php endif; ?>

      <!-- ✅ FIX: submit to same file -->
      <form method="POST" action="" class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <!-- Name -->
        <div>
          <label class="block text-sm font-semibold mb-1">Passenger Name</label>
          <input type="text" name="passenger_name" required
            class="w-full px-4 py-2 border rounded-lg">
        </div>

        <!-- ✅ Dynamic Department -->
        <div>
          <label class="block text-sm font-semibold mb-1">Department</label>

          <select name="department" required
            class="w-full px-4 py-2 border rounded-lg">

            <option value="" disabled selected hidden>Select Department</option>

            <?php while($row = mysqli_fetch_assoc($dept_result)): ?>
              <option value="<?php echo htmlspecialchars($row['department']); ?>">
                <?php echo htmlspecialchars($row['department']); ?>
              </option>
            <?php endwhile; ?>

          </select>
        </div>

        <!-- Contact -->
        <div>
          <label class="block text-sm font-semibold mb-1">Contact Number</label>
          <input type="tel" name="contact_number" required
            class="w-full px-4 py-2 border rounded-lg">
        </div>

        <!-- Purpose -->
        <div class="md:col-span-2">
          <label class="block text-sm font-semibold mb-1">Purpose</label>
          <textarea name="purpose" required
            class="w-full px-4 py-2 border rounded-lg"></textarea>
        </div>

        <!-- Submit -->
        <div class="md:col-span-2">
          <button type="submit"
            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg">
            Submit
          </button>
        </div>

      </form>

    </div>

  </div>
</div>

</body>
</html>