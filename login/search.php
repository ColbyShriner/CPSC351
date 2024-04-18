<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNU Alumni Connect - Search</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <img src="cnu.jpg" alt="CNU Logo" id="cnu-logo">
    <nav>
        <ul>
            <li><a href="networking.php">Networking</a></li>
            <li><a href="posts.php">Posts</a></li>
            <li><a href="search.php">Search</a></li> <!-- Added Search link -->
        </ul>
        <div class="login-section">
            <div class="profile-image"></div>
            <a href="#login" class="login-text">Login</a>
        </div>
        <div id="search-container">
            <form action="search.php" method="get"> <!-- Use GET method for search -->
                <input type="search" id="search-bar" name="query" placeholder="Search...">
                <input type="submit" value="Search">
            </form>
        </div>
    </nav>
</header>
<main>
    <h1>Search Results</h1>

    <?php
    // Connect to the database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "database351";
    $port = 3306;

    $dbc = mysqli_connect($servername, $username, $password, $dbname, $port);

    // Check connection
    if (!$dbc) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Handle search query
    if (isset($_GET['query'])) {
        $search_query = mysqli_real_escape_string($dbc, trim($_GET['query']));

        // Query to search posts
        $search_query = "%$search_query%";
        $query = "SELECT * FROM posts WHERE post LIKE '$search_query' ORDER BY id DESC";
        $result = mysqli_query($dbc, $query);

        // Display search results
        while ($row = mysqli_fetch_array($result)) {
            echo '<div class="post">';
            echo '<p>' . $row['post'] . '</p>';
            if (!empty($row['image_path'])) {
                echo '<img src="' . $row['image_path'] . '" alt="Posted Image">';
            }
            echo '</div>';
        }
    }

    // Close the database connection
    mysqli_close($dbc);
    ?>

</main>
<script src="script.js"></script>
</body>
</html>