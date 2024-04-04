<?php
session_start();
include_once('connect.php');

unset($_SESSION['user_id']);
unset($_SESSION['name']);

Redirect('index.php');
?>