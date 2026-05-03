<?php
include 'db_connection.php';

if (!isset($_GET['id'])) {
    die("No record specified.");
}

$id = intval($_GET['id']);

$query = "
SELECT 
    t.driver_name,
    t.authorized_passengers,
    t.vehicle_plate,
    t.destination,
    t.purpose,
    t.departure_datetime,
    t.arrival_datetime,
    t.return_datetime,
    t.remarks,

    f.issued_from_stock AS fuel_issued_stock,
    f.additional_purchase AS fuel_purchased,
    f.balance_end AS fuel_balance_end,
    d.start_reading AS speedometer_start,
    d.end_reading AS speedometer_end
FROM trip_tickets t
LEFT JOIN fuel_records f ON t.id = f.trip_id
LEFT JOIN trip_distance d ON t.id = d.trip_id
WHERE t.id = ?
";

$stmt = $con->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Record not found.");
}

$row = $result->fetch_assoc();

function val($row, $key, $default = "________________") {
    return isset($row[$key]) && $row[$key] !== '' ? $row[$key] : $default;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trip Ticket - <?= strtoupper(val($row, 'driver_name')) ?></title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10.5pt; background: #fff; color: #000; }
        .container { width: 8.5in; margin: auto; padding: 0.5in; border: 1px solid #eee; }
        
        /* Typography */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .underline { text-decoration: underline; }
        
        /* Layout Sections */
        .header-title { font-size: 12pt; margin-bottom: 20px; }
        .section-header { margin: 15px 0 5px 0; font-weight: bold; display: flex; }
        .indent { margin-left: 30px; }
        
        .line-item { display: flex; margin-bottom: 4px; align-items: flex-end; }
        .label { min-width: 20px; margin-right: 5px; }
        .text-label { flex-shrink: 0; }
        .value { border-bottom: 1px solid black; flex-grow: 1; padding-left: 8px; font-weight: bold; font-family: 'Courier New', Courier, monospace; }
        
        /* Table */
        .passenger-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .passenger-table th, .passenger-table td { border: 1px solid black; padding: 4px; height: 25px; font-size: 9pt; }
        
        /* Signature Blocks */
        .signature-row { display: flex; justify-content: flex-end; margin-top: 20px; text-align: center; }
        .sig-block { width: 300px; }
        .sig-line { border-bottom: 1px solid black; font-weight: bold; text-transform: uppercase; margin-bottom: 2px; }
        
        @media print {
            .no-print { display: none; }
            .container { border: none; width: 100%; padding: 0; }
        }
    </style>
</head>
<body>

<div class="no-print" style="text-align:center; padding: 20px;">
    <button onclick="window.print()">Print Trip Ticket</button>
</div>

<div class="container">
    <div class="text-center bold">City of Ilagan, Isabela</div>
    
    <div class="text-right" style="margin-top: 15px;">
        <span class="underline bold"><?= date('F d, Y', strtotime($row['created_at'] ?? 'now')) ?></span><br>
        Date
    </div>

    <div class="bold underline" style="margin-top: 10px;">DRIVER'S TRIP TICKET</div>

    <div class="section-header">
        <span style="margin-right: 10px;">A.</span>
        <span>To be filled up by the Administrative Officials Authorizing Official Travel</span>
    </div>
    
    <div class="indent">
        <div class="line-item">
            <span class="label">1.</span> <span class="text-label">Name of the driver to the vehicle:</span>
            <div class="value"><?= strtoupper(val($row, 'driver_name')) ?></div>
        </div>
        <div class="line-item">
            <span class="label">2.</span> <span class="text-label">Name of authorized passenger:</span>
            <div class="value"><?= strtoupper(val($row, 'authorized_passengers')) ?></div>
        </div>
        <div class="line-item">
            <span class="label">3.</span> <span class="text-label">Government car to be used Plate:</span>
            <div class="value"><?= strtoupper(val($row, 'vehicle_plate')) ?></div>
        </div>
        <div class="line-item">
            <span class="label">4.</span> <span class="text-label">Place to be visited/inspected:</span>
            <div class="value"><?= val($row, 'destination') ?></div>
        </div>
        <div class="line-item">
            <span class="label">5.</span> <span class="text-label">Purpose:</span>
            <div class="value"><?= val($row, 'purpose') ?></div>
        </div>
    </div>

    <div class="signature-row">
        <div class="sig-block">
            <div class="sig-line"><?= val($row, 'approving_official', 'ARMAND FRANCIS C. RUMA') ?></div>
            <div>Director, AFS/Authorized Representative</div>
        </div>
    </div>

    <div class="section-header">
        <span style="margin-right: 10px;">B.</span>
        <span>To be filled up by the driver:</span>
    </div>
    
    <div class="indent">
        <div class="line-item">
            <span class="label">6.</span> <span class="text-label">Date and Time of departure from office/garage:</span>
            <div class="value"><?= val($row, 'departure_datetime') ?></div>
        </div>
        <div class="line-item">
            <span class="label">7.</span> <span class="text-label">Date and Time of arrival:</span>
            <div class="value"><?= val($row, 'arrival_datetime') ?></div>
        </div>
        <div class="line-item">
            <span class="label">8.</span> <span class="text-label">Appropriate issued purchased and consumed:</span>
            <div class="value"></div>
        </div>
        <div class="line-item">
            <span class="label">9.</span> <span class="text-label">Actual Time of departure:</span>
            <div class="value"></div>
        </div>
        <div class="line-item">
            <span class="label">10.</span> <span class="text-label">Date and Time of arrival back to office/garage:</span>
            <div class="value"><?= val($row, 'return_datetime') ?></div>
        </div>
        <div class="line-item">
            <span class="label">11.</span> <span class="text-label">Gasoline issued purchased and consumed:</span>
        </div>
        <div class="indent">
            <div class="line-item">
                <span class="label">a.</span> <span class="text-label">Balance in tank:</span>
                <div class="value"><?= val($row, 'fuel_balance_start') ?></div>
                <span style="font-size: 0.8em; margin-left:5px;">(estimate in ¾, ½ and ¼ full)</span>
            </div>
            <div class="line-item">
                <span class="label">b.</span> <span class="text-label">Issued by the from Stock:</span>
                <div class="value"><?= val($row, 'fuel_issued_stock') ?></div> <span>Liters</span>
            </div>
            <div class="line-item">
                <span class="label">c.</span> <span class="text-label">Additional purchase during trip:</span>
                <div class="value"><?= val($row, 'fuel_purchased') ?></div> <span>Liters Total</span>
                <div class="value"></div> <span>Liters</span>
            </div>
            <div class="line-item">
                <span class="label">d.</span> <span class="text-label">Deduct used during the trip (to and from):</span>
                <div class="value"></div> <span>Liters</span>
            </div>
            <div class="line-item">
                <span class="label">e.</span> <span class="text-label">Balance in tank at the end of the trip:</span>
                <div class="value"><?= val($row, 'fuel_balance_end') ?></div>
            </div>
        </div>
        
        <div class="line-item">
            <span class="label">12.</span> <span class="text-label">Gear oil issued:</span>
            <div class="value"></div> <span>Liters</span>
        </div>
        <div class="line-item">
            <span class="label">13.</span> <span class="text-label">Lubricating oil issued:</span>
            <div class="value"></div> <span>Liters</span>
        </div>
        <div class="line-item">
            <span class="label">14.</span> <span class="text-label">Greased issued:</span>
            <div class="value"></div> <span>Liters</span>
        </div>
        
        <div class="line-item">
            <span class="label">15.</span> <span class="text-label">Speed meter reader if any:</span>
        </div>
        <div class="indent">
            <div class="line-item">
                <span class="text-label">At the beginning of the trip:</span>
                <div class="value"><?= val($row, 'speedometer_start') ?></div> <span>miles/kms</span>
            </div>
            <div class="line-item">
                <span class="text-label">At the end of the trip:</span>
                <div class="value"><?= val($row, 'speedometer_end') ?></div> <span>miles/kms</span>
            </div>
            <div class="line-item">
                <span class="text-label">Distance traveled per no. 5 above:</span>
                <div class="value"><?= (float)val($row, 'speedometer_end', 0) - (float)val($row, 'speedometer_start', 0) ?></div> <span>miles/kms</span>
            </div>
        </div>

        <div class="line-item">
            <span class="label">16.</span> <span class="text-label">Remarks:</span>
            <div class="value"><?= val($row, 'remarks') ?></div>
        </div>
    </div>

    <div class="text-center" style="margin-top: 15px; font-style: italic;">
        I hereby certify to the correctness of the above statement of record of travel
    </div>

    <div class="signature-row">
        <div class="sig-block">
            <div class="sig-line"><?= strtoupper(val($row, 'driver_name')) ?></div>
            <div>Driver</div>
        </div>
    </div>

    <div style="margin-top: 20px;">
        I hereby certify that this area on Official Business as stated above
        <table class="passenger-table">
            <thead>
                <tr>
                    <th colspan="3">Names of Passenger/s</th>
                </tr>
                <tr>
                    <th width="40%">NAME</th>
                    <th width="30%">DESIGNATION</th>
                    <th width="30%">SIGNATURE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= val($row, 'authorized_passengers') ?></td>
                    <td></td>
                    <td></td>
                </tr>
                <?php for($i=0; $i<4; $i++): ?>
                <tr><td>&nbsp;</td><td></td><td></td></tr>
                <?php endfor; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>