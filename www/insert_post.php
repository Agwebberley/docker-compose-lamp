<?php
include 'db_connect.php';

$title = $_POST['title'];
$content = $_POST['content'];
$userid = $_POST['userid']; // Assuming user id is known
$categoryid = $_POST['category']; // Assuming category id is known
$tags = $_POST['hidden-tags'];

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO Post (UserID, Title, Content, CategoryID) VALUES (?, ?, ?, ?)");
$stmt->bind_param("isss", $userid, $title, $content, $categoryid);

if ($stmt->execute()) {
    // Get the ID of the newly inserted post
    $postId = $stmt->insert_id;

    // Insert tags into the PostTag table
    $tagArray = explode(',', $tags);
    foreach ($tagArray as $tag) {
        $tag = trim($tag);
        // Check if the tag already exists
        $tagExistsStmt = $conn->prepare("SELECT TagID FROM Tag WHERE TagName = ?");
        $tagExistsStmt->bind_param("s", $tag);
        $tagExistsStmt->execute();
        $tagExistsResult = $tagExistsStmt->get_result();
        
        if ($tagExistsResult->num_rows > 0) {
            // Tag already exists, get its ID
            $tagRow = $tagExistsResult->fetch_assoc();
            $tagId = $tagRow['TagID'];
        } else {
            // Tag does not exist, create it
            $createTagStmt = $conn->prepare("INSERT INTO Tag (TagName) VALUES (?)");
            $createTagStmt->bind_param("s", $tag);
            $createTagStmt->execute();
            $tagId = $createTagStmt->insert_id;
            $createTagStmt->close();
        }
        
        // Insert tag into the PostTag table
        $tagStmt = $conn->prepare("INSERT INTO PostTag (PostID, TagID) VALUES (?, ?)");
        $tagStmt->bind_param("ii", $postId, $tagId);
        $tagStmt->execute();
        $tagStmt->close();
    }


    // Redirect to get_posts.php
    header("Location: get_posts.php");
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
?>
