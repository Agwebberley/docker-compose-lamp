<?php
// Remove the username cookie if it exists
if (isset($_COOKIE['username'])) {
    setcookie('username', '', time() - 3600, '/');
}

// Remove the userID cookie if it exists
if (isset($_COOKIE['userID'])) {
    setcookie('userID', '', time() - 3600, '/');
}

// Remove the admin cookie if it exists
if (isset($_COOKIE['admin'])) {
    setcookie('admin', '', time() - 3600, '/');
}

// Redirect to get_posts.php
header('Location: get_posts.php');
exit;
?>