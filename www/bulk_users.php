<?php

# A CSV file is passed in from a POST request
# The CSV file is read and each row is inserted into the database
# The response is a JSON object with the number of rows inserted

include 'db_connect.php';

$csvFilePath = $_FILES['csv']['tmp_name'];
$csv = file_get_contents($csvFilePath);

$rows = explode("\n", $csv);
$inserted = 0;

foreach ($rows as $row) {
    $data = str_getcsv($row);
    $stmt = $conn->prepare("INSERT INTO User (Username, Password, Email, Admin) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $data[0], $data[1], $data[2], $data[3]); // Update the bind_param call to match the number of placeholders
    if ($stmt->execute()) {
        $inserted++;
    }
    $stmt->close();
}

$conn->close();
