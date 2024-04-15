<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "database351";

// Check if delete request is sent
if(isset($_GET['delete']) && isset($_GET['id'])) {
    // Create connection
    $con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare and bind
    $stmt = $con->prepare("SELECT user_id FROM POST WHERE PostID = ?");
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Assuming you have a function to get the currently logged-in user's ID
        $currentUserId = 1; // Replace 1 with the current user's ID
        if ($row['user_id'] == $currentUserId) {
            // The post belongs to the current user, so delete it
            $deleteStmt = $con->prepare("DELETE FROM POST WHERE PostID = ?");
            $deleteStmt->bind_param("i", $_GET['id']);
            $deleteStmt->execute();

            if ($deleteStmt->affected_rows > 0) {
                echo "Post deleted successfully.";
            } else {
                echo "Error: Unable to delete post.";
            }
        } else {
            echo "You do not have permission to delete this post.";
        }
    } else {
        echo "Post not found.";
    }

    // Close statement and connection
    $stmt->close();
    $con->close();
}
?>
