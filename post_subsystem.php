


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
    <h1>Welcome to CNU Alumni Connect!</h1>
    <!-- Post Form -->
    <form action="your_php_script.php" method="post" enctype="multipart/form-data">
        <label for="post">Share your update:</label>
        <textarea name="post" id="post" rows="4" cols="50" required></textarea>
        <br>
        <label for="image">Upload Image (optional):</label>
        <input type="file" name="image" accept="image/*">
        <br>
        <input type="submit" name="submit" value="Share">
    </form>
	    <?php
// Connect to the database

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "351project";
$port = 3366;

$dbc = mysqli_connect($servername, $username, $password, $dbname, $port);

// Check connection
if (!$dbc) {
    die("Connection failed: " . mysqli_connect_error());
}

// Insert post into the database
if (isset($_POST['submit'])) {
    $post = mysqli_real_escape_string($dbc, trim($_POST['post']));

    // Handle image upload if provided
    $image_path = ''; // You may need to define a path for storing images
    if ($_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path . $image_name);
        $image_path = $image_path . $image_name;
    }

    // Insert post into the database
    $query = "INSERT INTO posts (post, image_path) VALUES ('$post', '$image_path')";
    mysqli_query($dbc, $query);
}

// Retrieve posts from the database
$query = "SELECT * FROM post ORDER BY id DESC";
$result = mysqli_query($dbc, $query);

// Display posts
while ($row = mysqli_fetch_array($result)) {
    echo '<div class="post">';
    echo '<p>' . $row['post'] . '</p>';
    if (!empty($row['image_path'])) {
        echo '<img src="' . $row['image_path'] . '" alt="Posted Image">';
    }
    echo '</div>';
}

// Close the database connection
mysqli_close($dbc);
?>


    
</main>
<script src="script.js"></script>
</body>
</html>

