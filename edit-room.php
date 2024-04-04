<?php
    session_start();
    require_once('connect.php'); // Ensure this path is correct
    if(!isset($_SESSION['user_id'])){ Redirect('index.php'); }
	else
	{
		require_once('header.php');
	}

    // Check if room_id is set in the URL
    if(isset($_GET['room_id'])) {
        $room_id = $_GET['room_id'];

        // Prepare and execute the query to fetch room details
        // Always prefer using prepared statements to avoid SQL injection
        $query = $server->prepare("SELECT * FROM Rooms WHERE room_id = ?");
        $query->bind_param("i", $room_id); // 'i' specifies the data type as integer
        $query->execute();
        $result = $query->get_result();
        if($result->num_rows === 0) {
            exit('Room not found');
        } else {
            $room = $result->fetch_assoc();
        }
    } else {
        exit('Room ID not specified.');
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Room Status</title>
</head>
<body>
    <h2>Edit Room Status</h2>
    <form action="update-room.php" method="post">
        <input type="hidden" name="room_id" value="<?php echo htmlspecialchars($room['room_id']); ?>">
        
        <label for="status">Status:</label>
        <select name="status" id="status">
            <option value="Available" <?php echo ($room['Status'] === 'Available') ? 'selected' : ''; ?>>Available</option>
            <option value="Booked" <?php echo ($room['Status'] === 'Booked') ? 'selected' : ''; ?>>Booked</option>
            <option value="Under Maintenance" <?php echo ($room['Status'] === 'Under Maintenance') ? 'selected' : ''; ?>>Under Maintenance</option>
            <option value="Being Cleaned" <?php echo ($room['Status'] === 'Being Cleaned') ? 'selected' : ''; ?>>Being Cleaned</option>
            <option value="occupied" <?php echo ($room['Status'] === 'occupied') ? 'selected' : ''; ?>>occupied</option>
            <option value="Checked Out" <?php echo ($room['Status'] === 'Checked Out') ? 'selected' : ''; ?>>Checked Out</option>
        </select>

        <button type="submit">Update Status</button>
    </form>
</body>
</html>
