<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "351project";
$port = 3366;

// Check if form is submitted
if (isset($_POST['submit'])) {
    // Create connection
    $dbc = mysqli_connect($servername, $username, $password, $dbname, $port);

    // Check connection
    if (!$dbc) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Prepare and bind
    $stmt = $dbc->prepare("INSERT INTO POST (ACCOUNT_AccountID, Post_Title, Post_Content, Date_Posted, Image_Path) VALUES (?, ?, ?, NOW(), ?)");
    $stmt->bind_param("isss", $accountId, $title, $content, $imagePath);

    // Set parameters and execute
    $accountId = 1; // Replace 1 with a valid AccountID from your account table
    $title = $_POST['post'];
    $content = $_POST['post']; // Assuming you want to use the same content for both title and content
    $imagePath = ''; // Placeholder for image path

    // Check if an image was uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        $imagePath = 'uploads/' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo "New post added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $dbc->close();
}

// Connect to the database
$dbc = mysqli_connect($servername, $username, $password, $dbname, $port);

// Check connection
if (!$dbc) {
    die("Connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully."; // Debugging: Confirm database connection
}

// Retrieve posts from the database
$query = "SELECT * FROM POST ORDER BY `Date_Posted` DESC";
$result = mysqli_query($dbc, $query);

// Close the database connection
mysqli_close($dbc);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNU Alumni Connect</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <img src="cnu.jpg" alt="CNU Logo" id="cnu-logo">
    <nav>
        <ul>
            <li><a href="#networking">Networking</a></li>
            <li><a href="#posts">Posts</a></li>
        </ul>
        <div class="login-section">
            <div class="profile-image"></div>
            <a href="#login" class="login-text">Login</a>
        </div>
        <div id="search-container">
            <input type="search" id="search-bar" placeholder="Search...">
        </div>
    </nav>
</header>
<main>
    <div class="left-column">
        <h2>Add a Post</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <label for="post">Share your update:</label>
            <textarea name="post" id="post" rows="4" cols="50" required></textarea>
            <br>
            <label for="image">Upload Image (optional):</label>
            <input type="file" name="image" accept="image/*">
            <br>
            <input type="submit" name="submit" value="Share">
        </form>
    </div>
    <div class="right-column">
        <h1>Welcome to CNU Alumni Connect!</h1>
        <!-- Posts will be displayed here -->
        <?php
        // Connect to the database
        $dbc = mysqli_connect($servername, $username, $password, $dbname, $port);

        // Check connection
        if (!$dbc) {
            die("Connection failed: " . mysqli_connect_error());
        } else {
            echo "Connected successfully."; // Debugging: Confirm database connection
        }

        // Retrieve posts from the database
        $query = "SELECT * FROM POST ORDER BY `Date_Posted` DESC";
        $result = mysqli_query($dbc, $query);

        // Display posts
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="post">';
            echo '<h2>' . $row['Post_Title'] . '</h2>';
            echo '<p>' . $row['Post_Content'] . '</p>';
            echo '<p>Date Posted: ' . $row['Date_Posted'] . '</p>';
            // Display image if available
            if (!empty($row['Image_Path'])) {
                echo '<div class="image-container">';
                echo '<img src="' . $row['Image_Path'] . '" alt="Posted Image">';
                echo '</div>';
            }
            echo '</div>';
        }

        // Close the database connection
        mysqli_close($dbc);
        ?>
    </div>
</main>
<script src="script.js"></script>
</body>
</html>
