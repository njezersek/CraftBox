<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "functions.php";

session_start();
if(!isset($_SESSION['user'])){
    header("location: login.php");
    die();
}

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
if($ok){
  $newConfig = arr2ini($config);

  file_put_contents('/home/minecraft/server.properties', $newConfig);
  $msg .= "<div class='info msg'><div class='content'>Changes were saved and will be applied when the Minecraft Server restarts.</div> <a class='button' href='?restart=true&confirm=true'>Restart</a></div>";
}

if(isset($_GET["restart"])){
  if(isset($_GET["confirm"])){
    restartMinecraft();
    $msg .= "<div class='success'>Minecraft Server is restarting, this will only take a minute.</div>";
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
      <?php echo $msg; ?>
      <h2>Minecraft Server Configuration</h2>
      <form action="mcsconfig.php" method="post">

      <div class="option-container">
				<div class="info-container">
					<label class="property">Allow flight</label>
					<div class="help">Allows users to use flight on your server while in Survival mode, if they have a mod that provides flight.</div>
				</div>
				<div class="input-container">
					<label class="switch">
						<input type="checkbox" <?php if($config['allow-flight'] == "true")echo "checked"?> onchange="document.getElementById('allow-flight').value = this.checked+''">
						<span class="slider round"></span>
					</label>
					<input type="hidden" name="allow-flight" id="allow-flight" value="<?php echo $config['allow-flight']; ?>">
				</div>
			</div>

			<div class=option-container>
				<div class="info-container">
					<label class="property">Allow Nether</label>
					<div class="help">Allows players to travel to the Nether.</div>
				</div>
				<div class="input-container">
					<label class="switch">
						<input type="checkbox" <?php if($config['allow-nether'] == "true")echo "checked"?> onchange="document.getElementById('allow-nether').value = this.checked+''">
						<span class="slider round"></span>
					</label>
					<input type="hidden" name="allow-nether" id="allow-nether" value="<?php echo $config['allow-nether']; ?>">
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
					<label class="property">Force gamemode</label>
					<div class="help">Force players to join in the default game mode.</div>
				</div>
				<div class="input-container">
					<label class="switch">
						<input type="checkbox" <?php if($config['force-gamemode'] == "true")echo "checked"?> onchange="document.getElementById('force-gamemode').value = this.checked+''">
						<span class="slider round"></span>
					</label>
					<input type="hidden" name="force-gamemode" id="force-gamemode" value="<?php echo $config['enable-command-block']; ?>">
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
					<label class="property">Max players</label>
					<div class="help">The maximum number of players that can play on the server at the same time. Note that if more players are on the server it will use more resources.</div>
				</div>
				<div class="input-container">
					<input type="number" name="max-players" value="<?php echo $config['max-players']; ?>">
				</div>
			</div>

			<div class="option-container">
				<div class="info-container">
					<label class="property">MOTD</label>
					<div class="help">This is the message that is displayed in the server list of the client, below the name.</div>
				</div>
				<div class="input-container">
					<input type="text" name="motd" value="<?php echo $config['motd']; ?>">
				</div>
			</div>

			<div class="option-container">
				<div class="info-container">
					<label class="property">PvP</label>
					<div class="help">Enable PvP (Player versus Player) on the server. Defines if players can kill eachother on the server.</div>
				</div>
				<div class="input-container">
					<label class="switch">
						<input type="checkbox" <?php if($config['pvp'] == "true")echo "checked"?> onchange="document.getElementById('pvp').value = this.checked+''">
						<span class="slider round"></span>
					</label>
					<input type="hidden" name="pvp" id="pvp" value="<?php echo $config['pvp']; ?>">
				</div>
			</div>

			<div class="option-container">
				<div class="info-container">
					<label class="property">Spawn animals</label>
					<div class="help">Determines if animals will be able to spawn.</div>
				</div>
				<div class="input-container">
					<label class="switch">
						<input type="checkbox" <?php if($config['spawn-animals'] == "true")echo "checked"?> onchange="document.getElementById('spawn-animals').value = this.checked+''">
						<span class="slider round"></span>
					</label>
					<input type="hidden" name="spawn-animals" id="spawn-animals" value="<?php echo $config['spawn-animals']; ?>">
				</div>
			</div>

			<div class="option-container">
				<div class="info-container">
					<label class="property">Spawn monsters</label>
					<div class="help">Determines if monsters will be able to spawned.</div>
				</div>
				<div class="input-container">
					<label class="switch">
						<input type="checkbox" <?php if($config['spawn-monsters'] == "true")echo "checked"?> onchange="document.getElementById('spawn-monsters').value = this.checked+''">
						<span class="slider round"></span>
					</label>
					<input type="hidden" name="spawn-monsters" id="spawn-monsters" value="<?php echo $config['spawn-monsters']; ?>">
				</div>
			</div>

			<div class="option-container">
				<div class="info-container">
					<label class="property">Spawn npcs</label>
					<div class="help">Determines if villagers will be able to spawned.</div>
				</div>
				<div class="input-container">
					<label class="switch">
						<input type="checkbox" <?php if($config['spawn-npcs'] == "true")echo "checked"?> onchange="document.getElementById('spawn-npcs').value = this.checked+''">
						<span class="slider round"></span>
					</label>
					<input type="hidden" name="spawn-npcs" id="spawn-npcs" value="<?php echo $config['spawn-npcs']; ?>">
				</div>
			</div>
			<br>
        <input type="submit" value="Save" class="button">
      </form>
    </div>
  </main>
</body>
</html>
