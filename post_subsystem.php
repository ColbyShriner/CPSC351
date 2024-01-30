<?php
// Connect to the database

$dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection
if (!$dbc) {
    die("Connection failed: " . mysqli_connect_error());
}

// Insert post into the database
if (isset($_POST['submit'])) {
    $post = mysqli_real_escape_string($dbc, trim($_POST['post']));
    $query = "INSERT INTO posts (post) VALUES ('$post')";
    mysqli_query($dbc, $query);
}

// Retrieve posts from the database
$query = "SELECT * FROM posts ORDER BY id DESC";
$result = mysqli_query($dbc, $query);

// Display posts
while ($row = mysqli_fetch_array($result)) {
    echo '<div class="post">';
    echo '<p>' . $row['post'] . '</p>';
    echo '</div>';
}

// Close the database connection
mysqli_close($dbc);
?>