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
        	<li><a href="visitors.php">VISITORS</a></li>
        	<li><a href="Rooms.php" class="active">ROOMS</a></li>
        	<li class="logout"><a href="logout.php">LOGOUT</a></li>
        </ul>
        <!-- // #end mainNav -->
        
        <div id="containerHolder">
			<div id="container">
        		<div id="sidebar">
                	<ul class="sideNav">
                    	<li><a href="Rooms.php" class="active">VIew All Rooms</a></li>
                    	<li><a href="add-room.php">Add New Room</a></li>
                    </ul>
                    <!-- // .sideNav -->
                </div>    
                <!-- // #sidebar -->
                
                <!-- h2 stays for breadcrumbs -->
                <h2>View All Rooms</h2>
                
                <div id="main">
					<h3>Available Rooms</h3>
                    	<table cellpadding="0" cellspacing="0">
							<tr>
                                <td><b>Room ID&nbsp</b></td>
                                <td><b>Type&nbsp</b></td>
                                <td><b>Status&nbsp</b></td>
								<td><b>Action&nbsp</b></td>
                            </tr> 
                            <?php
								$result=mysqli_query($server,"SELECT * FROM Rooms ORDER BY room_id DESC");
								while($row=mysqli_fetch_assoc($result))
								{
									echo"<tr class=odd>
									<td style='padding: 10px;'>{$row['room_id']}</td>
									<td style='padding: 10px;'>{$row['type']}</td>
									<td style='padding: 10px;'>{$row['Status']}</td>
									<td><a href='edit-room.php?room_id={$row['room_id']}'>Edit</a></td>
                            		</tr>";
								}
							?>                       
                        </table>
                        <br /><br />
                </div>
 <?php
?>               