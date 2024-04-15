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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNU Alumni Connect - Create Post</title>
    <link rel="stylesheet" href="styles.css">
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
<div class="left-column" style="color: white;">
    <h2 style="color: white;">Add a Post</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="post" style="color: white;">Subject:</label>
        <textarea name="post" id="post" rows="1" cols="10" required style="color: black;"></textarea>
        <br>
        <label for="post" style="color: white;">Share your update:</label>
        <textarea name="post" id="post" rows="4" cols="50" required style="color: black;"></textarea>
        <br>
        <label for="image" style="color: white;">Upload Image (optional):</label>
        <input type="file" name="image" accept="image/*" style="color: white;">
        <br>
        <input type="submit" name="submit" value="Share" style="color: black;">
    </form>
</div>
    <div class="right-column">

</main>
</body>
</html>

