<?php
session_start();
function check_login($con) {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        
        // Query to get user data from the database based on the user ID
        $query = "SELECT * FROM users WHERE user_id = $user_id";
        $result = mysqli_query($con, $query);
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            return $user_data;
        } else {
            header("Location: login.php");
            exit();
        }
    } else {
        header("Location: login.php");
        exit();
    }
}

include_once "connection.php";

if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}
$user_data = check_login($con);
if (!$con) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Add friend or remove friend functionality
if (isset($_POST['add_friend'])) {
    $friend_username = mysqli_real_escape_string($con, trim($_POST['friend_username']));

    // Check if the friend exists in the database
    $query = "SELECT * FROM users WHERE user_name = '$friend_username'";
    $result = mysqli_query($con, $query);
    $friend = mysqli_fetch_assoc($result);

    if ($friend) {
        // Get current user's ID
        $user_id = $user_data['user_id'];
        // Check if the friendship already exists
        $friend_id = $friend['user_id']; 
        $check_query = "SELECT * FROM friends WHERE user_id = $user_id AND friend_id = $friend_id";
        $check_result = mysqli_query($con, $check_query);

        if (mysqli_num_rows($check_result) == 0) {
            // Add the friend
            $add_query = "INSERT INTO friends (user_id, friend_id) VALUES ($user_id, $friend_id)";
            mysqli_query($con, $add_query);
        } else {
            echo 'You are already friends!';
        }
    } else {
        echo 'Friend not found.';
    }
}

// Remove friend functionality
if (isset($_GET['remove_friend'])) {
    $friend_id_to_remove = mysqli_real_escape_string($con, $_GET['remove_friend']);
    $user_id = $user_data['user_id'];

    // Remove the friend
    $remove_query = "DELETE FROM friends WHERE user_id = ? AND friend_id = ?";
    $stmt = mysqli_prepare($con, $remove_query);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $friend_id_to_remove);
    mysqli_stmt_execute($stmt);
}

// Display friends
$user_id = $user_data['user_id'];
$query = "SELECT u.user_id, u.user_name FROM users u JOIN friends f ON u.user_id = f.friend_id WHERE f.user_id = $user_id";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNU Alumni Connect - Add Friend</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<header>
    <img src="cnu.jpg" alt="CNU Logo" id="cnu-logo">
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="post_subsystem.php">Posts</a></li>
            <li><a href="calendar.php">Calendar</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>

        <div class="login-section">
            <div class="profile-image"></div>
            <a href="logout.php" class="login-text">Logout</a>
        </div>

</header>
<main>
    <section id="networking">
        <h1>Networking</h1>

        <!-- Friend Request Form -->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <label for="friend_username">Friend's Username:</label>
            <input type="text" name="friend_username" required>
            <br>
            <input type="submit" name="add_friend" value="Add Friend">
        </form>

        <!-- Display Friends -->
        <h2>Your Friends:</h2>
<?php
while ($row = mysqli_fetch_array($result)) {
    echo '<div class="friend">';
    echo '<p>Username: ' . $row['user_name'] . '</p>';
    
echo '<a href="add_friend.php?remove_friend=' . $row['user_id'] . '" style="color: blue;">Remove Friend</a>';
    echo '</div>';
}
?>
    </section>
</main>
</body>
</html>