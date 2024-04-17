<?php
$servername = "database";
$username = "root";
$password = "WyfX8fbH2TLbwNK2Lzk8";
$dbname = "Blog";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
