<?php
session_start();
$_SESSION=array();
session_destroy();
if(isset($_SESSION['username'])){
	header("location: index.php?page=logout_error");
} else {
	header("location: index.php?page=login");
	exit();
} 
?>