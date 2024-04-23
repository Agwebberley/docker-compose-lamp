<head>
    <title>Search Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h1>Search Blog Posts</h1>
<?php include 'navbar.php'; ?>
<?php
include 'db_connect.php';

function searchPosts($keyword) {
    global $conn;
    
    // Prepare the SQL statement using a parameterized query
    $sql = "SELECT * FROM Post WHERE Title LIKE ? OR Content LIKE ?";
    $stmt = $conn->prepare($sql);

    // Bind the keyword to the prepared statement
    $keyword = "%$keyword%";
    $stmt->bind_param("ss", $keyword, $keyword);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all the rows and return the result
    $posts = [];
    while($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }

    // Close the statement
    $stmt->close();

    return $posts;
}

function displayPosts($posts) {
    echo '<div class="container-fluid">';
    echo '<div class="row" style="padding: 20px;">';
    foreach ($posts as $row) {
        echo '<div class="col-md">';
        echo '<div class="card" style="width: 18rem; padding: 10px;">'; // Add padding to the card

        // Display the image in the card
        echo '<img src="https://picsum.photos/id/' . $row["PostID"] . '/200" class="card-img-top" alt="Random Image">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title"><a href=post_details.php?PostID=' . $row["PostID"] . '>' . $row["Title"] . '</a></h5>';
        echo '<p class="card-text">' . substr($row["Content"], 0, 100) . '...</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }
    echo '<div style="padding-bottom: 20px;"></div>'; // Add padding between rows
    echo '</div>';
    echo '</div>';
}

// Get the keyword from the GET request
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    // Validate the keyword
    if (!empty($keyword) && ctype_alnum($keyword)) {
        // Call the searchPosts function with the keyword
        $posts = searchPosts($keyword);
        displayPosts($posts);
    }
} elseif (isset($_GET['category'])) {
    $categoryName = $_GET['category'];
    // Validate the category name
    if (!empty($categoryName)) {
        // Convert category name to category ID
        $sql = "SELECT CategoryID FROM Category WHERE CategoryName = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $categoryName);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $categoryId = $row['CategoryID'];
        $stmt->close();

        // Prepare the SQL statement using a parameterized query
        $sql = "SELECT * FROM Post WHERE CategoryID = ?";
        $stmt = $conn->prepare($sql);

        // Bind the category ID to the prepared statement
        $stmt->bind_param("i", $categoryId);

        // Execute the query
        $stmt->execute();
        $result = $stmt->get_result();

        // Fetch all the rows and return the result
        $posts = [];
        while($row = $result->fetch_assoc()) {
            $posts[] = $row;
        }

        // Close the statement
        $stmt->close();

        displayPosts($posts);
    }
} elseif (isset($_GET['tag'])) {
        $tagName = $_GET['tag'];
        // Validate the tag name
        if (!empty($tagName)) {
            // Convert tag name to tag ID
            $sql = "SELECT TagID FROM Tag WHERE TagName = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $tagName);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $tagId = $row['TagID'];
            $stmt->close();
            // Prepare the SQL statement using a parameterized query
            $sql = "SELECT p.* FROM Post p INNER JOIN PostTag pt ON p.PostID = pt.PostID WHERE pt.TagID = ?";
            $stmt = $conn->prepare($sql);
            // Bind the tag ID to the prepared statement
            $stmt->bind_param("i", $tagId);
            // Execute the query
            $stmt->execute();
            $result = $stmt->get_result();
            // Fetch all the rows and return the result
            $posts = [];
            while($row = $result->fetch_assoc()) {
                $posts[] = $row;
            }
            // Close the statement
            $stmt->close();
            displayPosts($posts);
    }
} elseif (isset($_GET['user'])) {

        
    // User is passed in as the ID
    $userId = $_GET['user'];
    // Prepare the SQL statement using a parameterized query
    $sql = "SELECT * FROM Post WHERE UserID = ?";
    $stmt = $conn->prepare($sql);
    // Bind the user ID to the prepared statement
    $stmt->bind_param("i", $userId);
    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();
    // Fetch all the rows and return the result
    $posts = [];
    while($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
    // Close the statement
    $stmt->close();
    displayPosts($posts);
} else {
    echo "No search keyword, tag, user, or category provided";
}
            

$conn->close();
?>
