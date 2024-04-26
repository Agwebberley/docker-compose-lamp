<?php

// Get Admin status from cookie
$isAdmin = isset($_COOKIE['admin']) && $_COOKIE['admin'] === 'true';

if (!$isAdmin) {
    // Redirect to unauthorized.php
    header("Location: unauthorized.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Save the form data
    $usernme = $_POST['username'];
    $email = $_POST['email'];
    $passwrd = $_POST['password'];
    if (isset($_POST['isAdmin'])) {
        $Admin = $_POST['isAdmin'] === '1' ? 1 : 0;
    } else {
        $Admin = 0;
    }

    // Insert the user into the database
    include 'db_connect.php';

    $stmt = $conn->prepare("INSERT INTO User (Username, Email, Password, Admin) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $usernme, $email, $passwrd, $Admin);

    $stmt->execute();

    $stmt->close();

    // Redirect to a success page
    header('Location: users.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>
<body>
<?php include 'navbar.php'; ?>

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1>Create User</h1>
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" required>

                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="isAdmin">Is Admin:</label>
                    <input type="checkbox" name="isAdmin" id="isAdmin" value="1">
                </div>

                <button type="submit" class="btn btn-primary">Create User</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>