<?php
$db_hostname = 'localhost';
$db_database = 'hbms';
$db_username = 'root';
$db_password = '';

// Create connection
$server = mysqli_connect($db_hostname, $db_username, $db_password, $db_database);

// Check connection
if(!$server) {
    die("Cannot connect to MySQL at the moment: " . mysqli_connect_error());
}

function Redirect($url) { 
    if(headers_sent()) { 
        echo "<script type='text/javascript'>location.href='$url';</script>"; 
    } else { 
        header("Location: $url"); 
    } 
}
?>
