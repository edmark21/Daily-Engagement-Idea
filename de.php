<?php
    // Load the Google API PHP Client Library.
    require_once __DIR__ . '/vendor/autoload.php';

    // Create a new client and authorize it with your API key
    $client = new Google_Client();
    $client->setApplicationName('Google Sheets API PHP Quickstart');
    $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
    $client->setAuthConfig('credentials.json');

    // Get the API client and construct the service object.
    $service = new Google_Service_Sheets($client);

    // The ID of the spreadsheet to retrieve data from.
    $spreadsheetId = '1_Z1T3YkVhJ5St4rfLxRAA6s97v2VJXed0tL2EV3HuW4';

    // Get the current row number from the query string (default to 2)
    $row = isset($_GET['row']) ? (int)$_GET['row'] : 3;

    // The range of cells to retrieve data from.
    $range = 'Sheet1!B' . $row . ':D' . $row;

    // Retrieve the data from the specified range of cells within the spreadsheet.
    $response = $service->spreadsheets_values->get($spreadsheetId, $range);
    $values = $response->getValues();

    // Print out the data in a table
    echo "<style>table, th, td {border: 1px solid black; padding: 8px;} th {background-color: #f2f2f2;} .center {text-align: center;}</style>";
    echo "<table>";
    echo "<tr><th>Name</th><th>Phone Number</th><th>Email</th></tr>";
    foreach ($values as $dataRow) {
        echo "<tr>";
        echo "<td>" . $dataRow[0] . "</td>";
        echo "<td>" . $dataRow[1] . "</td>";
        echo "<td>" . $dataRow[2] . "</td>";
        echo "</tr>";
        break;
    }
    echo "<tr><td></td><td class='center'>";
    echo "<button onclick='window.location.href=\"?row=" . max(3, $row - 1) . "\"'>Previous</button> ";
    echo "<button onclick='window.location.href=\"?row=" . ($row + 1) . "\"'>Next</button>";
    echo "<td><button onclick=''>Disposition</button></td>";
    echo "</td><td></td></tr>";
    echo "</table>";
?>