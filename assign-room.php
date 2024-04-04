<?php
session_start();
require_once('connect.php');

if (!isset($_SESSION['user_id'])) {
    // Stellen Sie sicher, dass die Redirect-Funktion existiert oder verwenden Sie header().
    Redirect('index.php');
    exit();
}

require_once('header.php');

	$error = "";
	$error2 = "";
	$msg = "<br><span class='msg'>Room Assigned Successfully</span><br><br>";
	$msg2 = "<br><span class='msg'>Room Has Been Unassigned Successfully</span><br><br>";

	if(isset($_POST['save'])) {
		$name = mysqli_real_escape_string($server, trim($_POST['name']));
		$age = mysqli_real_escape_string($server, trim($_POST['age']));
		$mealplan = mysqli_real_escape_string($server, $_POST['mealplan']);
		$nt = mysqli_real_escape_string($server, trim($_POST['nt']));
		$phone = mysqli_real_escape_string($server, trim($_POST['phone']));
	
		// ... (Ihre Validierungslogik)
	
		if($error == ""){
			$stmt = $server->prepare("INSERT INTO visitors (name, age, mealplan, nationality, phone) VALUES (?, ?, ?, ?, ?)");
			$stmt->bind_param("sisss", $name, $age, $mealplan, $nt, $phone);
			if($stmt->execute()){
				$pat_id = $stmt->insert_id;
				$stmt = $server->prepare("INSERT INTO pat_to_bed (pat_id, room_id) VALUES (?, 'none')");
				$stmt->bind_param("i", $pat_id);
				$stmt->execute();
				echo $msg;
			} else {
				$error = "<br><span class='error'>" . mysqli_error($server) . "</span><br><br>";
			}
		}
	}
	
	if($error != ""){ echo $error; }

	if (isset($_POST['assign'])) {
		$visitorId = $_POST['Visitors'];
		$roomId = $_POST['room'];
	
		if ($visitorId == "none" || $roomId == "none") {
			$error = "<br><span class='error'>Please select both a visitor and a room.</span><br><br>";
		} else {
			// Begin transaction
			$server->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
	
			try {
				// Update room_id in pat_to_bed for the visitor
				$stmt = $server->prepare("UPDATE pat_to_bed SET room_id = ? WHERE pat_id = ?");
				$stmt->bind_param("ii", $roomId, $visitorId);
				$stmt->execute();
	
				// Update the room status to 'Occupied'
				$stmt = $server->prepare("UPDATE Rooms SET Status = 'Occupied' WHERE room_id = ?");
				$stmt->bind_param("i", $roomId);
				$stmt->execute();
	
				$server->commit();
				echo $msg;
			} catch (mysqli_sql_exception $e) {
				$server->rollback();
				$error = "<br><span class='error'>Error assigning room: " . $e->getMessage() . "</span><br><br>";
			}
		}
	
		if ($error != "") {
			echo $error;
		}
	}
	
	if (isset($_POST['unassign'])) {
		$ptb = $_POST['ptb'];
	
		if ($ptb !== "none") {
			// Begin transaction
			$server->begin_transaction(MYSQLI_TRANS_START_READ_WRITE);
	
			try {
				// Retrieve room_id before setting it to NULL
				$stmt = $server->prepare("SELECT room_id FROM pat_to_bed WHERE pat_id = ?");
				$stmt->bind_param("i", $ptb);
				$stmt->execute();
				$result = $stmt->get_result();
				$row = $result->fetch_assoc();
				$unassignRoomId = $row['room_id'];
	
				// Set room_id to NULL in pat_to_bed for the visitor
				$stmt = $server->prepare("UPDATE pat_to_bed SET room_id = NULL WHERE pat_id = ?");
				$stmt->bind_param("i", $ptb);
				$stmt->execute();
	
				// Update the room status to 'Checked Out'
				if ($unassignRoomId) {
					$stmt = $server->prepare("UPDATE Rooms SET Status = 'Checked Out' WHERE room_id = ?");
					$stmt->bind_param("i", $unassignRoomId);
					$stmt->execute();
				}
	
				$server->commit();
				echo $msg2;
			} catch (mysqli_sql_exception $e) {
				$server->rollback();
				$error2 = "<br><span class='error'>Error unassigning room: " . $e->getMessage() . "</span><br><br>";
			}
		} else {
			$error2 = "<br><span class='error'>Please select a visitor to unassign.</span><br><br>";
		}
	
		if ($error2 != "") {
			echo $error2;
		}
	}
	
	$roomOptionsQuery = "SELECT * FROM Rooms WHERE Status IN ('Available', 'Occupied') ORDER BY room_id DESC"; // Adjusted to include 'Occupied'
	$roomOptionsResult = mysqli_query($server, $roomOptionsQuery);
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
							<li><a href="visitors.php">VIew All Visitors</a></li>
							<li><a href="add-visitor.php">Add New Visitors</a></li>
							<li><a href="assign-room.php" class="active">Assign/Unassign ROOMS</a></li>
						</ul>
						<!-- // .sideNav -->
					</div>    
					<!-- // #sidebar -->
					
					<!-- h2 stays for breadcrumbs -->
					<h2>Assign/Unassign ROOMS</h2>
					
					<div id="main">
					<form method="post" class="jNice" name="frm1">
						<h3>Assign Rooms</h3>
						<?php
							if(isset($_POST['assign']))
							{
								$Visitors=$_POST['Visitors'];
								$room=$_POST['room'];
								$updateRoomStatusQuery = $server->prepare("UPDATE Rooms SET Status = 'Checked In' WHERE room_id = ?");
        						$updateRoomStatusQuery->bind_param("i", $roomId);
        						$updateRoomStatusQuery->execute();
								
								if($Visitors=="none"){ $error="<br><span class=error>Please select a Visitors</span><br><br>"; }
								elseif($room=="none"){ $error="<br><span class=error>Please select a room</span><br><br>"; }
								else
								{
									$result4=mysqli_query($server,"SELECT * FROM pat_to_bed WHERE room_id='$room'");
									if($row4=mysqli_num_rows($result4)>0){ $error="<br><span class=error>Room $room has already been assigned to a Visitors</span><br><br>"; }
									else
									{
										mysqli_query($server,"UPDATE pat_to_bed SET room_id='$room' WHERE pat_id='$Visitors'");
										echo $msg;
									}
								}
								
								if($error!=""){ echo $error; }
							}
						?>
							<fieldset>
								<p><label>Visitors:</label>
								<select name="Visitors">
									<option value="none">[--------SELECT--------]</option>
									<?php
										$result=mysqli_query($server,"SELECT p.pat_id,p.name,pb.pat_id,pb.room_id FROM visitors P, pat_to_bed pb WHERE p.pat_id=pb.pat_id AND pb.room_id='none' ORDER BY p.pat_id DESC");
										while($row=mysqli_fetch_row($result))
										{
											$rn=$row['0'];
											if(strlen($rn)==1)
											$rn="000".$rn;
											elseif(strlen($rn)==2)
											$rn="00".$rn;
											elseif(strlen($rn)==3)
											$rn="0".$rn;
											elseif(strlen($rn)>3)
											$rn=$rn;
											echo"<option value=$row[0]>$rn - $row[1]</option>";
										}
									?>
								</select>
								</p>
								<p><label>Room:</label>
								<select name="room">
									<option value="none">[--------SELECT--------]</option>
									<?php
										$result2=mysqli_query($server,"SELECT * FROM Rooms ORDER BY room_id DESC");
										while ($row2 = mysqli_fetch_assoc($roomOptionsResult)) {
											echo "<option value=" . htmlspecialchars($row2['room_id']) . ">Room " . htmlspecialchars($row2['room_id']) . " - " . htmlspecialchars($row2['type']) . "</option>";
										}
									?>
								</select>
								</p>
								<input type="submit" value="Assign Room" name="assign" />
							</fieldset>
						</form>
							<br /><br />
						<form method="post" class="jNice" name="frm2">
						<h3>Unssign Rooms</h3>
						<?php
							if(isset($_POST['unassign']))
							{
								$ptb=trim($_POST['ptb']);
								
								if($ptb=="none"){ $error2="<br><span class=error>Please select a relationship</span><br><br>"; }
								else
								{
									mysqli_query($server,"UPDATE pat_to_bed SET room_id=0 WHERE pat_id='$ptb'");
									echo $msg2;
								}
								
								if($error2!=""){ echo $error2; }
							}
						?>
							<fieldset>
								<p><label>Visitors - Room Relationship:</label>
								<select name="ptb">
									<option value="none">[--------SELECT--------]</option>
									<?php
									$result3=mysqli_query($server,"SELECT p.pat_id,p.name,pb.pat_id,pb.room_id FROM visitors P, pat_to_bed pb WHERE p.pat_id=pb.pat_id AND pb.room_id>0 ORDER BY p.pat_id DESC");
										while($row3=mysqli_fetch_row($result3))
										{
											$rn=$row3['0'];
											if(strlen($rn)==1)
											$rn="000".$rn;
											elseif(strlen($rn)==2)
											$rn="00".$rn;
											elseif(strlen($rn)==3)
											$rn="0".$rn;
											elseif(strlen($rn)>3)
											$rn=$rn;
											echo"<option value=$row3[0]>Room $row3[3] to $rn - $row3[1]</option>";
										}
										?>
								</select>
								</p>
								<input type="submit" value="Unassign Room" name="unassign" />
							</fieldset>
						</form>
					</div>
	<?php
	?>               