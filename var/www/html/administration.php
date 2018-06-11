<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	require "functions.php";
	require "config.php";

	session_start();
	if(!isset($_SESSION['user'])){
		header("location: login.php");
		die();
	}

	$currentConfig = file_get_contents('/etc/hostapd/hostapd.conf');
	$apConfig = ini2arr($currentConfig);

	$msg = "";
	if(isset($_POST['ssid']) && isset($_POST['wpa_passphrase']) && isset($_POST['control_username']) && isset($_POST['control_password'])) {
		$ok = true;
		$ssid = $_POST['ssid'];
		$wpa_passphrase = $_POST['wpa_passphrase'];
		$control_username = $_POST['control_username'];
		$control_password = $_POST['control_password'];

		if(preg_match('/[^\x20-\x7f]/', $ssid.$wpa_passphrase.$control_username.$control_password)) {
			$ok = false;
			$msg .= "<div class='error'>Fields must only contain alphanumerical characters.</div>";
		}

		if(strlen($wpa_passphrase) < 8 || strlen($wpa_passphrase) > 64){
			$ok = false;
			$msg .= "<div class='error'>Access point password must be between 8 and 64 characters.</div>";
		}

		if(strlen($ssid) < 1 || strlen($ssid) > 32) {
			$ok = false;
			$msg .= "<div class='error'>Access point name (SSID) must be between 1 and 32 characters.</div>";
		}

		if($ok){
			$apConfig['ssid'] = $ssid;
			$apConfig['wpa_passphrase'] = $wpa_passphrase;

			$newConfig = arr2ini($apConfig);
			file_put_contents('/etc/hostapd/hostapd.conf', $newConfig);

			$config['controlPanelLogin']['username'] = $control_username;
			$config['controlPanelLogin']['password'] = $control_password;

			$newJson = json_encode($config);
			file_put_contents('/var/www/config.json', $newJson);

			$msg .= "<div class='info msg'><div class='content'>Configuration was saved successfully. Access point configuration will be applied on next reboot.</div> <a class='button' onclick='reboot()'>reboot</a></div>";
		}
	}

	if(isset($_GET['reboot'])){
		if($_GET['reboot'] == "success")$msg .= "<div class='success'>Server was rebooted successfully.</div>";
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
				<form action="administration.php" method="post">
					<h2>Access point configuration</h2>

					<div class="option-container">
						<div class="info-container">
							<label>Access point name (SSID)</label>
						</div>
						<div class="input-container">
							<input type="text" name="ssid" value="<?php echo $apConfig['ssid']; ?>">
						</div>
					</div>

					<div class="option-container">
						<div class="info-container">
							<label>Access point password</label>
						</div>
						<div class="input-container">
							<input type="text" name="wpa_passphrase" value="<?php echo $apConfig['wpa_passphrase']; ?>">
						</div>
					</div>

					<br>
					<br>
					<h2>Control panel</h2>

					<div class="option-container">
						<div class="info-container">
							<label>Control panel username</label>
						</div>
						<div class="input-container">
							<input type="text" name="control_username" value="<?php echo $config['controlPanelLogin']['username']; ?>">
						</div>
					</div>

					<div class="option-container">
						<div class="info-container">
							<label>Control panel password</label>
						</div>
						<div class="input-container">
							<input type="text" name="control_password" value="<?php echo $config['controlPanelLogin']['password']; ?>">
						</div>
					</div>
					<br>
					<input type="submit" value="Save" class="button">
				</form>
			</div>
		</main>

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
						location.replace("administration.php?reboot=success");
			    }
			  };
			  xhttp.open("GET", "index.php", true);
			  xhttp.send();
			}
		</script>
	</body>
</html>
