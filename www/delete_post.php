<?php
// Check if user is an admin
$isAdmin = isset($_COOKIE['admin']) && $_COOKIE['admin'] === 'true';

if ($isAdmin) {
    // Delete the post ID
    $postId = $_GET['post_id']; // Replace with the actual post ID parameter

    // Perform the deletion logic here
    include 'db_connect.php';

    // Prepare a statement to delete the post
    $stmt = $conn->prepare("DELETE FROM Post WHERE PostID = ?");
    $stmt->bind_param("i", $postId);

    // Execute the statement
    $stmt->execute();

    // Close the statement and the connection
    $stmt->close();

    // Redirect to get_posts.php
    header("Location: get_posts.php");
    exit;
} else {
    // Handle the case when user is not an admin
    // ...
    // Redirect to another page
    header("Location: unauthorized.php");
    exit;
}
?>