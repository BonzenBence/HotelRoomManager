<?php
	require_once('header.php');
	require_once('connect.php');
	$error="";
?>   
        <div id="containerHolder">
			<div id="container">
        		
                
                <!-- h2 stays for breadcrumbs -->
                <h2>User Login</h2>
                
                <div id="main">
                <form method="post" class="jNice" name="frm1">
					<h3>Login Form</h3>
                    <?php
						if(isset($_POST['save']))
						{
							$uname=$_POST['uname'];
							$pword=$_POST['pword'];
							
							if($uname==""){ $error="<br><span class=error>Please enter a username</span><br><br>"; }
							elseif($pword==""){ $error="<br><span class=error>Please enter the password</span><br><br>"; }
							else
							{
								$result=mysqli_query($server,"SELECT * FROM users WHERE uname='$uname' AND pword='$pword'");
								if(mysqli_num_rows($result)==0){ $error="<br><span class=error>Invalid Username/Password</span><br><br>"; }
								else
								{
									$row=mysqli_fetch_array($result);
									session_start();
									$_SESSION['user_id']=$row['user_id'];
									$_SESSION['name']=$row['name'];
									Redirect('dashboard.php'); 
								}
							}
							if($error!=""){ echo $error; }
						}
					?>
                    	<fieldset>
                            <p><label>Username:</label><input type="text" name="uname" class="text-long"  /></p>
                            <p><label>Password:</label><input type="password" name="pword" class="text-long" /></p>
                            <input type="submit" value="Log In" name="save" />
                        </fieldset>
                    </form>
                        <br /><br />
                </div>
 <?php
?>               