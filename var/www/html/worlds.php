<?php
	require "functions.php";
	session_start();
	if(!isset($_SESSION['user'])) {
		header("location: login.php");
		die();
	}

	$msg = "";
	if(isset($_GET["activate"])) {
		$world = $_GET["activate"];
		$currentConfig = file_get_contents('/home/minecraft/server.properties');
		$config = ini2arr($currentConfig);

		$config['level-name'] = "saves/".$world;

		$newConfig = arr2ini($config);

		if(file_put_contents('/home/minecraft/server.properties', $newConfig)) {
			$msg = "<div class='info msg'><div class='content'>World \"".$world."\" was successfuly activated. Changes will be applied when the Minecraft Server restarts.</div> <a class='button' href='?restart=true&confirm=true'>restart</a></div>";
		} else {
			$msg .= "<div class='error'>Could not write to file.</div>";
		}
	}

	if(isset($_GET["delete"])) {
		$world = $_GET["delete"];
		if(isset($_GET["confirm"])) {
			shell_exec("sudo chmod -R 777 /home/minecraft/saves");
			rrmdir("/home/minecraft/saves/".$world);
			rrmdir("/home/minecraft/saves/".$world."_nether");
			rrmdir("/home/minecraft/saves/".$world."_the_end");
			$msg .= "<div class='success'>World \"".$world."\" was successfully deleted.</div>";
		} else {
			$msg .=  "<div class='warning msg'><div class='content'>Are you sure you want to delete world \"".$world."\"? This action is irreversible!</div> <a class='button' href='?delete=".$world."&confirm=true'>delete</a></div>";
		}
	}

	if(isset($_GET["restart"])) {
		if(isset($_GET["confirm"])) {
			restartMinecraft();
			$msg .= "<div class='success'>Minecraft server is restarting, this will only take a minute.</div>";
		}
	}

	function rrmdir($dir) {
		if (is_dir($dir)) {
			$objects = scandir($dir);
			foreach ($objects as $object) {
				if ($object != "." && $object != "..") {
					if (is_dir($dir."/".$object))
						rrmdir($dir."/".$object);
					else
						unlink($dir."/".$object);
				}
			}
			rmdir($dir);
		}
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
				<?php echo $msg?>
				<h2>Manage worlds</h2>
				<a href="upload.php" class="button">Upload world</a>
				<a href="createWorld.php" class="button">Create new world</a><br><br>
				<?php
					$currentConfig = file_get_contents('/home/minecraft/server.properties');
					$config = ini2arr($currentConfig);
					$selectedWorld = basename($config['level-name']);
				?>
				<table class="worlds-table">
				<?php
					$path = "/home/minecraft/saves";
					$files = array_diff(scandir($path), array('.', '..'));

					foreach ($files as $key => $value) {
						if(!endsWith($value, "_nether") && !endsWith($value, "_the_end")) {
							echo "<tr class='world-container'>";
							echo "<td class='name'>".$value."</td>";
							if($selectedWorld != $value) {
								echo "<td><a href='?delete=".$value."'><img src='res/delete.png' height='30' width='30'></a></td>";
								echo "<td><a href='download.php?world=".$value."' target='_blank' ><img src='res/download.png' height='30' width='30'></a></td>";
								echo "<td><a href='?activate=".$value."' class='small-button'>Activate</a></td>";
							} else {
								echo "<td colspan='3' style='text-align: right'>Activated</td>";
							}
							echo "</tr>";
						}
					}
				?>
			</div>
		</main>
	</body>
</html>
