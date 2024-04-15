<?php
session_start();

include("connection.php");
include("functions.php");

if(isset($_SESSION['user_id'])) {
    // Fetch user data from the database
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE user_id='$user_id'";
    $result = mysqli_query($con, $query);
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $full_name = $row['user_name'];
        $email = $row['email'];
        $major = $row['major'];
        $minor = $row['minor'];
        $graduation_year = $row['graduation_year'];
        $user_id = $row['user_id'];
    }
} else {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        #box {
            background-color: blue;
            margin: auto;
            width: 300px;
            padding: 20px;
            color: white;
        }
        #text {
            height: 25px;
            border-radius: 5px;
            padding: 4px;
            border: solid thin #aaa;
            margin-bottom: 10px;
        }
        #button {
            padding: 10px;
            width: 100px;
            color: white;
            background-color: lightblue;
            border: none;
        }
        a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<header>
  <img src="cnu.jpg" alt="CNU Logo" id="cnu-logo">
  <nav>
    <ul>
      <li><a href="index.php">Home</a></li>
      <li><a href="add_friend.php">Networking</a></li>
      <li><a href="post_subsystem.php">Posts</a></li>
      <li><a href="calendar.php">Calendar</a></li>

    </ul>
   </nav>
</header>

<body>
    <div id="box">
        <h1>Welcome, <?php echo $full_name; ?>!</h1>
        <p><strong>User ID:</strong> <?php echo $user_id; ?></p>
        <p><strong>Email:</strong> <?php echo $email; ?></p>
        <p><strong>Major:</strong> <?php echo $major; ?></p>
		<?php if($minor !== "null") { ?>
    		<p><strong>Minor:</strong> <?php echo $minor; ?></p>
		<?php } ?>
        <p><strong>Graduation Year:</strong> <?php echo $graduation_year; ?></p>
        <p><a href="logout.php">Logout</a></p>
    </div>
</body>
</html>