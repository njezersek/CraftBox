<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if(!isset($_SESSION['user'])){
    header("location: login.php");
    die();
}

require "functions.php";

$currentConfig = file_get_contents('/home/minecraft/server.properties');
$config = ini2arr($currentConfig);

$msg = "";
$ok = false;
foreach($config as $property => $value){
  if(isset($_POST[$property])){
    $config[$property] = $_POST[$property];
    $ok = true;
  }
}
if(isset($_POST['level-name-unescaped'])){
  $level_name = $_POST['level-name-unescaped'];
  if(preg_match("/[^a-zA-Z0-9]+/", $level_name)){
    $ok = false;
    $msg .= "<div class='error'>World name must only contain alphanumerical characters.</div>";
  }
}
if($ok){
	$config['level-name'] = "saves/".$level_name;
  $newConfig = arr2ini($config);

  file_put_contents('/home/minecraft/server.properties', $newConfig);
	restartMinecraft();

  $msg = "<div class='info'>Minecraft server is now restarting and generating the world, this will only take a minute.</div>";

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
			<a href="worlds.php" class="back"><img src="res/back.png" width="32px">Back to World configuration</a>
			<?php echo $msg; ?>
      <h2>Create new world</h2>

      <form action="createWorld.php" method="post">
				<div class="option-container">
					<div class="info-container">
						<label class="property">World name</label>
						<div class="help">Choose a unique name for your world. Only alphanumerical characters are allowed.</div>
					</div>
					<div class="input-container">
						<input type="text" name="level-name-unescaped" value="">
					</div>
				</div>

				<div class="option-container">
					<div class="info-container">
						<label class="property">Difficulty</label>
		        <div class="help">Defines the difficulty of the server, such as damage dealt by mobs or the way hunger and poison affect players.</div>
					</div>
					<div class="input-container">
						<select name="difficulty">
		          <option value="0" <?php if($config['difficulty'] == "0") echo "selected"; ?>>0 - Peaceful</option>
		          <option value="1" <?php if($config['difficulty'] == "1") echo "selected"; ?>>1 - Easy</option>
		          <option value="2" <?php if($config['difficulty'] == "2") echo "selected"; ?>>2 - Normal</option>
		          <option value="3" <?php if($config['difficulty'] == "3") echo "selected"; ?>>3 - Hard</option>
		        </select>
					</div>
				</div>

				<div class="option-container">
					<div class="info-container">
						<label class="property">Gamemode</label>
		        <div class="help">Defines the mode of gameplay.</div>
					</div>
					<div class="input-container">
						<select name="gamemode">
		          <option value="0" <?php if($config['gamemode'] == "0") echo "selected"; ?>>0 - Survival</option>
		          <option value="1" <?php if($config['gamemode'] == "1") echo "selected"; ?>>1 - Creative</option>
		          <option value="2" <?php if($config['gamemode'] == "2") echo "selected"; ?>>2 - Adventure</option>
		          <option value="3" <?php if($config['gamemode'] == "3") echo "selected"; ?>>3 - Spectator</option>
		        </select>
					</div>
				</div>

				<div class="option-container">
					<div class="info-container">
						<label class="property">Generate structures</label>
		        <div class="help">Defines whether structures, such as villages, will be generated.</div>
					</div>
					<div class="input-container">
						<label class="switch">
		        <input type="checkbox" <?php if($config['generate-structures'] == "true")echo "checked"?> onchange="document.getElementById('generate-structures').value = this.checked+''">
		        <span class="slider round"></span>
		        </label>
		        <input type="hidden" name="generate-structures" id="generate-structures" value="<?php echo $config['generate-structures']; ?>">
					</div>
				</div>

				<div class="option-container">
					<div class="info-container">
						<label class="property">Generator settings</label>
		        <div class="help">The setting used to customize world generation, such as Superflat. If you are using this setting, make sure to set level type to CUSTOMIZED.</div>
					</div>
					<div class="input-container">
						<input type="text" name="generator-settings" value="">
					</div>
				</div>

				<div class="option-container">
					<div class="info-container">
						<label class="property">Hardcore</label>
						<div class="help">If set to true, players will be set to spectator mode if they die. In other words, players won't be able to respawn after dying.</div>
					</div>
					<div class="input-container">
						<label class="switch">
		        <input type="checkbox" <?php if($config['hardcore'] == "true")echo "checked"?> onchange="document.getElementById('hardcore').value = this.checked+''">
		        <span class="slider round"></span>
		        </label>
		        <input type="hidden" name="hardcore" id="hardcore" value="<?php echo $config['hardcore']; ?>">
					</div>
				</div>

				<div class="option-container">
					<div class="info-container">
						<label class="property">Level seed</label>
		        <div class="help">Select a seed for your world. For a list of player submitted seeds visit <a style="text-decoration:none; color:#16c8fc;" href="http://www.minecraftseeds.info/">MinecraftSeeds.info</a></div>
					</div>
					<div class="input-container">
	        	<input type="text" name="level-seed" value="">
					</div>
				</div>

				<div class="option-container">
					<div class="info-container">
						<label class="property">Level type</label>
						<div class="help">Determines the type of map that is generated.</div>
					</div>
					<div class="input-container">
						<select name="level-type">
							<option value="DEFAULT" selected>DEFAULT</option>
							<option value="FLAT">FLAT</option>
							<option value="LARGEBIOMES">LARGEBIOMES</option>
							<option value="AMPLIFIED">AMPLIFIED</option>
							<option value="CUSTOMIZED">CUSTOMIZED</option>
						</select>
					</div>
				</div>

				<br>
						<input type="submit" value="Create New World (This will restart the server)" class="button">



      </div>
    </form>
  </main>
</body>
</html>
