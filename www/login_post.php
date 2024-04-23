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

    // Set a cookie that expires in 7 days
    setcookie("username", $username, time() + (7 * 24 * 60 * 60));

    // lookup the userID
    $row = $result->fetch_assoc();
    setcookie("userId", $row['UserId'], time() + (7 * 24 * 60 * 60));

    // Check if user is an Admin
    if ($row['Admin'] == 1) {
        // Set a cookie for Admin
        setcookie("admin", "true", time() + (7 * 24 * 60 * 60));
    }

    // Redirect to another page
    header("Location: get_posts.php");
    exit();
} else {
    // Login Failed
    echo "Invalid Username or Password";

}

$conn->close();
?>