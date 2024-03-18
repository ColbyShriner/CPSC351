<?php
session_start();

include("connection.php");
include("functions.php");

// Define an array of majors
$majors = [
    "Accounting", "American Studies", "Anthropology", "Art History", "Biochemistry", "Biology", "Chemistry", "Classical Studies", "Communication", "Computer Engineering", "Computer Science", "Criminology", "Cybersecurity", "Economics", "Electrical Engineering", "English", "Environmental Studies", "Finance", "French", "German", "Global Commerce and Culture", "History", "Information Science", "Interdisciplinary Studies", "International Affairs", "Kinesiology", "Leadership Studies", "Management", "Marketing", "Mathematics", "Mathematics - Computational and Applied", "Music", "Neuroscience", "Philosophy", "Physics", "Political Science", "Psychology", "Social Work", "Sociology", "Spanish", "Studio Art", "Theater", "Writing"
];
$minors = [
    "African-American Studies" , "American Studies", "Anthropology", "Art History", "Biology", "Business" ,"Administration" ,"Chemistry" ,"Childhood Studies" ,"Chinese Studies" ,"Civic Engagement and Social Justice", "Classical Studies", "Communication", "Computer Science", "Dance", "Data Science", "Digital Humanities", "Economics", "English", "Environmental Studies", "Film Studies", "French", "Geography", "German", "Graphic Design", "Greek Studies","History", "Health", "Medical and Wellness Studies", "Human Rights and Conflict Resolution", "Information Science", "International Culture and Business", "Judeo-Christian Studies", "Journalism", "Latin", "Latin American Studies", "Leadership Studies", "Linguistics", "Literature", "Mathematics", "Medieval and Renaissance Studies", "Middle East and North Africa Studies", "Military Science (ROTC)", "Museum Studies", "Philosophy and Religion", "Philosophy of Law", "Photography and Video Art", "Physics", "Political",  "Science", "Psychology", "Sociology", "Spanish", "Studio Art", "Theater", "U.S. National Security Studies", "Women, Gender and Sexuality Studies", "Writing"

];



if($_SERVER['REQUEST_METHOD'] == "POST") {
    //something was posted
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL); // Sanitize email input
    $graduation_year = $_POST['graduation_year'];
    $major = $_POST['major'];
    $minor = isset($_POST['minor']) ? $_POST['minor'] : ''; // Optional minor field

    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } else {
        // Check if email already exists in the database
        $query = "SELECT * FROM users WHERE email='$email'";
        $result = mysqli_query($con, $query);
        if(mysqli_num_rows($result) > 0) {
            // Email already exists
            echo "Email already exists. Please choose a different email.";
        } else {
            if (!empty($user_name) && !empty($password) && !is_numeric($user_name)) {
                //save to database
                $user_id = random_num(10);
                $query = "INSERT INTO users (user_id, user_name, password, email, graduation_year, major, minor) VALUES ('$user_id', '$user_name', '$password', '$email', '$graduation_year', '$major', '$minor')";
                mysqli_query($con, $query);
                
                // Send confirmation email
                $to = $email;
                $subject = "Confirmation Email";
                $message = "Thank you for signing up! Please click the link below to confirm your email address.\n\n";
                $message .= "Confirmation Link: http://example.com/confirm.php?email=" . urlencode($email);
                $headers = "From: nobu.19285@gmail.com\r\n";
                $headers .= "Reply-To: $email\r\n";
                $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
                
                if (mail($to, $subject, $message, $headers)) {
                    echo "Confirmation email sent successfully.";
                } else {
                    echo "Failed to send confirmation email.";
                }
                
                header("Location: login.php");
                die;
            } else {
                echo "Your user name cannot be a number!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        #box {
            background-color: blue;
            margin: auto;
            width: 300px;
            padding: 20px;
        }
        #text {
            height: 25px;
            border-radius: 5px;
            padding: 4px;
            border: solid thin #aaa;
        }
        #button {
            padding: 10px;
            width: 100px;
            color: white;
            background-color: lightblue;
            border: none;
        }
    </style>
</head>
<body>
    <div id="box">
        <form method="post">
            <div style="font-size: 20px;margin: 10px;">Sign up</div>
            <input type="text" name="user_name" id="text" placeholder="Username"><br><br>
            <input type="password" name="password" id="text" placeholder="Password"><br><br>
            <input type="email" name="email" id="text" placeholder="Email"><br><br>
            <select name="graduation_year" id="text">
            	<option value="null">Select Graduation Year</option>
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
                <option value="2026">2026</option>
            </select><br><br>
            <select name="major" id="text">
            	<option value="null">Select Major</option>
                <?php
                foreach ($majors as $major) {
                    echo "<option value='$major'>$major</option>";
                }
                ?>
            </select><br><br>
            <select name="minor" id="text">
            	<option value="null">Select Minor (Optional)</option>
                <?php
                foreach ($minors as $minor) {
                    echo "<option value='$minor'>$minor</option>";
                }
                ?>
            </select><br><br>
            <input type="submit" value="Signup" id="button"><br><br>
            <a href="login.php">Click to Login</a><br><br>
        </form>
    </div>
    <header>
<header>
  <img src="cnu.jpg" alt="CNU Logo" id="cnu-logo">
</header>
<script src="scripts.js"></script>
</body>
</html>
