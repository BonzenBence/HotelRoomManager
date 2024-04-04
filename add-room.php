<?php
	session_start();
	require_once('connect.php');
	if(!isset($_SESSION['user_id'])){ Redirect('index.php'); }
	else
	{
		$error="";
		$msg="<br><span class=msg>Room Added Successfully</span><br><br>";
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
                    	<li><a href="Rooms.php">VIew All ROOMS</a></li>
                    	<li><a href="add-room.php" class="active">Add New Rooms</a></li>
                    </ul>
                    <!-- // .sideNav -->
                </div>    
                <!-- // #sidebar -->
                
                <!-- h2 stays for breadcrumbs -->
                <h2>Add New Room</h2>
                
                <div id="main">
                <form method="post" class="jNice">
					<h3>Registration Form</h3>
                    <?php
						if(isset($_POST['save']))
						{
							$type=$_POST['type'];
							$Status=$_POST['Status'];
							
							if($type=="none"){ $error="<br><span class=error>Please select a type</span><br><br>"; }
							elseif($Status=="none"){ $error="<br><span class=error>Please select a Status</span><br><br>"; }
							else
							{
								mysqli_query($server,"INSERT INTO ROOMS (type,Status) VALUES ('$type','$Status')");
								echo $msg;
							}
							
							if($error!=""){ echo $error; }
						}
					?>
                    	<fieldset>
                            <p><label>Type&nbsp:</label>
                            <select name="type&nbsp">
                            	<option value="none">[--------SELECT--------]</option>
                            	<option value="single">single</option>
                            	<option value="double">double</option>
                            	<option value="queen">queen</option>
                            	<option value="king">king</option>
                                <option value="suite">suite</option>
                                <option value="presidential suite&nbsp">presidential suite&nbsp</option>
                            </select>
                            </p>
                            <p><label>Status&nbsp:</label>
                            <select name="Status&nbsp">
                            	<option value="none">[--------SELECT--------]</option>
                            	<option value="available">available</option>
                            	<option value="booked">booked</option>
                            	<option value="Under Maintenance">Under Maintenance</option>
                            	<option value="Being Cleaned">Being Cleaned</option>
                                <option value="occupied">Occupied</option>
                                <option value="Checked Out">Checked Out</option>
                            </select>
                            </p>
                            <input type="submit" value="Save" name="save" />
                        </fieldset>
                    </form>
                        <br /><br />
                </div>
 <?php

?>               