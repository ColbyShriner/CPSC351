<?php
session_start();

include("connection.php");
include("functions.php");

$user_data = check_login($con);

// Check if the user is logged in
if (isset($user_data['user_id'])) {
    $login_link = "logout.php"; // If logged in, set link to logout.php
    $login_text = "Logout";
} else {
    $login_link = "login.php"; // If not logged in, set link to login.php
    $login_text = "Login";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CNU Alumni Connect</title>
<link rel="stylesheet" href="styles.css">
<style>
  #userId {
    position: fixed;
    bottom: 10px;
    right: 10px;
    color: white;
    font-size: 16px;
  }
</style>
</head>
<body>
<header>
  <img src="cnu.jpg" alt="CNU Logo" id="cnu-logo">
  <nav>
    <ul>
      <li><a href="add_friend.php">Friends</a></li>
      <li><a href="post_subsystem.php">Posts</a></li>
      <li><a href="calendar.php">Calendar</a></li>
      <li><a href="job_listings.php">Jobs</a></li>
      <li><a href="profile.php">Profile</a></li>
    </ul>
    <?php if (isset($user_data['user_id'])): ?>
      <div id="userId">User ID: <?php echo $user_data['user_id']; ?></div>
    <?php endif; ?>
    <div class="login-section">
      <div class="profile-image"></div>
      <a href="<?php echo $login_link; ?>" class="login-text"><?php echo $login_text; ?></a>
    </div>

  </nav>
</header>
<main>
  <h1>Hello <?php echo $user_data['user_name']; ?>, <br> Welcome to CNU Alumni Connect!</h1>
</main>
<script src="script.js"></script>
</body>
</html>