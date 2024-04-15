<?php
session_start();
include("connection.php");
include("functions.php");

// Check if the user is logged in
$user_data = check_login($con);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNU Alumni Connect - Job Listings</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Your existing CSS styles */

        /* Style for container holding job listings */
        .job-listings-container {
            margin-top: 20px; /* Adjust margin to your preference */
            max-height: 70vh; /* Set maximum height for the container */
            overflow-y: auto; /* Enable vertical scrolling when needed */
            border: 1px solid #ccc; /* Add border for clarity */
            padding: 10px; /* Add padding for better spacing */
        }
    </style>
</head>
<body>
<header>
  <img src="cnu.jpg" alt="CNU Logo" id="cnu-logo">
  <nav>
    <ul>
      <li><a href="job_listings.php">Back to Job Post</a></li>
    </ul>
  </nav>
</header>
<main>
    <!-- Container for Job Listings -->
    <div class="job-listings-container">
        <!-- Display Job Listings -->
        <ul>
            <?php
            // Retrieve job listings from the database
            $query = "SELECT * FROM job_listings ORDER BY job_title";
            $result = mysqli_query($con, $query);

            // Display job listings
            while ($row = mysqli_fetch_array($result)) {
                echo '<li class="job-listing">';
                echo '<h3 style="color: white;">' . $row['job_title'] . '</h3>';
                echo '<p>Company: ' . $row['company'] . '</p>';
                echo '<p>Description: ' . $row['description'] . '</p>';
                echo '<p>Contact Email: ' . $row['contact_email'] . '</p>';
                echo '<button class="apply-btn">Apply(coming soon)</button>';
                echo '</li>';
            }

            // Close connection
            mysqli_close($con);
            ?>
        </ul>
    </div>
</main>
</body>
</html>