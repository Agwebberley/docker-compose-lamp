<html>
<head>
    <title>Post Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>

<body>
<?php
include 'navbar.php';
// Retrieve the post ID from the URL
$postId = $_GET['PostID'];

include 'db_connect.php';

// Prepare the SQL statement using a parameterized query
$sql = "SELECT * FROM Post WHERE PostID = ?";
$stmt = $conn->prepare($sql);

// Bind the post ID to the prepared statement
$stmt->bind_param("i", $postId);

// Execute the query
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Fetch the post details
$post = $result->fetch_assoc();

// close the statement
$stmt->close();

// lookup the CategoryName from the Category table
$sql = "SELECT CategoryName FROM Category WHERE CategoryId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post['CategoryID']);
$stmt->execute();
$result = $stmt->get_result();
$category = $result->fetch_assoc();
$post['CategoryID'] = $category['CategoryName'];
$stmt->close();

// Lookup all Tags for the post
$sql = "SELECT TagName FROM Tag WHERE TagID IN (SELECT TagID FROM PostTag WHERE PostID = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $postId);
$stmt->execute();
$result = $stmt->get_result();
$tags = [];
while ($tag = $result->fetch_assoc()) {
    $tags[] = $tag['TagName'];
}
$stmt->close();

// Lookup the username from the User table
$sql = "SELECT Username FROM User WHERE UserID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $post['UserID']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if the post exists
if ($post) {
    // Display the post details
    echo "<div class='container'>";
    echo "<center><h1>{$post['Title']}</h1></center>";
    echo '<p>Author: <a href="post_search.php?user=' . $post['UserID'] . '">' . $user['Username'] . ' </a></p>';
    echo '<p>Category: <a href="post_search.php?category=' . $post["CategoryID"] . '" class="badge rounded-pill text-bg-primary">' . $post["CategoryID"] . '</a></p>';
    echo "<p>Tags: ";
    foreach ($tags as $tag) {
        echo '<a href="post_search.php?tag=' . $tag . '" class="badge rounded-pill text-bg-secondary">' . $tag . '</a> ';
    }
    echo "</p>";
    echo "<p>{$post['Content']}</p>";
    echo "</div>";
} else {
    // Display an error message if the post doesn't exist
    echo "Post not found.";
}


?>

<div class="container mt-5">
    <h2>Add Comment</h2>
    <?php
    if (isset($_COOKIE['username'])) {
        echo '
        <form method="POST">
            <div class="mb-3">
                <label for="comment" class="form-label">Comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
            </div>
            <input type="hidden" name="UserId" value="' . $_COOKIE['userId'] . '">
            <input type="hidden" name="postId" value="' . $postId .'">
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>';
    } else {
        echo '<p>Please <a href="login.php">log in</a> to add a comment.</p>';
    }
    ?>

    <?php
        // Retrieve comments for the post
        $sql = "SELECT * FROM Comment WHERE PostId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "<h3>Comments</h3>";
            while ($comment = $result->fetch_assoc()) {
                // Lookup the username from the User table
                $sql = "SELECT Username FROM User WHERE UserID = ?";
                $stmtu = $conn->prepare($sql);
                $stmtu->bind_param("i", $comment['UserId']);
                $stmtu->execute();
                $resultu = $stmtu->get_result();
                $user = $resultu->fetch_assoc();
                $stmtu->close();

                echo "<div class='card mb-3'>";
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>{$user['Username']}</h5>";
                echo "<p class='card-text'>{$comment['Comment']}</p>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No comments yet.</p>";
        }

        $stmt->close();
// Close the database connection

    ?>

    <?php 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the comment data from the form
        $postId = $_POST['postId'];
        $userId = $_POST['UserId'];
        $comment = $_POST['comment'];

        // Check if the post exists
        $sql = "SELECT * FROM Post WHERE PostID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Insert the comment into the database
            $sql = "INSERT INTO Comment (PostId, UserId, Comment) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iis", $postId, $userId, $comment);
            $stmt->execute();
            $stmt->close();
            
            // Reload the page to display the new comment
            echo "<meta http-equiv='refresh' content='0'>";
            exit();
        } else {
            // Display an error message if the post doesn't exist
            echo "Post not found.";
        }
    }
    $conn->close();
    ?>
</div>

</body>
</html>