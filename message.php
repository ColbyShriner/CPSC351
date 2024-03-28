<?php
session_start();
require_once('connection.php'); // Assuming you have a PHP class to handle your database connection

// Placeholder for database connection setup
// Ensure you replace this with actual code to connect to your database, based on your Database.php structure
$db = new PDO('mysql:host=your_host;dbname=your_dbname', 'your_username', 'your_password');

// Check if user is logged in and set userID, this part is crucial and needs proper session management
$userId = $_SESSION['user_id'] ?? null; // Ensure this is securely managed and user is authenticated

// Handle message sending
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['friendee'], $_POST['message'])) {
    $friendeeId = $_POST['friendee'];
    $messageText = $_POST['message']; // Assuming message content is sent via 'message' POST parameter
    $messageDate = date('Y-m-d H:i:s'); // Current date and time

    // Insert message into the database
    $sql = "INSERT INTO `MESSAGE` (`FrienderID`, `Friendee`, `Message DATE/TIME`, `Message Sender`, `Message Reciever`) VALUES (?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$userId, $friendeeId, $messageDate, $userId, $friendeeId]); // Example placeholders
    echo "<p>Message sent successfully!</p>";
}

// Fetching messages for the logged-in user
$sql = "SELECT * FROM `MESSAGE` WHERE `Friendee` = ? ORDER BY `Message DATE/TIME` DESC";
$stmt = $db->prepare($sql);
$stmt->execute([$userId]);
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Messages</title>
</head>
<body>
<h2>Your Messages</h2>
<?php foreach ($messages as $message): ?>
    <div>
        <p><strong>From:</strong> <?= htmlspecialchars($message['Message Sender']) ?> <strong>To:</strong> <?= htmlspecialchars($message['Message Reciever']) ?></p>
        <p><?= htmlspecialchars($message['Message DATE/TIME']) ?></p>
        <p><?= htmlspecialchars($message['message']) ?></p> <!-- Replace 'message' with actual message content field name if different -->
    </div>
<?php endforeach; ?>

<h2>Send a Message</h2>
<form method="post" action="">
    <div>
        <label for="friendee">To (Friendee ID):</label>
        <input type="number" id="friendee" name="friendee" required>
    </div>
    <div>
        <label for="message">Message:</label>
        <textarea id="message" name="message" required></textarea>
    </div>
    <button type="submit">Send</button>
</form>
</body>
</html>
