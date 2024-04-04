<?php
session_start();
require_once('connect.php');
if(!isset($_SESSION['user_id'])){ Redirect('index.php'); }
else
{
    require_once('header.php');
}
?>
<ul id="mainNav">
    <li><a href="dashboard.php" class="active">DASHBOARD</a></li>
    <li><a href="visitors.php">VISITORS</a></li>
    <li><a href="Rooms.php">ROOMS</a></li>
    <li class="logout"><a href="logout.php">LOGOUT</a></li>
</ul>
<h2>View All Visitors</h2>
                
<div id="main">
    <h3>Visitors Records</h3>
    <table cellpadding="0" cellspacing="0">
        <!-- Table Headers -->
    </table>
    <?php
    $result = mysqli_query($server, "SELECT p.*, pb.pat_id, pb.room_id AS room FROM visitors p LEFT JOIN pat_to_bed pb ON p.pat_id = pb.pat_id ORDER BY p.pat_id DESC");
    // Add your code for displaying visitor records here.
    ?>

    <!-- Additional Stats -->
    <?php
    // Total Number of Visitors Checked In
    $checkedInResult = mysqli_query($server, "SELECT COUNT(*) AS totalCheckedIn FROM pat_to_bed WHERE room_id > 0");
    $checkedInRow = mysqli_fetch_assoc($checkedInResult);
    $totalCheckedIn = $checkedInRow['totalCheckedIn']-1;

    // Total Number of Rooms
    $totalRoomsResult = mysqli_query($server, "SELECT COUNT(*) AS totalRooms FROM Rooms");
    $totalRoomsRow = mysqli_fetch_assoc($totalRoomsResult);
    $totalRooms = $totalRoomsRow['totalRooms'];

    // Number of Rooms Available
    $availableRoomsResult = mysqli_query($server, "SELECT COUNT(*) AS roomsAvailable FROM Rooms WHERE Status = 'Available'");
    $availableRoomsRow = mysqli_fetch_assoc($availableRoomsResult);
    $roomsAvailable = $availableRoomsRow['roomsAvailable'];

    // Number of Rooms Booked (Occupied) can be derived as totalRooms - roomsAvailable for more accuracy
    $roomsBooked = $totalRooms - $roomsAvailable;
    ?>

    <div>
        <p>Total Visitors Checked In: <strong><?php echo $totalCheckedIn; ?></strong></p>
        <p>Total Rooms Available: <strong><?php echo $roomsAvailable; ?></strong></p>
        <p>Total Rooms: <strong><?php echo $totalRooms; ?></strong></p>
        <p>Total Rooms Booked: <strong><?php echo $roomsBooked; ?></strong></p>
    </div>
    <br /><br />
</div>
