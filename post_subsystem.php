


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
    <form action="post_subsystem.php" method="post" enctype="multipart/form-data">
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
    // Retrieve the AccountID of the logged-in user (replace this with your session mechanism)
    $accountID = 1; // Replace with the actual AccountID of the logged-in user

    // Check if the AccountID exists in the account table
    $check_query = "SELECT * FROM account WHERE AccountID = $accountID";
    $check_result = mysqli_query($dbc, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // AccountID exists, proceed with inserting the post
        $postTitle = mysqli_real_escape_string($dbc, $_POST['post']);
        // Assuming you don't have a separate field for post content in your form
        $postContent = ""; // You haven't provided a field for post content in your form

        // Handle image upload if provided
        $image_path = ''; // You may need to define a path for storing images
        if ($_FILES['image']['error'] == 0) {
            $image_name = $_FILES['image']['name'];
            $image_path = $image_path . $image_name;
            move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
        }

        // Insert post into the database
        $query = "INSERT INTO POST (`Post Title`, `Post Content`, `Image_Path`, `Date Posted`, `ACCOUNT_AccountID`) VALUES ('$postTitle', '$postContent', '$image_path', NOW(), $accountID)";

        if (mysqli_query($dbc, $query)) {
            echo "Post added successfully.";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($dbc);
        }
    } else {
        // AccountID doesn't exist in the account table, handle the error gracefully
        echo "Error: The logged-in user's AccountID doesn't exist.";
    }
}

// Retrieve posts from the database
$query = "SELECT * FROM POST ORDER BY `Date Posted` DESC";
$result = mysqli_query($dbc, $query);

// Display posts
while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="post">';
    echo '<h2>' . $row['Post Title'] . '</h2>';
    echo '<p>' . $row['Post Content'] . '</p>';
    echo '<p>Date Posted: ' . $row['Date Posted'] . '</p>';
    // Display image if available
    if (!empty($row['Image_Path'])) {
        echo '<img src="' . $row['Image_Path'] . '" alt="Posted Image">';
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

