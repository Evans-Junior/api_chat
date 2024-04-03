<?php
include_once '../settings/connection.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate input
    $errors = [];
    if (empty($_POST['sender'])) {
        $errors[] = "Sender is required";
    }
    if (empty($_POST['receiver'])) {
        $errors[] = "Receiver is required";
    }
    if (empty($_POST['message'])) {
        $errors[] = "Message is required";
    }

    // If there are validation errors, display them
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
        exit;
    }

    // Sanitize input data
    $sender = htmlspecialchars($_POST['sender']);
    $receiver = htmlspecialchars($_POST['receiver']);
    $message = htmlspecialchars($_POST['message']);
    $sb = htmlspecialchars($_POST['sentby']);


    // Prepare SQL statement to insert message into the database
    $sql = "INSERT INTO messages (sender_name, receiver_name, message) VALUES (?, ?, ?)";
    $stmt = $con->prepare($sql);
    if (!$stmt) {
        die("Error: " . $con->error);
    }

    // Bind parameters to the prepared statement
    $stmt->bind_param("sss", $sender, $receiver, $message);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Message sent successfully";
        
    } else {
        echo "Error: " . $con->error;
    }

    // Close statement and database connection
    $stmt->close();
    $con->close();
} else {
    // If the request method is not POST, display an error
    http_response_code(405);
    echo 'Message failed to send!';
}
?>
