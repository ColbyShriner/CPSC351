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

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Create connection
    $con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare and bind
    $stmt = $con->prepare("INSERT INTO POST (user_id, Post_Title, Post_Content, Date_Posted, Image_Path) VALUES (?, ?, ?, NOW(), ?)");
    $stmt->bind_param("isss", $userId, $title, $content, $imagePath);

    // Set parameters and execute
    session_start();
    $userId = $_SESSION['user_id'];
    $title = $_POST['post'];
    $content = $_POST['post']; // Assuming you want to use the same content for both title and content
    $imagePath = ''; // Placeholder for image path

    // Check if an image was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imagePath = 'C:/xampp/htdocs/CPSC351/login/uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    // Execute the statement
    try {
        if ($stmt->execute()) {
            echo "New post added successfully.";
        } else {
            echo "Error: Unable to add new post.";
        }
    } catch (mysqli_sql_exception $e) {
        echo "Error: " . $e->getMessage(); // Display specific error message
    }

    // Close statement and connection
    $stmt->close();
    $con->close();
}

// Connect to the database
$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Retrieve posts from the database with user details
$query = "SELECT POST.*, users.user_name FROM POST LEFT JOIN users ON POST.user_id = users.id ORDER BY `Date_Posted` DESC";
$result = mysqli_query($con, $query);

// Close the database connection
mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNU Alumni Connect</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        /* Your existing CSS styles */

        /* Style for container holding posts */
        .post-container {
            margin-top: 20px; /* Adjust margin to your preference */
            max-height: 70vh; /* Set maximum height for the container */
            overflow-y: auto; /* Enable vertical scrolling when needed */
            border: 1px solid #ccc; /* Add border for clarity */
            padding: 10px; /* Add padding for better spacing */
        }

        /* Additional styling for individual posts can be added here */
        .post {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<header>
    <img src="cnu.jpg" alt="CNU Logo" id="cnu-logo">
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="add_friend.php">Networking</a></li>
            <li><a href="post_subsystem.php">Posts</a></li>
            <li><a href="calendar.php">Calendar</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>
    </nav>
</header>
<main>
<div class="left-column">
    <h2><a href="create_post.php" style="color: white; text-decoration: none;">Add a Post</a></h2>
    <!-- Your existing form goes here -->
</div>
    </div>
    <div class="right-column">
        <h1>Welcome to CNU Alumni Connect!</h1>
        <!-- Container for displaying posts -->
        <div class="post-container">
            <?php
            // Display posts
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="post">';
                echo '<h2>' . $row['Post_Title'] . '</h2>';
                echo '<p>Posted by: ' . $row['user_name'] . '</p>';
                echo '<p>' . $row['Post_Content'] . '</p>';
                echo '<p>Date Posted: ' . $row['Date_Posted'] . '</p>';
                // Display image if available
                if (!empty($row['Image_Path'])) {
                    echo '<div class="image-container">';
                    echo '<img src="' . $row['Image_Path'] . '" alt="Posted Image" class="posted-image">';
                    echo '</div>';
                }
                // Allow deletion only for user's own posts
                if ($row['user_id'] == ['user_id'] ) { 
                    echo '<button class="delete-btn" data-id="' . $row['PostID'] . '">Delete</button>';
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>
</main>
<script>
$(document).ready(function(){
    $(".delete-btn").click(function(){
        var postId = $(this).data("id");
        $.ajax({
            url: "delete_post.php",
            type: "GET",
            data: { delete: true, id: postId },
            success: function(response) {
                alert(response);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("Error: Unable to delete post."); 
            }
        });
    });
});
</script>
</body>
</html>