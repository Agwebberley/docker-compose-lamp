<html>
    <head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <h1>All Users</h1>
        <a href="create_user.php" class="btn btn-primary">Create User</a>

<?php

// Check if the user is an admin
$userIsAdmin = isset($_COOKIE['admin']) && $_COOKIE['admin'] === 'true';

if ($userIsAdmin) {
    // Fetch all users from the database
    include 'db_connect.php';

    $stmt = $conn->prepare("SELECT * FROM User");
    $stmt->execute();
    $result = $stmt->get_result();
    $users = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();

    // Display the users in a table
    echo '<table class="table table-striped">';
    echo '<thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Password</th><th>Action</th></tr></thead>';
    echo '<tbody>';
    foreach ($users as $user) {
        echo '<tr>';
        echo '<td>' . $user['UserId'] . '</td>';
        echo '<td>' . $user['Username'] . '</td>';
        echo '<td>' . $user['Email'] . '</td>';
        echo '<td>' . $user['Password'] . '</td>';
        echo '<td><form method="POST" action="delete_user.php">';
        echo '<input type="hidden" name="userId" value="' . $user['UserId'] . '">';
        echo '<button type="submit" class="btn btn-danger">Delete</button>';
        echo '</form></td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';

} else {
    // redirect to unauthorized.php
    header("Location: unauthorized.php");
}
?>
</body>
</html>