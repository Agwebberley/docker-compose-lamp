<?php
$userIsAdmin = isset($_COOKIE['admin']) && $_COOKIE['admin'] === 'true';

if ($userIsAdmin) {
    include 'db_connect.php';

    $userId = $_POST['userId'];

    $stmt = $conn->prepare("DELETE FROM User WHERE UserId = ?");
    $stmt->bind_param("i", $userId);

    $stmt->execute();

    $stmt->close();

    header("Location: users.php");
    exit;
} else {
    header("Location: unauthorized.php");
}
?>