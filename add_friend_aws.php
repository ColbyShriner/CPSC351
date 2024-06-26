<!-- Database Connection -->
<?php
$db_host = "rds endpoint";
$db_user = "rds username";
$db_password = "rds password";
$db_name = "rds database name";

$dbc = mysqli_connect($db_host, $db_user, $db_password, $db_name);

if (!$dbc) {
    die("Connection Failed: " . mysqli_connect_error());
}
?>

<!-- Section for networking in the main content -->
<section id="networking">
    <h1>Networking</h1>

    <!-- Friend Request -->
    <form action="networking.php" method="post">
        <label for="friend_username">Friend's Username:</label>
        <input type="text" name="friend_username" required>
        <br>
        <input type="submit" name="add_friend" value="Add Friend">
    </form>

    <!-- Display Friends -->
    <h2>Your Friends:</h2>
    <?php
    // insert database connection below

    // IF WE HAVE users table with a column "users"
    $query = "SELECT * FROM INSERT TABLE NAME";
    $result = mysqli_query($dbc, $query);

    while ($row = mysqli_fetch_array($result)) {
        echo '<div class="friend">';
        echo '<p>Username: ' . $row['INSERT COLUMN NAME'] . '</p>';
        echo '<a href="networking.php?remove_friend=' . $row['id'] . '">Remove Friend</a>';
        echo '</div>';
    }
    ?>
</section>

<?php
// Add friend or remove friend
if (isset($_POST['add_friend'])) {
    $friend_username = mysqli_real_escape_string($dbc, trim($_POST['friend_username']));

    // Check if the friend exists
    $query = "SELECT * FROM INSERT TABLE NAME WHERE INSERT COLUMN NAME = '$friend_username'";
    $result = mysqli_query($dbc, $query);
    $friend = mysqli_fetch_assoc($result);

    if ($friend) {
        // Assuming you have a friends table with columns "INSERT COLUMN NAME" and "INSERT COLUMN NAME"
        $user_id = 1; // Replace with the current user's ID, you need to fetch it based on the logged-in user
        $friend_id = $friend['INSERT COLUMN NAME'];

        // Check if the friendship already exists
        $check_query = "SELECT * FROM INSERT TABLE NAME WHERE INSERT COLUMN NAME = $user_id AND INSERT COLUMN NAME = $friend_id";
        $check_result = mysqli_query($dbc, $check_query);

        if (mysqli_num_rows($check_result) == 0) {
            // Add the friend
            $add_query = "INSERT INTO INSERT TABLE NAME (INSERT COLUMN NAME, INSERT COLUMN NAME) VALUES ($user_id, $friend_id)";
            mysqli_query($dbc, $add_query);
        } else {
            echo 'You are already friends!';
        }
    } else {
        echo 'Friend not found.';
    }
}

// Remove friend function
if (isset($_GET['remove_friend'])) {
    $friend_id_to_remove = mysqli_real_escape_string($dbc, $_GET['remove_friend']);
    $user_id = 1; // Replace with the current user's ID, you need to fetch it based on the logged-in user

    // Remove the friend
    $remove_query = "DELETE FROM INSERT TABLE NAME WHERE INSERT COLUMN NAME = $user_id AND INSERT COLUMN NAME = $friend_id_to_remove";
    mysqli_query($dbc, $remove_query);
}
?>
