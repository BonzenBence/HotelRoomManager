<?php
	session_start();
	require_once('connect.php');
	if(!isset($_SESSION['user_id'])){ Redirect('index.php'); }
	else
	{
		$error="";
		$msg="<br><span class=msg>Visitors Added Successfully</span><br><br>";
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
                    	<li><a href="visitors.php">VIew All Visitors</a></li>
                    	<li><a href="add-visitor.php" class="active">Add New Visitor</a></li>
                    	<li><a href="assign-room.php">Assign/Unassign ROOMS</a></li>
                    </ul>
                    <!-- // .sideNav -->
                </div>    
                <!-- // #sidebar -->
                
                <!-- h2 stays for breadcrumbs -->
                <h2>Add New Visitors</h2>
                
                <div id="main">
                <form method="post" class="jNice">
					<h3>Registration Form</h3>
                    <?php
						if(isset($_POST['save']))
						{
							$name = trim($_POST['name']);
							$age = (int) trim($_POST['age']); // Cast age to an integer
							$mealplan = $_POST['mealplan'];
							$nt = trim($_POST['nt']);
							$phone = trim($_POST['phone']);
							
							if($name==""){ $error="<br><span class=error>Please enter a name</span><br><br>"; }
							elseif($age==""){ $error="<br><span class=error>Please enter the age</span><br><br>"; }
							elseif($age<1){ $error="<br><span class=error>Please enter a value greater than zero for age</span><br><br>"; }
							elseif(!is_numeric($age)){ $error="<br><span class=error>Age must be a number</span><br><br>"; }
							elseif($mealplan=="none"){ $error="<br><span class=error>Please select the Meal Plan</span><br><br>"; }
							elseif($nt==""){ $error="<br><span class=error>Please enter a nationality</span><br><br>"; }
							elseif($phone==""){ $error="<br><span class=error>Please enter the phone number</span><br><br>"; }
							else
							{
								$insertVisitorQuery = "INSERT INTO visitors (name, age, meal_plan, nationality, phone) VALUES (?, ?, ?, ?, ?)";
									$stmt = $server->prepare($insertVisitorQuery);
									$stmt->bind_param("sisss", $name, $age, $mealplan, $nt, $phone); // Corrected the bind_param types
									$stmt->execute();
										
									$result = $server->query("SELECT pat_id FROM visitors ORDER BY pat_id DESC LIMIT 1");
									$row = $result->fetch_assoc();
										
									$insertPatToBedQuery = "INSERT INTO pat_to_bed (pat_id, room_id) VALUES (?, 'none')";
									$stmt = $server->prepare($insertPatToBedQuery);
									$stmt->bind_param("i", $row['pat_id']);
									$stmt->execute();

									echo $msg;
								}
								
								if($error!=""){ echo $error; }
							}
					?>
                    	<fieldset>
                        	<p><label>Visitors Name:</label><input type="text" name="name" class="text-long" autofocus value="  " /></p>
                            <p><label>Age:</label><input type="number" name="age" class="text-long" value="<?php echo $age; ?>" /></p>
                            <p><label>Meal Plan:</label>
                            <select name="mealplan">
                            	<option value="none">[--------SELECT--------]</option>
                            	<option value="Breakfast Included">Breakfast Included</option>
                            	<option value="Half Board">Half Board</option>
                            	<option value="Full Board">Full Board</option>
                            	<option value="All Inclusive">All Inclusive</option>
                            </select>
                            </p>
                            <p><label>Nationality:</label><input type="text" name="nt" class="text-long" value=" " /></p>
                            <p><label>Phone Number:</label><input type="text" name="phone" class="text-long" value="  " /></p>
                            <input type="submit" value="Save" name="save" />
                        </fieldset>
                    </form>
                        <br /><br />
                </div>
 <?php

?>               