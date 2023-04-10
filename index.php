<?php
// Load the Google API PHP Client Library.
require_once __DIR__ . '/vendor/autoload.php';

// Create a new client and authorize it with your API key
$client = new Google_Client();
$client->setApplicationName('Google Sheets API PHP Quickstart');
$client->setScopes(Google_Service_Sheets::SPREADSHEETS);
$client->setAuthConfig('credentials.json');

// Get the API client and construct the service object.
$service = new Google_Service_Sheets($client);

// The ID of the spreadsheet to retrieve data from.
$spreadsheetId = '1_Z1T3YkVhJ5St4rfLxRAA6s97v2VJXed0tL2EV3HuW4';

// Get the current row number from the query string (default to 2)
$row = isset($_GET['row']) ? (int)$_GET['row'] : 2;

// The range of cells to retrieve data from.
$range = 'Sheet1!B' . $row . ':D' . $row;

// Retrieve the data from the specified range of cells within the spreadsheet.
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

// Get the contact information from the first row of data
$contactInfo = isset($values[0]) ? $values[0] : null;

if (isset($_POST['status'])) {
    // Get the selected status from the form submission
    $status = $_POST['status'];

    // The range of cells to update
    $range = 'Sheet1!L2';

    // Create a new ValueRange object and set its values
    $valueRange = new Google_Service_Sheets_ValueRange();
    $valueRange->setValues([[$status]]);

    // Send an update request to the Google Sheets API
    $service->spreadsheets_values->update($spreadsheetId, $range, $valueRange, ['valueInputOption' => 'RAW']);

    // Redirect back to the same page to prevent form resubmission
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Contact Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: skyblue;
        }
        .contact-info {
            width: 300px;
            margin: 0 auto;
            text-align: center;
        }
        .contact-info img {
            width: 100%;
            height: auto;
        }
        .contact-info h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .contact-info p {
            font-size: 18px;
            margin-bottom: 10px;
        }
        .navigation {
            margin-top: 20px;
        }
        .navigation button {
            font-size: 18px;
            padding: 10px 20px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
  <form method="post">
    <div class="contact-info">
        <img src="us.jpeg" alt="Icon">
        <h1>Contact Information</h1>
        <?php if ($contactInfo): ?>
            <p>Name: <?php echo htmlspecialchars($contactInfo[0]); ?></p>
            <p>Phone Number: <span id="phone-number"><?php echo htmlspecialchars($contactInfo[1]); ?></span> <i class="fas fa-copy" onclick="copyPhoneNumber()"></i></p>
            <p>Email: <?php echo htmlspecialchars($contactInfo[2]); ?></p>
            <p>Status:
                <select name="status" id="status">
                    <option value="" selected>None</option>
                    <option value="AE CONTACTED">AE CONTACTED</option>
                    <option value="RTVM | SMS SENT">RTVM | SMS SENT</option>
                    <option value="CALL DROPPED">CALL DROPPED</option>
                    <option value="WRONG NUMBER">WRONG NUMBER</option>
                    <option value="RESIGNED | NOT INTERESTED">RESIGNED | NOT INTERESTED</option>
                    <option value="SMS Blast">SMS Blast</option>
                </select>
            </p>
        <?php else: ?>
            <p>No contact information found.</p>
        <?php endif; ?>

        <button type="submit">Save Status</button>

        <div class="navigation">
            <?php if ($row > 2): ?>
                <button onclick="window.location.href='?row=<?php echo max(2, $row - 1); ?>'">Previous</button>
            <?php endif; ?>
            <button onclick="window.location.href='?row=<?php echo ($row + 1); ?>'">Next</button>
        </div>
    </div>

    <script>
        function copyPhoneNumber() {
            var phoneNumber = document.getElementById('phone-number').textContent;
            navigator.clipboard.writeText(phoneNumber);
        }
    </script>
</form>
