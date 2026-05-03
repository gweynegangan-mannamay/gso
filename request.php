<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Combine date + time
    $stmt = $con->prepare("INSERT INTO trip_tickets 
    (driver_name, vehicle_plate, destination, purpose, departure_datetime, arrival_datetime, remarks)
    VALUES (?, ?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    die("SQL Error: " . $con->error);
}
// Combine date + time
$departure_datetime = $_POST['date_departure'] . ' ' . $_POST['time_departure'];
$arrival_datetime   = $_POST['date_departure'] . ' ' . $_POST['time_arrival'];

$stmt->bind_param("sssssss",
    $_POST['fullname'],
    $_POST['vehicle_plate'],
    $_POST['destination'],
    $_POST['purpose'],
    $departure_datetime,
    $arrival_datetime,
    $_POST['remarks']
);

    if ($stmt->execute()) {

        // Get inserted trip ID
        $trip_id = $stmt->insert_id;

        // 2. INSERT INTO fuel_records
        $stmt2 = $con->prepare("INSERT INTO fuel_records 
            (trip_id, issued_from_stock, additional_purchase, balance_end)
            VALUES (?, ?, ?, ?)");

        $stmt2->bind_param("iddd",
            $trip_id,
            $_POST['fuel_issued'],
            $_POST['fuel_purchased'],
            $_POST['fuel_balance']
        );

        $stmt2->execute();

        // 3. INSERT INTO trip_distance
        $stmt3 = $con->prepare("INSERT INTO trip_distance 
            (trip_id, start_reading, end_reading, distance_travelled)
            VALUES (?, ?, ?, ?)");

        $stmt3->bind_param("iddd",
            $trip_id,
            $_POST['mileage_start'],
            $_POST['mileage_end'],
            $_POST['distance']
        );

        $stmt3->execute();

        echo '<div class="bg-green-100 p-4 rounded mb-4">✅ Request submitted successfully!</div>';

    } else {
        echo '<div class="bg-red-100 p-4 rounded mb-4">❌ Error: '.$con->error.'</div>';
    }
}
?>

<h2 class="text-2xl font-bold mb-6">📋 Ticket Form</h2>

<form method="POST" class="bg-white p-6 rounded-xl shadow max-w-4xl mx-auto space-y-6">

  <!-- Personal Info -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
      <label class="block font-medium mb-1">Driver's Full Name</label>
      <input type="text" name="fullname" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
    </div>

  <div>
  <label class="block font-medium mb-1">Vehicle Plate No.</label>
  <input type="text" name="vehicle_plate" 
         class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" 
         required>
</div>

    <div>
      <label class="block font-medium mb-1">Department</label>
      <input type="text" name="department" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
    </div>
  </div>

  <div>
    <label class="block font-medium mb-1">Destination</label>
    <input type="text" name="destination" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
  </div>

  <!-- Date & Time -->
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div>
      <label class="block font-medium mb-1">Date of Departure</label>
      <input type="date" name="date_departure" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
    </div>
    <div>
      <label class="block font-medium mb-1">Time of Departure</label>
      <input type="time" name="time_departure" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
    </div>
    <div>
      <label class="block font-medium mb-1">Arrival Time</label>
      <input type="time" name="time_arrival" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
    </div>
  </div>

  <div>
    <label class="block font-medium mb-1">Number of Passengers</label>
    <input type="number" name="passengers" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
  </div>

  <!-- Purpose -->
  <div>
    <label class="block font-medium mb-1">Purpose of Trip</label>
    <textarea name="purpose" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" rows="3" required></textarea>
  </div>

  <!-- Fuel Information -->
  <h3 class="font-bold text-lg mb-2 mt-4">⛽ Fuel Information</h3>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div>
      <label class="block font-medium mb-1">Fuel Issued (L)</label>
      <input type="number" step="0.1" name="fuel_issued" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <div>
      <label class="block font-medium mb-1">Fuel Purchased (L)</label>
      <input type="number" step="0.1" name="fuel_purchased" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <div>
      <label class="block font-medium mb-1">Fuel Balance (L)</label>
      <input type="number" step="0.1" name="fuel_balance" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
  </div>

  <!-- Mileage -->
  <h3 class="font-bold text-lg mb-2 mt-4">📏 Mileage</h3>
  <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div>
      <label class="block font-medium mb-1">Start Mileage (km)</label>
      <input type="number" name="mileage_start" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <div>
      <label class="block font-medium mb-1">End Mileage (km)</label>
      <input type="number" name="mileage_end" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <div>
      <label class="block font-medium mb-1">Distance Travelled (km)</label>
      <input type="number" name="distance" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
  </div>

  <!-- Remarks -->
  <div>
    <label class="block font-medium mb-1">Remarks</label>
    <textarea name="remarks" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" rows="2"></textarea>
  </div>

  <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">Submit Request</button>

</form>