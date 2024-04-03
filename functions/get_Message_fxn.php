<?php
// Function to get messages from the database
include_once '../settings/connection.php';

// Initialize an empty array to store messages
$messages = array();

// SQL query to select messages from the database
$sql = "SELECT * FROM messages ORDER BY created_at ASC";

// Execute the query
$result = mysqli_query($con, $sql);

// Check if the query executed successfully
if ($result) {
    // Fetch associative array of each row
    while ($row = mysqli_fetch_assoc($result)) {
        // Add the row to the messages array
        $messages[] = $row;
    }
} else {
    // If query failed, display an error message
    echo "Error: " . mysqli_error($con);
}

// Close the database connection
mysqli_close($con);

// Convert the array of messages to JSON format
$jsonData = json_encode($messages);

// Set the appropriate Content-Type header
header('Content-Type: application/json');

// Output the JSON data
echo $jsonData;
?>
