<?php
session_start();

	include("connection.php");
	include("functions.php");

	$user_data = check_login($con);


	$_SESSION;
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
	<div class="logout-section">
		<div class="profile-image"></div>
		<a href="logout.php" class="logout-text">Logout</a>
	</div>
    <div id="search-container">
      <input type="search" id="search-bar" placeholder="Search...">
    </div>
  </nav>
</header>
<main>
  <h1>Hello <?php echo $user_data['user_name']; ?>, <br> Welcome to CNU Alumni Connect!</h1>

</main>
<script src="scripts.js"></script>
</body>
</html>

