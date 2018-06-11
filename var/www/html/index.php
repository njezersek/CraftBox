<?php
	session_start();
	if(!isset($_SESSION['user'])){
		header("location: login.php");
		die();
	}

	require("functions.php");
	$msg = "";
	$ip = explode(" ", exec("hostname -I"));
	$external = $ip[0]; $internal = $ip[1];
	if (count($ip) == 1) {
		$int1 = $ip[0];
		$ext1 = "No external IP address (not connected to the internet over ethernet). Functionality remains the same.";
	} else {
		$int1 = $ip[1];
		$ext1 = $ip[0];
	}

	if(isset($_GET['restart_mc'])) {
		restartMinecraft();
		$msg .= "<div class = info>Restarting Minecraft Server, this will only take a minute...</div>";
	}

	if(isset($_GET['reboot'])){
		if($_GET['reboot'] == "success")$msg .= "<div class='success'>Server was restarted successfully.</div>";
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<?php include "frame/head.php"; ?>
	</head>
	<body>
		<?php include "frame/header.php"; ?>
		<main>
		<div class="max">
			<div id="msg">
				<?php echo $msg; ?>
			</div>
			<h2>Server information</h2>
			<div><b>WiFi IP Address:</b> <?php echo $int1 ?></div>
			<div><b>Ethernet IP address:</b> <?php echo $ext1 ?></div>
			<br><br>
			<a class="button" href="?restart_mc=true">Restart Minecraft Server</a>
			<a class="button" onclick="reboot()">Reboot CraftBox</a>
		</div>
		</main>
	</body>

	<script>
		function reboot(){
			document.getElementById("msg").innerHTML = "<div class='info'>Minecraft Server is restarting, this will only take a minute. Page will refresh automatically when CraftBox has restarted.</div>";
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
				}
			};
			xhttp.open("GET", "scripts/reboot-pi.php", true);
			xhttp.send();

			setInterval(() => ping(), 1000);
		}

		function ping(){
			console.log("Trying to get index.php");
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					location.replace("index.php?reboot=success");
				}
			};
			xhttp.open("GET", "index.php", true);
			xhttp.send();
		}
		
	</script>
</html>
