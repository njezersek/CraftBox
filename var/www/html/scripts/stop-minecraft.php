<?php
	session_start();
	if(!isset($_SESSION['user'])){
		header("location: login.php");
		die();
	}
	
	exec("sudo -u spigot /home/spigot/scripts/spigot.sh stop");
?>
