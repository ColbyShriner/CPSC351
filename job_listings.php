<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CNU Alumni Connect - Job Listings</title>
    <style>
        .job-listing {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 20px;
            overflow: hidden; /* to contain the floated image */
        }

        .job-listing img {
            float: left;
            margin-right: 10px;
            max-width: 100px; /* adjust the width as needed */
            max-height: 100px; /* adjust the height as needed */
        }

        .job-listing h2 {
            margin-top: 0;
        }

        .job-listing p {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
<header>

    <img src="cnu.jpg" alt="CNU Logo" id="cnu-logo">
    <nav>
        <ul>
            <li><a href="#networking">Networking</a></li>
            <li><a href="#job-listings">Job Listings</a></li>
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
    <h1>Welcome to CNU Alumni Connect - Job Listings!</h1>

    <!-- Job Listing Form -->
    <form action="job_listings.php" method="post">
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
    </form>

<?php
session_start();

// Include your database connection here
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ProjectDB";
$port = 3366;

$dbc = mysqli_connect($servername, $username, $password, $dbname, $port);

// Check if the form is submitted and the session variable is not set
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_SESSION['form_submitted'])) {
    $job_title = mysqli_real_escape_string($dbc, $_POST['job_title']);
    $company = mysqli_real_escape_string($dbc, $_POST['company']);
    $description = mysqli_real_escape_string($dbc, $_POST['description']);
    $contact_email = mysqli_real_escape_string($dbc, $_POST['contact_email']);

    // Insert job listing into the database
    $query = "INSERT INTO job_listings (job_title, company, description, contact_email) VALUES ('$job_title', '$company', '$description', '$contact_email')";
    mysqli_query($dbc, $query);

    // Set session variable to mark form submission
    $_SESSION['form_submitted'] = true;

    // Redirect to prevent form resubmission
    header("Location: {$_SERVER['REQUEST_URI']}");
    exit();
}

// Retrieve job listings from the database
$query = "SELECT * FROM job_listings ORDER BY job_title";
$result = mysqli_query($dbc, $query);

// Display job listings
while ($row = mysqli_fetch_array($result)) {
    echo '<div class="job-listing">';
    echo '<h2>' . $row['job_title'] . '</h2>';
    echo '<p>Company: ' . $row['company'] . '</p>';
    echo '<p>Description: ' . $row['description'] . '</p>';
    echo '<p>Contact Email: ' . $row['contact_email'] . '</p>';
    // Add a hide button
    echo '<button class="hide-btn">Hide</button>';
    echo '</div>';
}

// Close connection
mysqli_close($dbc);
?>
    <script>
        // JavaScript for hiding job listings
        const hideButtons = document.querySelectorAll('.hide-btn');
        hideButtons.forEach(button => {
            button.addEventListener('click', () => {
                button.parentNode.style.display = 'none';
            });
        });
    </script>
</main>
</body>
</html>
