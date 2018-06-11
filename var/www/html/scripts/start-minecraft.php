<?php
	session_start();
	if(!isset($_SESSION['user'])){
		header("location: login.php");
		die();
	}

	exec("sudo -u pi /home/minecraft/scripts/minecraft.sh start");
?>
