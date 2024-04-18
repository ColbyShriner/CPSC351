<?php
session_start(); 

// Database configuration
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "database351";

// Create connection
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch all events from the database, joining with the location table to get the location name
$events = [];
$result = $conn->query("SELECT Event.EventID, Event.EventDate, location.LocationName, Event.EventName, Event.EventDescription FROM Event JOIN location ON Event.LOCATION_LocationID = location.LocationID");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $events[] = $row;
    }
}

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle event deletion
    if (isset($_POST['deleteEvent'])) {
        $eventID = $_POST['deleteEvent'];
        $stmt = $conn->prepare("DELETE FROM Event WHERE EventID = ?");
        $stmt->bind_param("i", $eventID);
        if ($stmt->execute() === FALSE) {
            echo "Error deleting event: " . $stmt->error;
        } else {
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    // Handle clear calendar
    if (isset($_POST['clearCalendar'])) {
        $stmt = $conn->prepare("DELETE FROM Event");
        if ($stmt->execute() === FALSE) {
            echo "Error clearing calendar: " . $stmt->error;
        } else {
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }

    // Handle event addition
    if (isset($_POST['EventDate']) && isset($_POST['Location']) && isset($_POST['EventName']) && isset($_POST['EventDescription'])) {
        $eventDate = filter_input(INPUT_POST, 'EventDate', FILTER_SANITIZE_STRING);
        $locationName = filter_input(INPUT_POST, 'Location', FILTER_SANITIZE_STRING);
        $eventName = filter_input(INPUT_POST, 'EventName', FILTER_SANITIZE_STRING);
        $eventDescription = filter_input(INPUT_POST, 'EventDescription', FILTER_SANITIZE_STRING);

        // Fetch the LocationID from the location table
        $stmt = $conn->prepare("SELECT LocationID FROM location WHERE LocationName = ?");
        $stmt->bind_param("s", $locationName);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $locationID = $row['LocationID'];
        } else {
            echo "Location not found.";
            exit;
        }

        // Insert the event using the LocationID
        $stmt = $conn->prepare("INSERT INTO Event (EventDate, LOCATION_LocationID, EventName, EventDescription) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $eventDate, $locationID, $eventName, $eventDescription);

        if ($stmt->execute() === FALSE) {
            echo "Error: " . $stmt->error;
        } else {
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <li><a href="index.php">Home</a></li>
    <title>Calendar</title>

    <style>
        .calendar {
            width: 100%;
            border-collapse: collapse;
        }
        .calendar th, .calendar td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .calendar th {
            background-color: #blue;
        }
    </style>
</head>
<body>
    <h2>Add Event</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="EventDate">Event Date:</label>
        <input type="date" id="EventDate" name="EventDate" required>
        <br>
        <label for="Location">Location:</label>
        <select id="Location" name="Location" required>
            <option value="mcmurran">McMurran</option>
            <option value="torggler">Torggler</option>
            <option value="Trible Library">Trible Library</option>
            <option value="Luter">Luter</option>
            <option value="Forbes">Forbes</option>
            <option value="David Student Union">David Student Union</option>
            <option value="Ferguson">Ferguson</option>
        </select>
        <br>
        <label for="EventName">Event Name:</label>
        <input type="text" id="EventName" name="EventName" required>
        <br>
        <label for="EventDescription">Event Description:</label>
        <textarea id="EventDescription" name="EventDescription" required></textarea>
        <br>
        <input type="submit" value="Add Event">
    </form>


    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="submit" name="clearCalendar" value="Clear Calendar">
    </form>

    <h2>Events</h2>
    <table class="calendar">
        <tr>
            <th>Date</th>
            <th>Location</th>
            <th>Event Name</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        <?php foreach ($events as $event): ?>
            <tr>
                <td><?php echo htmlspecialchars($event['EventDate']); ?></td>
                <td><?php echo htmlspecialchars($event['LocationName']); ?></td>
                <td><?php echo htmlspecialchars($event['EventName']); ?></td>
                <td><?php echo htmlspecialchars($event['EventDescription']); ?></td>
                <td>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <input type="hidden" name="deleteEvent" value="<?php echo $event['EventID']; ?>">
                        <input type="submit" value="Delete">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>