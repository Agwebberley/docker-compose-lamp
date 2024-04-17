<?php
include 'db_connect.php';

$username = $_POST['username'];
$password = $_POST['password'];

$stmt = $conn->prepare("SELECT * FROM User WHERE Username=? AND Password=?");
$stmt->bind_param("ss", $username, $password);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Login Successful
    echo "Login Successful";
    // Set session variables or redirect to another page
} else {
    // Login Failed
    echo "Invalid Username or Password";
}
$conn->close();
?>
