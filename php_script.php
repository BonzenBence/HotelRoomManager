<?php
session_start();
require_once('connect.php');

if(!isset($_SESSION['user_id'])) { 
    Redirect('index.php'); 
} else {
    // Your current logic to fetch statistics
    $statistics = [
        'totalVisitors' => $row[0],
        'totalRooms' => $row2[0],
        // Add more statistics as needed
    ];

    // Output as JSON
    header('Content-Type: application/json');
    echo json_encode($statistics);
}
?>
