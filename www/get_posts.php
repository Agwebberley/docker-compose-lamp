<!DOCTYPE html>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>View All Posts</title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <h1>All Blog Posts</h1>
    <?php
    // Include your database connection file here
    include 'db_connect.php';

    // Write your SQL query to get all posts
    $sql = "SELECT * FROM Post";

    // Execute the query and get the result
    $result = $conn->query($sql);

    // Check if there are any results
    if ($result->num_rows > 0) {
        // Output data of each row
        echo '<div class="container-fluid">';
        echo '<div class="row" style="padding: 20px;">';
        while($row = $result->fetch_assoc()) {
            echo '<div class="col-md">';
            echo '<div class="card" style="width: 18rem; padding: 10px;">'; // Add padding to the card

            // Display the image in the card
            echo '<img src="https://picsum.photos/id/' . $row["PostID"] . '/200" class="card-img-top" alt="Random Image">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title"><a href="/post_details.php?PostID=' . $row["PostID"] . '">' . $row["Title"] . '</a></h5>';
            echo '<p class="card-text">' . substr($row["Content"], 0, 100) . '...</p>';
            if (isset($_COOKIE['admin']) && $_COOKIE['admin'] === 'true') {
                echo '<a href="delete_post.php?post_id=' . $row["PostID"] . '" class="btn btn-danger">Delete</a>';
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
            
        }
        echo '<div style="padding-bottom: 20px;"></div>'; // Add padding between rows
        echo '</div>';
        echo '</div>';
    } else {
        echo "No posts found";
    }

    // Close the database connection
    $conn->close();
    ?>
</body>
</html>
