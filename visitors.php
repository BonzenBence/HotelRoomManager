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
        	<li><a href="dashboard.php">DASHBOARD</a></li> <!-- Use the "active" class for the active menu item  -->
        	<li><a href="visitors.php" class="active">VISITORS</a></li>
        	<li><a href="Rooms.php">ROOMS</a></li>
        	<li class="logout"><a href="logout.php">LOGOUT</a></li>
        </ul>
        <!-- // #end mainNav -->
        
        <div id="containerHolder">
			<div id="container">
        		<div id="sidebar">
                	<ul class="sideNav">
                    	<li><a href="visitors.php" class="active">VIew All Visitors</a></li>
                    	<li><a href="add-visitor.php">Add New Visitors</a></li>
                    	<li><a href="assign-room.php">Assign/Unassign Rooms</a></li>
                    </ul>
                    <!-- // .sideNav -->
                </div>    
                <!-- // #sidebar -->
                
   <?php    
   ?>             <!-- h2 stays for breadcrumbs -->
<div id="main">
    <h3>Visitors Records</h3>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td><b>Visitor ID&nbsp;</b></td>
                <td><b>Name&nbsp;</b></td>
                <td><b>Age&nbsp;</b></td>
                <td><b>Meal Plan&nbsp;</b></td>
                <td><b>Nationality&nbsp;</b></td>
                <td><b>Status&nbsp;</b></td>
                <td><b>Assigned Room&nbsp;</b></td> <!-- New Column for Assigned Room -->
            </tr> 
            <?php
                $result = mysqli_query($server, "SELECT p.*, pb.room_id FROM visitors p LEFT JOIN pat_to_bed pb ON p.pat_id = pb.pat_id ORDER BY p.pat_id DESC");
                while($row = mysqli_fetch_assoc($result)) {
                    $status = "";
                    if($row['room_id'] == "none" || $row['room_id'] == 0) {
                        $status = "No Room Assigned";
                    } else {
                        $status = "Room " . $row['room_id'];
                    }
                    
                    // Formatting Visitor ID
                    $rn = str_pad($row['pat_id'], 4, '0', STR_PAD_LEFT);
                    
                    echo "<tr class='odd'>
                            <td>$rn</td>
                            <td>{$row['name']}</td>
                            <td>{$row['age']}</td>
                            <td>{$row['meal_plan']}</td>
                            <td>{$row['nationality']}</td>
                            <td>"; // Existing status rendering might need adjustment
                    echo $row['room_id'] > 0 ? "Checked In <font color='#c66653'>{Room {$row['room_id']}}</font>" : "<font color='#33CC99'>Checked Out</font>";
                    echo "</td>
                          <td>$status</td> <!-- Displaying Assigned Room -->
                         </tr>";
                }
            ?>                       
        </table>
        <br /><br />
</div>
 <?php
?>               