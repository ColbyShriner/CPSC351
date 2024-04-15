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
    $confirm_password = $_POST['confirm_password'];
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL); // Sanitize email input
    $graduation_year = $_POST['graduation_year'];
    $major = $_POST['major'];
    $minor = isset($_POST['minor']) ? $_POST['minor'] : ''; // Optional minor field

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "Passwords do not match.";
        exit; // Stop further execution
    }
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
        #login-button {
            padding: 10px;
            width: 100px;
            color: white;
            background-color: lightblue;
            border: none;
            text-align: center;
            display: block;
            margin: auto;
            margin-top: 10px;
            text-decoration: none; /* Added to remove underline */
            cursor: pointer; /* Change cursor to pointer on hover */
        }

        #login-button:hover {
            background-color: skyblue; /* Change background color on hover */
        }
        #button {
            padding: 10px;
            width: 100px;
            color: white;
            background-color: lightblue;
            border: none;
        }
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
    <div id="box">
        <form method="post">
            <div style="font-size: 20px;margin: 10px;">Sign up</div>
            <input type="text" name="user_name" id="text" placeholder="Username"><br><br>
            <input type="password" name="password" id="text" placeholder="Password"><br><br>
            <input type="password" name="confirm_password" id="text" placeholder="Confirm Password"><br><br>
            <input type="email" name="email" id="text" placeholder="Email"><br><br>
            <!-- Change the input type to text -->
            <input type="text" name="graduation_year" id="text" placeholder="Graduation Year" pattern="[1-9][0-9]{3}" title="Please enter a 4-digit year starting from 1960" minlength="4"><br><br>
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
            <a href="login.php" style="color: black;">Back to login.</a>
        </form>
    </div>
</body>
</html>