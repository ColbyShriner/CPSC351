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
        .job-listing {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            overflow: hidden; 
        }

        .job-listing img {
            float: left;
            margin-right: 10px;
            max-width: 100px; 
            max-height: 100px; 
        }

        .job-listing h2 {
            margin-top: 0;
        }

        .job-listing p {
            margin-bottom: 5px;
        }


        .btn {
            display: inline-block;
            padding: 8px 16px;
            margin-right: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<header>
    <img src="cnu.jpg" alt="CNU Logo" id="cnu-logo">
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="add_friend.php">Networking</a></li>
            <li><a href="post_subsystem.php">Posts</a></li>
            <li><a href="calendar.php">Calendar</a></li>
            <li><a href="profile.php">Profile</a></li>
        </ul>

        <div class="login-section">
            <div class="profile-image"></div>
            <a href="logout.php" class="login-text">Logout</a>
        </div>
    </nav>
</header>
<main>
    <h1>Welcome to CNU Alumni Connect - Job Listings!</h1>

    <!-- Job Listing Form -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label for="job_title">Job Title:</label>
        <input type="text" name="job_title" required>
        <br>
        <label for="company">Company:</label>
        <input type="text" name="company" required>
        <br>
        <label for="description">Job Description:</label>
        <textarea name="description" rows="4" cols="50" required></textarea>
        <br>
        <label for="contact_email">Contact Email:</label>
        <input type="email" name="contact_email" required>
        <br>
        <input type="submit" name="submit" value="Post Job Listing">
        <!-- New button to navigate to "job_list.php" -->
        <a href="job_list.php" class="btn">View Job List</a>
    </form>

    <?php
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $job_title = mysqli_real_escape_string($con, $_POST['job_title']);
        $company = mysqli_real_escape_string($con, $_POST['company']);
        $description = mysqli_real_escape_string($con, $_POST['description']);
        $contact_email = mysqli_real_escape_string($con, $_POST['contact_email']);

        // Insert job listing into the database
        $query = "INSERT INTO job_listings (job_title, company, description, contact_email) VALUES ('$job_title', '$company', '$description', '$contact_email')";
        if (mysqli_query($con, $query)) {
            echo "<p>Job listing posted successfully!</p>";
        } else {
            echo "Error: " . $query . "<br>" . mysqli_error($con);
        }
    }

    // Retrieve job listings from the database
    $query = "SELECT * FROM job_listings ORDER BY job_title";
    $result = mysqli_query($con, $query);

    mysqli_close($con);
    ?>
    <script src="script.js"></script>
</main>
</body>
</html>