<?php
// messages.php

// Database connection parameters
$host = 'localhost';
$dbname = 'mydb';
$username = '';
$password = '';

// Create a connection to the database
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if it's a POST request to send a message
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['senderId']) && isset($_POST['receiverId']) && isset($_POST['message'])) {
    sendMessage($conn);
} else if (isset($_GET['action']) && $_GET['action'] == 'getMessages' && isset($_GET['receiverId'])) {
    getMessages($conn);
} else {
    echo "Invalid request.";
}

function sendMessage($conn) {
    $senderId = $_POST['senderId'];
    $receiverId = $_POST['receiverId'];
    $message = $_POST['message'];

    $sql = "INSERT INTO `MESSAGE` (`FrienderID`, `Friendee`, `Message DATE/TIME`, `Message Sender`, `Message Reciever`, `ACCOUNT_AccountID`) VALUES (:senderId, :receiverId, NOW(), :senderId, :receiverId, :senderId)";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':senderId', $senderId);
    $stmt->bindParam(':receiverId', $receiverId);
    $stmt->bindParam(':message', $message);

    if ($stmt->execute()) {
        echo "Message sent successfully!";
    } else {
        echo "Error sending message.";
    }
}

function getMessages($conn) {
    $receiverId = $_GET['receiverId'];

    $sql = "SELECT `Message Sender`, `Message Reciever`, `Message DATE/TIME`, `message` FROM `MESSAGE` WHERE `Friendee` = :receiverId ORDER BY `Message DATE/TIME` DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':receiverId', $receiverId);
    $stmt->execute();
    $messages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($messages) {
        foreach ($messages as $message) {
            echo "From: " . $message['Message Sender'] . "<br>";
            echo "To: " . $message['Message Reciever'] . "<br>";
            echo "Date/Time: " . $message['Message DATE/TIME'] . "<br>";
            echo "Message: " . $message['message'] . "<br>";
            echo "<hr>";
        }
    } else {
        echo "No messages found.";
    }
}
?>

