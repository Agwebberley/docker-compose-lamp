<?php
include 'db_connect.php';

$title = $_POST['title'];
$content = $_POST['content'];
$userid = $_POST['userid']; // Assuming user id is known
$categoryid = $_POST['categoryid']; // Assuming category id is known

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO Post (UserID, Title, Content, CategoryID) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $userid, $title, $content, $categoryid);

if ($stmt->execute()) {
    echo "New record created successfully";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
?>
