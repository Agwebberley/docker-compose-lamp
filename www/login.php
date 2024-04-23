<!DOCTYPE html>
<html>
<head>
    <title>User Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>
<body>
<?php include 'navbar.php'; ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1>User Login</h1>
            <form action="login_post.php" method="post">
                <label class="form-label" for="username">Username:</label><br>
                <input class="form-control" type="text" id="username" name="username"><br>
                <label class="form-label" for="password">Password:</label><br>
                <input class="form-control" type="password" id="password" name="password"><br>
                <input class="form-control submit-button" type="submit" value="Login">
            </form>
        </div>
    </div>
</div>
</body>
</html>
