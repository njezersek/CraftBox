<?php
session_start();
if(!isset($_SESSION['user'])){
	header("location: login.php");
	die();
}

	exec("sudo reboot");
?>
