<?php
include 'db_connection.php';

// DELETE FUNCTION
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    $stmt = $con->prepare("DELETE FROM trip_tickets WHERE id = ?");

    if (!$stmt) {
        die("Prepare failed: " . $con->error);
    }

    $stmt->bind_param("i", $delete_id);

    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->error);
    }

    header("Location: index.php?page=records");
    exit();
}

// Fetch records directly from trip_tickets since driver_info doesn't exist
$query = "
SELECT 
    id,
    driver_name,
    vehicle_plate,
    destination,
    departure_datetime AS date_departure -- Using the column name from your previous setup
FROM trip_tickets 
ORDER BY departure_datetime DESC
";

$result = $con->query($query);

// Check for errors to prevent the "Uncaught mysqli_sql_exception"
if (!$result) {
    die("Query Failed: " . $con->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Ticket Records</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-8">

    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-extrabold text-gray-800">📁 Trip Ticket Records</h2>
            
        </div>

        <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-200">
            <table class="min-w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left border-b">Driver Name</th>
                        <th class="py-3 px-6 text-left border-b">Plate No.</th>
                        <th class="py-3 px-6 text-left border-b">Destination</th>
                        <th class="py-3 px-6 text-center border-b">Departure Date</th>
                        <th class="py-3 px-6 text-center border-b">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <?php if ($result->num_rows > 0): ?>
                        <?php while($row = $result->fetch_assoc()): ?>
<tr class="border-b border-gray-200 hover:bg-gray-50 transition">

    <td class="py-3 px-6 text-left whitespace-nowrap font-medium text-gray-900">
        <?= htmlspecialchars($row['driver_name'] ?? 'No Driver') ?>
    </td>

    <td class="py-3 px-6 text-left">
        <span class="bg-blue-100 text-blue-800 py-1 px-3 rounded-full text-xs font-bold">
            <?= htmlspecialchars($row['vehicle_plate'] ?? 'N/A') ?>
        </span>
    </td>

    <td class="py-3 px-6 text-left">
        <?= htmlspecialchars($row['destination']) ?>
    </td>

    <td class="py-3 px-6 text-center">
        <?= date('M d, Y', strtotime($row['date_departure'])) ?>
    </td>
    <!-- ACTIONS -->
    <td class="py-3 px-6 text-center">
        <div class="flex item-center justify-center space-x-4">
            <a href="print.php?id=<?= $row['id'] ?>" target="_blank"
               class="text-blue-600 hover:text-blue-900 flex items-center font-semibold">
                <span class="mr-1">🖨️</span> Print
            </a>
            
            <!-- Deleting Records -->
            <a href="records.php?delete_id=<?= $row['id'] ?>"
            onclick="return confirm('Are you sure you want to delete this record?')"
            class="text-red-600 hover:text-red-900 flex items-center font-semibold">
                <span class="mr-1">🗑️</span> Delete
            </a>
        </div>
    </td>

</a>
</tr>
<?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="py-10 text-center text-gray-500 italic">
                                No records found. Start by adding a new trip ticket.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <p class="mt-4 text-sm text-gray-400 text-center">
            Total Records: <?= $result->num_rows ?>
        </p>
    </div>

</body>
</html>