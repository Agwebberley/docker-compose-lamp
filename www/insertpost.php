<?php 
if (!isset($_COOKIE['username'])) {
    header("Location: unauthorized.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add New Post</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</head>
<body>
<h1>Add New Blog Post</h1>

<?php include 'navbar.php'; ?>
<?php include 'db_connect.php'; ?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                
                <form action="insert_post.php" method="post">
                    <input type="hidden" class="form-control" id="userid" name="userid" value="<?php echo $_COOKIE['UserID']; ?>">
                    <div class="form-group">
                        <!-- A Dropdown with all of the options for category -->
                        <label for="category">Category:</label>
                        <select class="form-control" id="category" name="category">
                            <?php
                            $sql = "SELECT * FROM Category";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row['CategoryId'] . '">' . $row['CategoryName'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="title">Title:</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="form-group">
                        <label for="content">Content:</label>
                        <textarea class="form-control" id="content" name="content"></textarea>
                    </div>
                    <br>
                    <input type="submit" class="btn btn-primary" value="Submit">
                </form>
                <br>
                <br>
                <form action="bulk_import.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="csvFile">CSV File:</label>
                        <input type="file" class="form-control-file" id="csv" name="csv">
                    </div>
                    <br>
                    <input type="submit" class="btn btn-primary" value="Import">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
