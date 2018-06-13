<?php
	session_start();
	if(!isset($_SESSION['user'])){
		header("location: login.php");
		die();
	}

	$running = shell_exec("ps aux | grep spigot.jar | grep -v grep | grep -v SCREEN");
	if(empty($running)) {
		exec("sudo -u spigot /home/spigot/scripts/spigot.sh start");
		} else {
			do {
				exec("sudo -u spigot /home/spigot/scripts/spigot.sh stop");
				$running = shell_exec("ps aux | grep spigot.jar | grep -v grep | grep -v SCREEN");
			} while (empty($running) != true);
				exec("sudo -u pi /home/spigot/scripts/spigot.sh start");
			}
?>
