<?php
	$location = basename($_SERVER["SCRIPT_FILENAME"], '.php');
?>
<header>
	<div class="max">
		<div class="top">
		<div class="logo-container"><img onclick="openNav()" src="res/menu.png" class="mobile-menu-button open-menu" width="32"><img src="res/logo.png" class="logo"></div>
		<a href="logout.php">Log out</a>
		</div>
		<div class="menu" id="menu">
			<a href="javascript:void(0)" onclick="closeNav()" class="mobile-menu-button closebtn">&times;</a>
			<a href="index.php" <?php if($location == "index")echo "class='selected'"?>>Server info</a>
			<a href="administration.php" <?php if($location == "administration")echo "class='selected'"?>>Settings</a>
			<a href="mcsconfig.php" <?php if($location == "mcsconfig")echo "class='selected'"?>>Minecraft Configuration</a>
			<a href="worlds.php" <?php if($location == "worlds" || $location == "createWorld" || $location == "upload")echo "class='selected'"?>>World Configuration</a>
			<a href="parental.php" <?php if($location == "parental")echo "class='selected'"?>>Time restriction</a>
			<a href="rcon.php" <?php if($location == "rcon")echo "class='selected'"?>>Server Console</a>
		</div>
		<script>
			function closeNav(){
				document.getElementById("menu").className = "menu";
			}

			function openNav(){
				document.getElementById("menu").className = "menu open";
			}
			window.addEventListener("load", function(){
				document.getElementsByTagName('main')[0].addEventListener("click", closeNav);
			});
		</script>
	</div>
</header>
