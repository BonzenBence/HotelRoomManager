<?php
session_start();
require_once('connect.php');
if (!isset($_SESSION['user_id'])) { 
    Redirect('index.php'); // Ensure this Redirect function is defined or use header('Location: index.php');
} else {
    require_once('header.php');
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['room_id']) && isset($_POST['status'])) {
    $room_id = $_POST['room_id'];
    $status = $_POST['status'];

    // Add 'Checked In' and 'Checked Out' to the list of valid statuses
    $valid_statuses = ['Available', 'Booked', 'Under Maintenance', 'Being Cleaned', 'Checked In', 'Checked Out'];
    
    // Validate input and sanitize
    if (!in_array($status, $valid_statuses)) {
        // Handle invalid status
        echo "Invalid status provided.";
        exit();
    }

    $query = $server->prepare("UPDATE Rooms SET Status = ? WHERE room_id = ?");
    $query->bind_param("si", $status, $room_id);
    if ($query->execute()) {
        // Redirect to the rooms page
        header('Location: Rooms.php');
        exit;
    } else {
        // Error handling
        echo "Error updating room status: " . $server->error;
    }

    // Prepare the update statement to prevent SQL injection
    $query = $server->prepare("UPDATE Rooms SET Status = ? WHERE room_id = ?");
    $query->bind_param("si", $status, $room_id);

    // Execute the query and check if the update was successful
    if ($query->execute()) {
        // Redirect to the rooms page or show a success message
        // Uncomment one of the following lines depending on your setup
        // Redirect('Rooms.php');
        header('Location: Rooms.php'); // Use this if you don't have a Redirect function
        exit();
    } else {
        echo "Error updating room status: " . $server->error;
    }
} else {
    // Not a POST request or missing room_id/status, redirect or show an error
    echo "Invalid request.";
}
?>
